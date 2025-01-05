<?php
include 'dbconnect.php';
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    
    exit;
}

$show = False ;
$num = 0;
$result = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $guest = $_POST['guest'];
    

    $checkinDate = new DateTime($checkin);
    $checkoutDate = new DateTime($checkout);
    
    // Calculate the difference between the dates
    $interval = $checkinDate->diff($checkoutDate);
    $totalNights = $interval->days; // Total number of nights
    if (!empty($checkin) && !empty($checkout)) {
        // Database query to fetch available rooms
        // echo 'room found successful' ;
        $sql = "SELECT r.room_id, r.floor, r.price , r.type, r.guest FROM rooms r
                WHERE r.room_id NOT IN (
                SELECT res.room_id
                FROM reservation res
                WHERE (res.checkin < '$checkin' AND res.checkout >= '$checkin' ) OR 
                (res.checkin >= '$checkin' AND res.checkin <= '$checkout' )) and r.guest='$guest' ;";
        
        $result =  mysqli_query($con, $sql) ;
        // $row = mysqli_fetch_assoc($result) ;
        $num = mysqli_num_rows($result) ;
        if ($result) {
            
            $show = true;
        };
    }; 
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movenpick Hotel & Resort</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="nav2.css">

    <!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
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



    <div class="container">
        <div class="reservation-panel">
            <h2>Your Reservation</h2>
            <p>Room:</p>
            <form action="process_reservation.php" method="POST" onsubmit="return validateDates()">
                <label for="checkin">Check-In</label>
                <input type="date" id="checkin" name="checkin" value="<?php echo isset($_POST['checkin']) ? htmlspecialchars($_POST['checkin']) : date('Y-m-d'); ?>"
 required><br><br>
 <span id="checkin-error" style="color: red;"></span><br>

                <label for="checkout">Check-Out</label>
                <input type="date" id="checkout" name="checkout" value="<?php echo isset($_POST['checkout']) ? htmlspecialchars($_POST['checkout']) : date('Y-m-d'); ?>"
 required><br><br>
 <span id="checkout-error" style="color: red;"></span><br>
 <label for="guest">Guest</label>
<select id="guest" name="guest" required>
    <option value="1" <?php echo (isset($_POST['guest']) && $_POST['guest'] == "1") ? 'selected' : ''; ?>>1</option>
    <option value="2" <?php echo (isset($_POST['guest']) && $_POST['guest'] == "2") ? 'selected' : ''; ?>>2</option>
    
</select><br><br>


                

                <button class="btn" type="submit">Update Reservation</button>
            </form>

            <script>
        function validateDates() {
    const checkinError = document.getElementById("checkin-error");
    const checkoutError = document.getElementById("checkout-error");

    const checkin = document.getElementById("checkin").value;
    const checkout = document.getElementById("checkout").value;
    const today = new Date().toISOString().split("T")[0];

    // Clear previous errors
    checkinError.textContent = "";
    checkoutError.textContent = "";

    // Validate empty fields
    if (!checkin || !checkout) {
        checkinError.textContent = "Please fill in both check-in and check-out dates.";
        return false;
    }

    // Validate check-in date
    if (checkin < today) {
        checkinError.textContent = "Check-in date cannot be in the past.";
        return false;
    }

    // Validate check-out date
    if (checkout <= checkin) {
        checkoutError.textContent = "Check-out date must be after the check-in date.";
        return false;
    }

    return true; // Validation successful
}


    document.addEventListener("DOMContentLoaded", function () {
    flatpickr("#checkin", {
        dateFormat: "Y-m-d",
        minDate: "today", // Prevent past dates
    });
    flatpickr("#checkout", {
        dateFormat: "Y-m-d",
        minDate: "today", // Prevent past dates
    });
});

        
    </script>
        </div>

        <div class="rooms-list">
            <?php
            // Replace with your database connection
            if ($show == True) {
                echo '<div class="section">
            <h2>Available Rooms:'. $num .' </h2> </div>';

                while ($row = mysqli_fetch_assoc($result)) {
                    $price = $row['price']*$totalNights;

            
                    echo "<div class='room'>";
                    if ($row["type"] == 'superior room') {
                        echo "<img src='superior.jpg' alt='Room Image'>";
                    }
                    elseif ($row["type"] == "special room") {
                        echo "<img src='special.jpg' alt='Room Image'>";
                    }
                    elseif ($row["type"] == "sea view") {
                        echo "<img src='sea.jpg' alt='Room Image'>";
                    }
                    elseif ($row["type"] == "city view") {
                        echo "<img src='city.jpg' alt='Room Image'>";
                    }
                    else  {
                        echo "<img src='room.jpg' alt='Room Image'>";
                    }

                    // echo "<img src='room2.jpg' alt='Room Image'>"; 
                    echo "<div class='room-details'>";
                    echo "<h3>{$row['room_id']}</h3>";
                    echo "<p>{$row['type']}</p>";
                    echo "<p>Total nights/Total price: $totalNights Nights || <b>$</b>$price </p>";
                    echo "<p>Guest: {$row['guest']}</p>";
                    echo "</div>";
                    echo "<div class='room-price'>";
                    echo "<span>\${$row['price']}</span><br>";
                    echo "<form action='booking.php' method='POST'>
                    <input type='hidden' name='room_id' value='". $row['room_id'] ."'>
                    <input type='hidden' name='price' value='". $row['price'] ."'>
                    <input type='hidden' name='type' value='". $row['type'] ."'>
                    <input type='hidden' name='guest' value='". $row['guest'] ."'>
                    <input type='hidden' name='username' value='". $_SESSION['username'] ."'>
                    <input type='hidden' name='checkin' value='". $_POST['checkin'] ."'>
                    <input type='hidden' name='checkout' value='". $_POST['checkout'] ."'>
                    <input type='hidden' name='totalNights' value='". $totalNights ."'>
                    <input type='hidden' name='totalprice' value='". $price ."'>
                    <button class='btn'>Select</button>
                    </form>";
                    echo "</div>";
                    echo "</div>";
                }
            } ;
            ?>
        </div>
    </div>
</body>
</html>


