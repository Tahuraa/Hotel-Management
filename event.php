<?php
session_start();
include 'dbconnect.php';

if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Add Event (CREATE)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_event'])) {
    $name = $_POST['name'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    // $amount = $_POST['amount'];
    

    // Validate event date
    $currentDate = date("Y-m-d");
    if ($date < $currentDate) {
        $error = "Event date cannot be in the past.";
    } else {
        $sql = "INSERT INTO events (name, date, location, description) VALUES ('$name', '$date', '$location', '$description')";
        // $result = mysqli_query($conn, $sql);
        $con->query($sql) ;
            //add the record in payment table
            // $event_id = mysqli_insert_id($con);
            // if (!$event_id) {
            //     die("Failed to retrieve reservation_id: " . mysqli_error($con));
            // };

            // Insert into the payment table
            // $payment_query = "INSERT INTO payment (payment_type, event_id, income, expenditure) 
            //                   VALUES ('event','$event_id', '$income', '$expenditure')";
            // mysqli_query($con, $payment_query);
            

        };
        
        
    }


// Update Event (UPDATE)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_event'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $date = $_POST['date'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    // $amount = $_POST['amount'];
    // $income = $_POST['income'];
    // $expenditure = $_POST['expenditure'];

    // Validate event date
    $currentDate = date("Y-m-d");
    if ($date < $currentDate) {
        $error = "Event date cannot be in the past.";
    } else {
        $sql = "UPDATE events SET name='$name', date='$date', location='$location', description='$description' WHERE id=$id";
        
        if ($con->query($sql)) {
            // echo 'success';
           
        
        }
        else {
            echo 'error';
        }
        
        
    }
}

// Delete Event (DELETE)
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $sql = "DELETE FROM events WHERE id=$id";
    $con->query($sql);
    header("Location: event.php");
    exit();
}

// Fetch Events
$events = $con->query("SELECT * FROM events");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Event Management</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Event Management</h1>
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
            <!-- Display Error Messages -->
            <?php if (isset($error)): ?>
                <div class="error-message">
                    <?= $error; ?>
                </div>
            <?php endif; ?>

            <!-- Add Event Form -->
            <section class="form-section">
                <h2>Add Event</h2>
                <form method="POST">
                    <input type="text" name="name" placeholder="Event Name" required>
                    <input type="date" name="date" required>
                    <input type="text" name="location" placeholder="Location" required>
                    <!-- <input type="number" name="amount" placeholder="amount" required> -->
                    <!-- <input type="number" step="0.01" name="income" placeholder="Income" required>
                    <input type="number" step="0.01" name="expenditure" placeholder="Expenditure" required> -->
                    <textarea name="description" placeholder="Description" required></textarea>

                    <button type="submit" name="add_event">Add Event</button>
                </form>
            </section>

            <!-- Event List with Update and Delete -->
            <section class="event-list">
                <h2>Event List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Date</th>
                            <th>Location</th>
                            <th>Description</th>
                            <!-- <th>Income</th>
                            <th>Expenditure</th> -->

                            <!-- <th>Amount</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $events->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['date']; ?></td>
                                <td><?= $row['location']; ?></td>
                                <td><?= $row['description']; ?></td>
                                <!-- <td><?= $row['income']; ?></td>
                                <td><?= $row['expenditure']; ?></td> -->

                                <!-- <td><?= $row['amount']; ?></td> -->

                                <td>
                                    <!-- Update Form -->
                                    <form method="POST" style="display: inline-block;">
                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                        <input type="text" name="name" value="<?= $row['name']; ?>" required>
                                        <input type="date" name="date" value="<?= $row['date']; ?>" required>
                                        <input type="text" name="location" value="<?= $row['location']; ?>" required>
                                        <!-- <input type="number" name="amount" value="<?= $row['amount']; ?>" required> -->
                                        <!-- <input type="number" name="income" value="<?= $row['income']; ?>" required>
                                        <input type="number" name="expenditure" value="<?= $row['expenditure']; ?>" required> -->

                                        <textarea name="description" required><?= $row['description']; ?></textarea>
                                        <button type="submit" name="update_event">Update</button>
                                    </form>
                                    <!-- Delete Button -->
                                    <a href="event.php?delete_id=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this event?');">Delete</a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </section>
        </main>
    </div>
</body>
</html>
