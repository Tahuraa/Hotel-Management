<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_style.css">
</head>
<body>
    <div class="dashboard-container">
        <header>
            <h1>Welcome, Admin!</h1>
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
            <section class="overview">
                <h2>Overview</h2>
                <p>Manage your hotel staff and events efficiently using the dashboard. Use the links below to navigate to the respective pages.</p>
            </section>

            <section class="quick-links">
                <h2>Quick Links</h2>
                <div class="cards">
                    <!-- Staff Management Card -->
                    <div class="card">
                        <h3>Staff Management</h3>
                        <p>View and manage staff information.</p>
                        <a href="staff.php" class="btn">Go to Staff Management</a>
                        
                    </div>

                    <!-- Event Management Card -->
                    <div class="card">
                        <h3>Event Management</h3>
                        <p>Organize and manage hotel events.</p>
                        <a href="event.php" class="btn">Go to Event Management</a>
                    </div>

                    <div class="card">
                        <h3>Reservation Management</h3>
                        <p>Reservation Data.</p>
                        <a href="manage_r.php" class="btn">Go to Reservation Management</a>
                    </div>



                    <!-- Logout Card -->
                    <div class="card">
                        <h3>Logout</h3>
                        <p>Sign out of the admin account.</p>
                        <a href="logout.php" class="btn">Logout</a>
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
