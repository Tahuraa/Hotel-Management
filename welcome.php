<?php
include 'dbconnect.php';
session_start();


if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    
    exit;
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
    <link rel="stylesheet" href="welcome.css">
    <link rel="stylesheet" href="nav2.css">

    <!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<style> 
    .hero {
            background: url('monalisa.jpg') no-repeat center center/cover;
            height: 500px;
            position: relative;
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

    <section class="hero">
       
    <form id="booking-form" action="process_reservation.php" method="POST" onsubmit="return validateDates()">
        <div class="form-container">
        
            <div>
                <label for="check-in">Check-In</label>
                <input type="date" id="checkin"  name="checkin" placeholder="Check-In Date" required>
                <span id="checkin-error" style="color: red;"></span><br>
                
            </div>
            <div>
                <label for="check-out">Check-Out</label>
                <input type="date" id="checkout"  name="checkout" placeholder="Check-Out Date" required>
                <span id="checkout-error" style="color: red;"></span><br>
                
            </div>
            <div>
                <label for="guest">Adults</label>
                <select name="guest" required>
                        <option value="">Select Guests</option>
                        <option value="1">1 Guest</option>
                        <option value="2">2 Guests</option>
                        
                    </select>
                
            </div>
            <button type="submit">Check Availability</button>
        
        </div>
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
    </section>

    



    <section class="about">
        <h1>Best place to enjoy your life</h1>
    </section>
</body>
</html>
