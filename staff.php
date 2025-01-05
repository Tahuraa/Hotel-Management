<?php
session_start();
include 'dbconnect.php';

// Check if admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

// Add Staff (CREATE)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_staff'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    // $wages = $_POST['wages'];

    // Validate phone number
    if (!preg_match('/^01[0-9]{9}$/', $phone)) {
        $error = "Phone number must be 11 digits, start with 01, and contain only numbers.";
    } else {
        $sql = "INSERT INTO staff (name, role, email, phone) VALUES ('$name', '$role', '$email', '$phone')";
        $con->query($sql);
    }
}

// Assign Task
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign_task'])) {
    $id = $_POST['staff_id'];
    $task = $_POST['task'];

    $sql = "UPDATE staff SET task='$task' WHERE id=$id";
    $con->query($sql);
}

// Update Staff (UPDATE)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_staff'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $role = $_POST['role'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    // $wages = $_POST['wages'];

    // Validate phone number
    if (!preg_match('/^01[0-9]{9}$/', $phone)) {
        $error = "Phone number must be 11 digits, start with 01, and contain only numbers.";
    } else {
        $sql = "UPDATE staff SET name='$name', role='$role', email='$email', phone='$phone' WHERE id=$id";
        $con->query($sql);
    }
}

// Delete Staff (DELETE)
if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];

    $sql = "DELETE FROM staff WHERE id=$id";
    $con->query($sql);
    header("Location: staff.php");
    exit();
}

// Fetch Staff
$staff = $con->query("SELECT * FROM staff");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Staff Management</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Staff Management</h1>
            <nav>
                <ul>
                    <li><a href="admin_dashboard.php">Dashboard</a></li>
                    <li><a href="staff.php">Staff Management</a></li>
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

            <!-- Add Staff Form -->
            <section class="form-section">
                <h2>Add Staff</h2>
                <form method="POST">
                    <input type="text" name="name" placeholder="Name" required>
                    <input type="text" name="role" placeholder="Role" required>
                    <!-- <input type="number" name="wages" placeholder="wages" required> -->
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="text" name="phone" placeholder="Phone (e.g., 017XXXXXXXX)" required>
                    <button type="submit" name="add_staff">Add Staff</button>
                </form>
            </section>

            <!-- Assign Task Form -->
            <section class="form-section">
                <h2>Assign Task</h2>
                <form method="POST">
                    <select name="staff_id" required>
                        <option value="" disabled selected>Select Staff</option>
                        <?php while ($row = $staff->fetch_assoc()) { ?>
                            <option value="<?= $row['id']; ?>">
                                <?= $row['name']; ?> (ID: <?= $row['id']; ?>)
                            </option>
                        <?php } ?>
                    </select>
                    <input type="text" name="task" placeholder="Task Description" required>
                    <button type="submit" name="assign_task">Assign Task</button>
                </form>
            </section>

            <!-- Staff List with ID Display -->
            <section class="staff-list">
                <h2>Staff List</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Task</th>
                            <!-- <th>wages</th> -->
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $staff = $con->query("SELECT * FROM staff");
                        while ($row = $staff->fetch_assoc()) { ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= $row['name']; ?></td>
                                <td><?= $row['role']; ?></td>
                                <td><?= $row['email']; ?></td>
                                <td><?= $row['phone']; ?></td>
                                <td><?= $row['task']; ?></td>
                                <!-- <td><?= $row['wages']; ?></td> -->
                                <td>
                                    <!-- Update Form -->
                                    <form method="POST" style="display: inline-block;">
                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                        <input type="text" name="name" value="<?= $row['name']; ?>" required>
                                        <input type="text" name="role" value="<?= $row['role']; ?>" required>
                                        <input type="email" name="email" value="<?= $row['email']; ?>" required>
                                        <!-- <input type="number" name="wages" value="<?= $row['wages']; ?>" required> -->
                                        <input type="text" name="phone" value="<?= $row['phone']; ?>">
                                        <button type="submit" name="update_staff">Update</button>
                                    </form>
                                    <!-- Delete Button -->
                                    <a href="staff.php?delete_id=<?= $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this staff member?');">Delete</a>
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

