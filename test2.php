<?php
include 'dbconnect.php';
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    
    exit;
}



$current_username = $_SESSION['username'];

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';


// Fetch reservation details with room information
if ($filter === 'all') {
$query = "SELECT r.reservation_id, r.room_id, r.checkin, r.checkout, r.duration, r.total, rm.type AS room_type,rm.guest FROM reservation r
          INNER JOIN rooms rm ON r.room_id = rm.room_id
          WHERE r.username = '$current_username'
          ORDER BY checkin ASC";}
elseif ($filter === 'previous') {
 $query = "SELECT r.reservation_id, r.room_id, r.checkin, r.checkout, r.duration, r.total, rm.type AS room_type,rm.guest FROM reservation r
    INNER JOIN rooms rm ON r.room_id = rm.room_id
    WHERE r.username = '$current_username' AND r.checkout < CURDATE()
    ORDER BY checkin ASC";}
elseif ($filter === 'ongoing') {
$query = "SELECT r.reservation_id, r.room_id, r.checkin, r.checkout, r.duration, r.total, rm.type AS room_type , rm.guest
    FROM reservation r
    INNER JOIN rooms rm ON r.room_id = rm.room_id
    WHERE r.username = '$current_username' AND CURDATE() BETWEEN r.checkin AND r.checkout
    ORDER BY checkin ASC";}
elseif ($filter === 'upcoming') {
$query = "SELECT r.reservation_id, r.room_id, r.checkin, r.checkout, r.duration, r.total, rm.type AS room_type , rm.guest
    FROM reservation r
    INNER JOIN rooms rm ON r.room_id = rm.room_id
    WHERE r.username = '$current_username' AND r.checkin > CURDATE()
    ORDER BY checkin ASC";}

elseif ($filter === 'cancel') {
    $query = "SELECT r.reservation_id, r.room_id, r.checkin, r.checkout, r.duration, r.total, rm.type AS room_type , rm.guest
        FROM canceled r
        INNER JOIN rooms rm ON r.room_id = rm.room_id
        WHERE r.username = '$current_username' 
        ORDER BY checkin ASC";}





$result = mysqli_query($con, $query);
if (! $result) {
    echo ''. mysqli_error($con);
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Reservations</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="nav2.css">
    <style>
        /* General Styling */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            /* display: flex;
            height: 100vh; */
        }

        /* Left Sidebar (Vertical Tab) */
        .sidebar {
            width: 200px;
            background-color: #fff;
            color: #fff;
            padding-top: 30px;
            position: fixed;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar a {
            text-decoration: none;
            color: #000;
            padding: 15px 20px;
            text-align: center;
            width: 100%;
            margin: 10px 0;
            border-radius: 5px;
            font-size: 18px;
            transition: background 0.3s;
        }

        .sidebar a:hover, .sidebar .active-tab {
            background-color: #808080;
        }

        /* Main Content Area */
        .content {
            margin-left: 220px;
            width: calc(100% - 220px);
            padding: 30px;
            display: flex;
            flex-direction: column;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #9A7B4F;
        }

        /* Reservation Cards */
        .reservation-card {
            display: flex;
            background: #fff;
            margin: 20px 0;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.2s;
        }

        .reservation-card:hover {
            transform: scale(1.02);
        }

        .room-image {
            width: 40%;
            background-size: cover;
            background-position: center;
        }

        .reservation-details {
            padding: 20px;
            flex: 1;
        }

        .reservation-details h2 {
            margin: 0 0 10px;
            font-size: 24px;
        }

        .reservation-details p {
            margin: 5px 0;
            font-size: 16px;
        }

        .reservation-details .highlight {
            color: #9A7B4F;
            font-weight: 600;
        }

        .reservation-actions {
            text-align: right;
            margin-top: 20px;
        }

        .reservation-actions a {
            text-decoration: none;
            background: #2b8a3e;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.3s;
        }

        .reservation-actions a:hover {
            background: #23732f;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                display: flex;
                justify-content: space-around;
            }

            .sidebar a {
                width: 100px;
                padding: 10px;
            }

            .content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<header>
<nav>
    <a href="logout.php">Home</a>
    <a href="About/our-room.php">Our Rooms</a>
    <a href="About/blog.php">Blog</a>
     <a href="About/about.php">About</a>

        
    </nav>
        <div class="logo">
        <h1>Mövenpick</h1>
        <h2>Hotel & Resort</h2>
    </div>
        
        

        <nav>
            <a href="profile.php">I am <?php echo $_SESSION['username'];?></a>
            <a href="test2.php">My Bookings</a>
            <a href="welcome.php">Check Availability</a>
            
        </nav>
    </header>

    
    <div class="sidebar">
    <a href="?filter=all" class="<?= $filter === 'all' ? 'active' : '' ?>">All</a>
    <a href="?filter=upcoming" class="<?= $filter === 'upcoming' ? 'active' : '' ?>">Upcoming</a>
    <a href="?filter=ongoing" class="<?= $filter === 'ongoing' ? 'active' : '' ?>">Ongoing</a>
    <a href="?filter=previous" class="<?= $filter === 'previous' ? 'active' : '' ?>">Previous</a>
    <a href="?filter=cancel" class="<?= $filter === 'cancel' ? 'active' : '' ?>">Canceled</a>

</div>

    <!-- Main Content Area (Reservation Cards) -->
    <div class="content">
        <h1>My Reservations</h1>

        <!-- test############# -->

        <?php

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // $room_image = $row['room_picture'];
        $room_id = $row['room_id'];
        $room_type = $row['room_type'];
        $checkin = $row['checkin'];
        $checkout = $row['checkout'];
        $duration = $row['duration'];
        $total = $row['total'];
        $reservation_id = $row['reservation_id'];
        $guest = $row['guest'];
?>

<div class="reservation-card">
    <div class="room-image" style="background-image: url('sea.jpg');"></div>
    <div class="reservation-details">
       <h2>Room Number: <span class="highlight"><?php echo $room_id; ?></span></h2>
        <h2><span class="highlight"><?php echo $room_type; ?></span></h2>
        <p>Check-in: <span class="highlight"><?php echo $checkin; ?></span></p>
        <p>Check-out: <span class="highlight"><?php echo $checkout; ?></span></p>
        <p>Duration: <span class="highlight"><?php echo $duration; ?> Nights</span></p>
        <p>Total Cost: <span class="highlight">$<?php echo $total; ?></span></p>
        <p>Guest: <span class="highlight"><?php echo $guest; ?></span></p>

        <!-- <div class="reservation-actions">
            <a href="cancel_reservation.php?id=<?php echo $reservation_id; ?>">Cancel Reservation</a>
        </div> -->
    </div>
</div>

<?php
    }
} else {
    echo "<p>No reservations found.</p>";
}
?>


    </div>



    

</body>
</html>
