<?php
include 'dbconnect.php'; // Include the database connection
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] ){
             
 
    header("location: welcome.php");
    exit();
}



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    
    $city = $_POST['city'];
    $gpay = $_POST['Gpay'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    //servaer validation 
    if (!preg_match('/^[a-zA-Z](?!.*[._]{2})[a-zA-Z0-9._]{2,}[a-zA-Z0-9]$/', $username)) {
    die('Username must start with a letter.');
}

if (!preg_match('/^[a-zA-Z]+$/', $fname)) {
    die('First name must contain only letters.');
}

if (!preg_match('/^[a-zA-Z]+$/', $lname)) {
    die('Last name must contain only letters.');
}

if (!preg_match('/^[a-zA-Z]+(?:\s[a-zA-Z]+)*$/', $city)) {
    die('City name must contain only letters.');
}

if (!preg_match('/^01\d{9}$/', $gpay)) {
    die('Gpay number must start with 01 and be 11 digits long.');
}

if (strlen($password) !== 4) {
    die('Password must be 4 characters long.');
}


    // Validate passwords
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // Check if the username already exists
    $check_username = "SELECT * FROM guest WHERE username = '$username'";
    
    $result = mysqli_query($con,$check_username);

    if ($result->num_rows > 0) {
        
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            showPopup('Username Taken,Please choose another username.');
        });
    </script>";
    
        
    }

    
    // Insert data into the database
    $sql = "INSERT INTO `guest` (`username`, `password`, `fname`, `lname`, `city`,`Gpay`, `Gpay_balance`)
            VALUES ('$username', '$password', '$fname', '$lname', '$city','$gpay',10000)";
    $result1 = mysqli_query($con,$sql);

    if ($result1){
        echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            showPopup('Congratulations! You are now a prestigious member of our hotel.');
        });
    </script>";
    
        
    }
    
    

}

    

    
    
    
    




?>





<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movenpick Hotel & Resort</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="nav2.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        

        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
        }

        .success-message {
            color: green;
            font-size: 14px;
            margin-top: 10px;
        }

        input.error-border {
            border: 1px solid red;
        }
    </style>

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
        <a href="login.php">Guest Login</a>
        <a href="admin_login.php">Admin</a>
    </nav>
</header>

   

    <section class="hero">
        <div class="booking-form">
            <h2>REGISTER IN OUR HOTEL</h2>
            <form id="registrationForm" action="home.php" method="POST">
                <label for="first-name">First Name:</label>
                <input type="text" id="first-name" name="first_name" placeholder="First Name" required>
                <span id="fname-error" class="error"></span>

                <label for="last-name">Last Name:</label>
                <input type="text" id="last-name" name="last_name" placeholder="Last Name" required>
                <span id="lname-error" class="error"></span>

                <label for="city">City:</label>
                <input type="text" id="city" name="city" placeholder="City" required>
                <span id="city-error" class="error"></span>

                <label for="Gpay">Gpay Number:</label>
                <input type="text" id="Gpay" name="Gpay" placeholder="Gpay" required>
                <span id="gpay-error" class="error"></span>

                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Username" required>
                <span id="username-error" class="error"></span>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <span id="password-error" class="error"></span>

                <label for="confirm-password">Confirm Password:</label>
                <input type="password" id="confirm-password" name="confirm_password" placeholder="Confirm Password" required>
                <span id="confirm-password-error" class="error"></span>

                <button type="submit" class="check-btn">Register Now</button>
                <div id="form-error" class="error"></div>
            </form>
        </div>

        <!-- HTML Popup -->
<div id="popupBox" class="popup">
    <div class="popup-content">
        <h2 id="popupTitle"></h2>
        <p id="popupMessage"></p>
        <button onclick="closePopup()">OK</button>
    </div>
</div>
    </section>

    <script>
        const form = document.getElementById('registrationForm');

        form.addEventListener('submit', (e) => {
            const fname = document.getElementById('first-name');
            const lname = document.getElementById('last-name');
            const city = document.getElementById('city');
            const gpay = document.getElementById('Gpay');
            const username = document.getElementById('username');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm-password');

            let isValid = true;

            // Reset error messages
            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            // First name validation
            if (!/^[a-zA-Z]+$/.test(fname.value)) {
                document.getElementById('fname-error').textContent = 'First name must contain only letters.';
                fname.classList.add('error-border');
                isValid = false;
            } else {
                fname.classList.remove('error-border');
            }

            // Last name validation
            if (!/^[a-zA-Z]+$/.test(lname.value)) {
                document.getElementById('lname-error').textContent = 'Last name must contain only letters.';
                lname.classList.add('error-border');
                isValid = false;
            } else {
                lname.classList.remove('error-border');
            }

            // City validation
            if (!/^[a-zA-Z]+(?:\s[a-zA-Z]+)*$/.test(city.value)) {
                document.getElementById('city-error').textContent = 'City name must contain only letters.';
                city.classList.add('error-border');
                isValid = false;
            } else {
                city.classList.remove('error-border');
            }

            // Gpay validation
            if (!/^01\d{9}$/.test(gpay.value)) {
                document.getElementById('gpay-error').textContent = 'Gpay number must start with 01 and be 11 digits.';
                gpay.classList.add('error-border');
                isValid = false;
            } else {
                gpay.classList.remove('error-border');
            }

            // Username validation
            if (!/^[a-zA-Z](?!.*[._]{2})[a-zA-Z0-9._]{2,}[a-zA-Z0-9]$/.test(username.value)) {
                document.getElementById('username-error').textContent = 'Username must start with a letter,contains number,letters,underscore,period, cannnot have any space,must be at least 4 characters long';
                username.classList.add('error-border');
                isValid = false;
            } else {
                username.classList.remove('error-border');
            }

            // Password validation
            if (password.value.length !== 4) {
                document.getElementById('password-error').textContent = 'Password must be 4 characters long.';
                password.classList.add('error-border');
                isValid = false;
            } else {
                password.classList.remove('error-border');
            }

            // Confirm password validation
            if (password.value !== confirmPassword.value) {
                document.getElementById('confirm-password-error').textContent = 'Passwords do not match.';
                confirmPassword.classList.add('error-border');
                isValid = false;
            } else {
                confirmPassword.classList.remove('error-border');
            }

            if (!isValid) {
                e.preventDefault(); // Prevent form submission
                document.getElementById('form-error').textContent = 'Please fix the errors above and try again.';
            }
        });
    </script>



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
        
    }

</script>
</body>
</html>
