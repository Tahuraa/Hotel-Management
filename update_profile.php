<?php
include 'dbconnect.php';
session_start();






if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $input = json_decode(file_get_contents('php://input'), true);

    if (isset($input['action']) && $input['action'] === 'change_password') {
        $currentPassword = mysqli_real_escape_string($con, $input['currentPassword']);
        $newPassword = mysqli_real_escape_string($con, $input['newPassword']);
        $username = $_SESSION['username'];

        // Fetch current password from database
        $query = "SELECT password FROM guest WHERE username = '$username'";
        $result = mysqli_query($con, $query);
        if ($result && $row = mysqli_fetch_assoc($result)) {
            if ($row['password'] === $currentPassword) { // Validate current password
                // Update to the new password
                $updateQuery = "UPDATE guest SET password = '$newPassword' WHERE username = '$username'";
                if (mysqli_query($con, $updateQuery)) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Failed to update password.Password must be 4 character long']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Current password is incorrect.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'User not found.']);
        }
        exit();
    }
}







////test for pass#####




//test########
if (isset($_GET['action']) && $_GET['action'] === 'add_money' && isset($_GET['amount'])) {
    $amount = floatval($_GET['amount']);
    $current_username = $_SESSION['username'];

    if ($amount > 0) {
        // Update Gpay balance in the database
        $query = "UPDATE guest SET Gpay_balance = Gpay_balance + $amount WHERE username = '$current_username'";
        if (mysqli_query($con, $query)) {
            header('Location: profile.php');
        } else {
            echo "<script>alert('Unable to add money. Please try again later.'); window.history.back();</script>";
            
            
        }
    } else {
        echo "<script>alert('Amount must be greater than 0.'); window.history.back();</script>";

        
    }
} 






//test#############

elseif (isset($_GET['field']) && isset($_GET['value'])) {
    $field = mysqli_real_escape_string($con, $_GET['field']);
    $value = mysqli_real_escape_string($con, $_GET['value']);
    $current_username = $_SESSION['username'];

    // Allow username updates
    if ($field === 'username') {
        // Update username in the guest table
        $query = "UPDATE guest SET username = '$value' WHERE username = '$current_username'";
        if (mysqli_query($con, $query)) {
            // Update session variable after successful username update
            $_SESSION['username'] = $value;
            header('Location: profile.php');
        } else {
            echo "Error updating username: " . mysqli_error($con);
        }
    } else {
        // Update other fields in the guest table
        $query = "UPDATE guest SET $field = '$value' WHERE username = '$current_username'";
        if (mysqli_query($con, $query)) {
            header('Location: profile.php');
        } else {
            echo "Error updating profile: " . mysqli_error($con);
        }
    }
}
?>

