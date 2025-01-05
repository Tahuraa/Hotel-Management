<?php
include 'dbconnect.php';
session_start();
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
    header("location: login.php");
    
    exit;
}

// Retrieve user details
$username = $_SESSION['username']; 
$query = "SELECT * FROM guest WHERE username = '$username'";
$result = mysqli_query($con, $query);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="nav.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background: #f3f4f6;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 28px;
            /* color: #6c63ff; */
            color: #9A7B4F;
            margin: 0;
        }

        .profile-details {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .detail {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .detail-label {
            font-weight: bold;
            color: #555;
        }

        .detail-value {
            color: #777;
        }

        .update-btn {
            /* background: #6c63ff; */
            background: #9A7B4F;
            color: #fff;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .update-btn:hover {
            /* background: #574de8; */
            background:rgb(74, 46, 7);
        }

        .action {
            text-align: center;
            margin-top: 20px;
        }

        .action button {
            /* background: #ff6b6b; */
            background: #9A7B4F;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .action button:hover {
            /* background: #e55c5c; */
            background:rgb(50, 32, 6);

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
    <div class="container">
        <div class="header">
            <h1>My Profile</h1>
        </div>
    <div class="profile-details">
    <div class="detail">
        <span class="detail-label">Username:</span>
        <span class="detail-value"><?php echo htmlspecialchars($user['username']); ?></span>
        <button class="update-btn" onclick="updateField('username', 'Username', /^[a-zA-Z](?!.*[._]{2})[a-zA-Z0-9._]{2,}[a-zA-Z0-9]$/)">Update</button>
    </div>
    <div class="detail"> 
        <span class="detail-label">First Name:</span>
        <span class="detail-value"><?php echo htmlspecialchars($user['fname']); ?></span>
        <button class="update-btn" onclick="updateField('fname', 'First Name', /^[A-Za-z]+$/)">Update</button>
    </div>
    <div class="detail">
        <span class="detail-label">Last Name:</span>
        <span class="detail-value"><?php echo htmlspecialchars($user['lname']); ?></span>
        <button class="update-btn" onclick="updateField('lname', 'Last Name', /^[A-Za-z]+$/)">Update</button>
    </div>
    <div class="detail">
        <span class="detail-label">City:</span>
        <span class="detail-value"><?php echo htmlspecialchars($user['city']); ?></span>
        <button class="update-btn" onclick="updateField('city', 'City', /^[a-zA-Z]+(?:\s[a-zA-Z]+)*$/)">Update</button>
    </div>
    <div class="detail">
        <span class="detail-label">Gpay Number:</span>
        <span class="detail-value"><?php echo htmlspecialchars($user['Gpay']); ?></span>
        <button class="update-btn" onclick="updateField('Gpay', 'Gpay Number', /^01[0-9]{9}$/)">Update</button>
    </div>
    <div class="detail">
        <span class="detail-label">Gpay Balance:</span>
        <span class="detail-value">$<?php echo htmlspecialchars($user['Gpay_balance']); ?></span>
        <button class="update-btn" onclick="addMoney()">Add Money</button>
    </div>
    <div class="detail">
    <span class="detail-label">Password:</span>
    <span class="detail-value">********</span>
    <button class="update-btn" onclick="changePassword()">Change</button>
</div>
</div>

<div class="action">
    <button onclick="window.location.href='logout.php'">Logout</button>
</div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function updateField(field, label, regex) {
        Swal.fire({
            title: `Update ${label}`,
            input: 'text',
            inputLabel: `Enter new ${label}:`,
            inputPlaceholder: `New ${label}`,
            showCancelButton: true,
            confirmButtonText: 'Update',
            preConfirm: (value) => {
                if (!value) {
                    Swal.showValidationMessage(`${label} cannot be empty.`);
                } else if (!regex.test(value)) {
                    Swal.showValidationMessage(`Invalid ${label}. Please follow the required format.`);
                }
            },
        }).then((result) => {
            if (result.isConfirmed) {
                const newValue = result.value;
                if (newValue) {
                    // Redirect to a PHP script to handle the update
                    window.location.href = `update_profile.php?field=${field}&value=${encodeURIComponent(newValue)}`;
                }
            }
        });
    }

    function addMoney() {
        Swal.fire({
            title: 'Add Money',
            input: 'number',
            inputAttributes: {
                min: 0.01,
                step: 0.01,
            },
            inputLabel: 'Enter amount to add:',
            inputPlaceholder: 'e.g., 100 or 99.99',
            showCancelButton: true,
            confirmButtonText: 'Add Money',
            preConfirm: (value) => {
                if (!value || value <= 0) {
                    Swal.showValidationMessage('Please enter a valid amount greater than 0.');
                }
            },
        }).then((result) => {
            if (result.isConfirmed) {
                const amount = parseFloat(result.value);
                if (amount) {
                    window.location.href = `update_profile.php?action=add_money&amount=${amount}`;
                }
            }
        });
    }

    function changePassword() {
        Swal.fire({
            title: 'Change Password',
            html: `
                <input type="password" id="current-password" class="swal2-input" placeholder="Current Password">
                <input type="password" id="new-password" class="swal2-input" placeholder="New Password">
                <input type="password" id="confirm-password" class="swal2-input" placeholder="Confirm Password">
            `,
            confirmButtonText: 'Update Password',
            showCancelButton: true,
            focusConfirm: false,
            preConfirm: () => {
                const currentPassword = document.getElementById('current-password').value;
                const newPassword = document.getElementById('new-password').value;
                const confirmPassword = document.getElementById('confirm-password').value;

                if (!currentPassword || !newPassword || !confirmPassword) {
                    Swal.showValidationMessage('All fields are required.');
                    return false;
                }

                if (newPassword.length < 4) {
                    Swal.showValidationMessage('Password must be at least 4 characters long.');
                    return false;
                }

                if (newPassword !== confirmPassword) {
                    Swal.showValidationMessage('Passwords do not match.');
                    return false;
                }

                return {
                    currentPassword,
                    newPassword
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const { currentPassword, newPassword } = result.value;
                // Send the data to the server
                fetch('update_profile.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ action: 'change_password', currentPassword, newPassword })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('Success', 'Password updated successfully!', 'success');
                    } else {
                        Swal.fire('Error', data.message, 'error');
                    }
                })
                .catch(() => {
                    Swal.fire('Error', 'Something went wrong. Please try again.', 'error');
                });
            }
        });
    }
</script>


</script>
</body>
</html>