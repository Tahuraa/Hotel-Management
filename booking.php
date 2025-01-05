<?php
include 'dbconnect.php';
session_start();
$paymentStatus = null;
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    
    exit;
}

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve the data sent from the form
    $room_id = $_POST['room_id'];
    $price = $_POST['price'];
    $type = $_POST['type'];
    $guest= $_POST['guest'];
    $username = $_POST['username'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $totalNights = $_POST['totalNights'];
    $total_price= $_POST['totalprice'];
    

    


    if (isset($_POST['make_payment'])) {
        // Fetch user's GPay balance
        $wallet_query = "SELECT Gpay_balance FROM guest WHERE username = '$username'";
        $wallet_result = mysqli_query($con, $wallet_query);
        $wallet_row = mysqli_fetch_assoc($wallet_result);
        if ($wallet_row) {
            $wallet_balance = $wallet_row['Gpay_balance'];

            if ($wallet_balance >= $total_price) {
                // Deduct the total price from the wallet
                $new_balance = $wallet_balance - $total_price;
                $update_wallet_query = "UPDATE guest SET Gpay_balance = $new_balance WHERE username = '$username'";
                mysqli_query($con, $update_wallet_query);

                //insert into reservation table
                $insert_reservation_query = "INSERT INTO reservation (`room_id`, `username`, `checkin`, `checkout`, `total`, `duration`,`guest`)
                                             VALUES ('$room_id', '$username', '$checkin', '$checkout', '$total_price', '$totalNights','$guest')";
                if (mysqli_query($con, $insert_reservation_query)) {
                    $paymentStatus = "success";
                    
                    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            showPopup('Payment Successful', 'Your reservation has been confirmed!');
        });
    </script>";
                   
                    
                    
        

                    
                }
            } else {
                
                $paymentStatus = "insufficient";
                echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            showPopup('Insufficient Balance!');
        });
    </script>";
            }
        } else {

            
        
            $paymentStatus = "error";
            echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            showPopup('Error Occured!');
        });
    </script>";
        }
    }
}else {
    echo "No reservation data received.";
    
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="booking.css">
    <link rel="stylesheet" href="nav2.css">

    <!-- CSS for Popup -->
<style>
    .popup {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        backdrop-filter: blur(10px); /* Adds a smooth blur to the background */
        background-color: rgba(0, 0, 0, 0.3); /* Slight transparent overlay */
        z-index: 1000;
        opacity: 0;
        visibility: hidden;
        transition: opacity 0.3s ease, visibility 0.3s ease;
    }

    .popup.show {
        opacity: 1;
        visibility: visible;
    }

    .popup-content {
        background: linear-gradient(145deg, #f9f9f9, #ffffff); /* Light gradient for a clean look */
        padding: 30px 40px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        font-family: 'Poppins', sans-serif;
        color: #444;
        transform: translateY(-20px);
        animation: slideIn 0.3s ease forwards;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-50px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .popup-content h2 {
        margin-bottom: 15px;
        font-size: 26px;
        color: #333;
        font-weight: bold;
    }

    .popup-content p {
        margin-bottom: 25px;
        font-size: 18px;
        line-height: 1.6;
        color: #555;
    }

    .popup-content button {
        background: #6c63ff; /* Vibrant modern color */
        color: #fff;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        transition: background 0.3s ease, transform 0.2s ease;
    }

    .popup-content button:hover {
        background: #574de8;
        transform: scale(1.05);
    }

    .popup-content button:active {
        transform: scale(0.95);
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

<div class="reservation-form">
    <h2>Your Reservation</h2>
    <form id="reservationDetails">
        <div class="form-group">
            <label for="roomType">Room Type:</label>
            <input type="text" id="roomType" value="<?php echo $type; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="price">Price:</label>
            <input type="text" id="price" value="$<?php echo $price; ?>" readonly>
        </div>
        <div class="form-group">
            <label for="duration">Duration:</label>
            <input type="text" id="duration" value="<?php echo $totalNights;?> Nights" readonly>
        </div>
        <div class="form-group">
            <label for="total">Total:</label>
            <input type="text" id="total" value="$<?php echo $total_price;?>" readonly>
        </div>
        <div class="form-group">
            <label for="checkin">Checkin:</label>
            <input type="text" id="checkin" value="$<?php echo $checkin;?>" readonly>
        </div>
        <div class="form-group">
            <label for="checkout">Checkout:</label>
            <input type="text" id="checkout" value="$<?php echo $checkout;?>" readonly>
        </div>
        
    </form>

    <!-- Payment Button -->
    <?php 
        echo "<form action='booking.php' method='POST'>
        <input type='hidden' name='room_id' value='". $room_id ."'>
        <input type='hidden' name='price' value='". $price ."'>
        <input type='hidden' name='type' value='". $type ."'>
        <input type='hidden' name='guest' value='". $guest ."'>
        <input type='hidden' name='username' value='". $_SESSION['username'] ."'>
        <input type='hidden' name='checkin' value='". $_POST['checkin'] ."'>
        <input type='hidden' name='checkout' value='". $_POST['checkout'] ."'>
        <input type='hidden' name='totalNights' value='". $totalNights ."'>
        <input type='hidden' name='totalprice' value='". $total_price ."'>
        <button type='submit' name='make_payment' class='btn'>Make Payment via GPay</button>
        </form>";

    ;
    ?>

    <!-- HTML Popup -->
<div id="popupBox" class="popup">
    <div class="popup-content">
        <h2 id="popupTitle"></h2>
        <p id="popupMessage"></p>
        <button onclick="closePopup()">OK</button>
    </div>
</div>
    

    
    
</div>





<script>
    // Function to show the popup
    function showPopup(title, message) {
        const popup = document.getElementById('popupBox');
        document.getElementById('popupTitle').textContent = title;
        document.getElementById('popupMessage').textContent = message;
        popup.classList.add('show');
    }

    function closePopup() {
        const popup = document.getElementById('popupBox');
        popup.classList.remove('show');
        setTimeout(() => {
            window.location.href = 'welcome.php'; // Redirect to welcome page
        }, 300); // Slight delay for smooth closing
    }

</script>







</body>
</html>
