<?php
include 'dbconnect.php';
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$totalRevenueQuery = "SELECT SUM(total) AS total_revenue FROM reservation";
$totalBookingsQuery = "SELECT COUNT(*) AS total_bookings FROM reservation";
$totalGuestsQuery = "SELECT SUM(guest) AS total_guests FROM reservation";
$totalRevenue = $con->query($totalRevenueQuery)->fetch_assoc()['total_revenue'] ?? 0;
$totalBookings = $con->query($totalBookingsQuery)->fetch_assoc()['total_bookings'] ?? 0;
$totalGuests = $con->query($totalGuestsQuery)->fetch_assoc()['total_guests'] ?? 0;

// Fetch all reservations
$reservationsQuery = "SELECT * FROM reservation";
$reservations = $con->query($reservationsQuery);

// Handle cancel request
// if (isset($_POST['cancel_reservation'])) {
    // $reservationId = $_POST['reservation_id'];
    // $cancelQuery = "DELETE FROM reservation WHERE reservation_id = $reservationId AND checkin > NOW()";
    // $con->query($cancelQuery);
    // header("Location: admin_dashboard.php");
    // exit;

// }



// Handle cancel request
if (isset($_POST['cancel_reservation'])) {
    $reservationId = $_POST['reservation_id'];

    // Fetch reservation details
    $fetchReservationQuery = "SELECT * FROM reservation WHERE reservation_id = $reservationId AND checkin > NOW()";
    $reservationResult = $con->query($fetchReservationQuery);

    if ($reservationResult && $reservationResult->num_rows > 0) {
        $reservation = $reservationResult->fetch_assoc();

        // Prepare data for insertion into the canceled table
        $username = $reservation['username']; // Ensure 'username' exists in the reservation table
        $roomId = $reservation['room_id'];   // Ensure 'room_id' exists in the reservation table
        $checkin = $reservation['checkin'];
        $checkout = $reservation['checkout'];
        $total = $reservation['total'];
        $duration = $reservation['duration'];
        $guest = $reservation['guest'];

        // Insert reservation into the canceled table
        $insertCanceledQuery = "INSERT INTO canceled (reservation_id, username, room_id, checkin, checkout, total, duration, guest)
                                VALUES ($reservationId, '$username', $roomId, '$checkin', '$checkout', $total, $duration, $guest)";
        $con->query($insertCanceledQuery);

        // Delete reservation from the reservation table
        $cancelQuery = "DELETE FROM reservation WHERE reservation_id = $reservationId";
        $con->query($cancelQuery);
        //refund money
        $updateUserBalanceQuery = "UPDATE guest SET Gpay_balance = Gpay_balance + $total 
            WHERE username = '$username'";
        $con->query($updateUserBalanceQuery);

    }

    // Redirect back to the admin dashboard
    header("Location: manage_r.php");
    exit;
}
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
<div class="container">
    
    <header>
    <h1>Reservation Data and Management</h1>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="staff.php">Staff Management</a></li>
                    <li><a href="event.php">Event Management</a></li>
                    <li><a href="logout.php">Logout</a></li>
                    

                </ul>
            </nav>
        </header>
        
    
<main>
    <!-- <div class="dashboard-overview"> -->
    <section class="quick-links">
        <div class="cards">
            <div class="card">
                <h3>Total Revenue</h3>
                
                <h3>$<?php echo number_format($totalRevenue, 2); ?></h3>
            </div>
            <div class="card">
                <h3>Total Bookings</h3>
                <h3><?php echo $totalBookings; ?></h3>
            </div>
            <div class="card">
                <h3>Total Guests</h3>
                <h3><?php echo $totalGuests; ?></h3>
            </div>
        </div>
    </section>
    <!-- </div> -->

    <h2>Reservation Details</h2>
    <table>
        <thead>
        <tr>
            <th>Reservation ID</th>
            <th>Username</th>
            <th>Room</th>
            <th>Guests</th>
            <th>Total Price</th>
            <th>Checkin || Checkout</th>
            
            <!-- <th>Duration</th> -->
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $reservations->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['reservation_id']; ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['room_id']; ?></td>
                <td><?php echo $row['guest']; ?></td>
                <td>$<?php echo number_format($row['total'], 2); ?></td>
                <td><?php echo $row['checkin']; ?>  ||  <?php echo $row['checkout']; ?></td>
                <td>
                    <?php if ($row['checkin'] > date('Y-m-d H:i:s')): ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="reservation_id" value="<?php echo $row['reservation_id']; ?>">
                            <button type="submit" name="cancel_reservation" class="delete-btn">Cancel</button>
                        </form>
                    <?php else: ?>
                        <span>Expired</span>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    </main>
</div>
</body>
</html>
