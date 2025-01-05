<?php
 // Start the session to store user data after successful login
 session_start();

 if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] ){
             
 
             header("location: welcome.php");
             exit();
         }
$login = false;
$showerror = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //  Include the database connection
    include 'dbconnect.php';

    // Get user input from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username already exists
    $check_username = "SELECT * FROM guest WHERE username = '$username'";
    // $result = $con->query($check_username);
    $result = mysqli_query($con,$check_username);
    $row = mysqli_fetch_assoc($result);
    $num = mysqli_num_rows($result) ;
    

    
    if ($num == 1){
        //    echo 'Invalid Credentials';


        
        if ($password == $row['password']){
            
            $login = true;
            // session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            echo $_SESSION['loggedin'].'';

            header("location: welcome.php");
            exit();

        }
        else{
            // $showError = "Invalid Credentials";
            // echo 'Invalid Credentials';
            $showError = "Invalid Credentials";
        }
        

        

        
        
        
    } 
    else{
        // $showError = "Invalid Credentials";
        // echo 'Invalid Credentials';
        $showError = "Invalid Credentials";

    }
}

    

   

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Movenpick </title>
    <link rel="stylesheet" href="login.css"> <!-- Link your CSS file -->
    
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="nav.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert2 -->
    <style> 
    /* Reset and base styles */

    .login-container {
    width: 100%;
    padding: 30px;
    background-color: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    text-align: center;
    margin-top: 20px;
    left: 50px;
}
.btn{
    color: #9A7B4F;
}

.btn:hover {
    background-color:rgb(38, 25, 6); 
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
            <a href="login.php">Guest login</a>
            <a href="admin_login.php">Admin login</a>
        </nav>
    </header>
    <div class="login-container">
        <h2>Login</h2>
        <form action="login.php" method="POST"> <!-- PHP action -->
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn">Login</button>
            </div>
        </form>
        <p class="register-link">Don't have an account? <a href="home.php">Register here</a></p>
    </div>


    <script>
        <?php if (isset($showError) && $showError): ?>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '<?php echo $showError; ?>',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'Try Again'
            });
        <?php endif; ?>
    </script>
</body>
</html>
