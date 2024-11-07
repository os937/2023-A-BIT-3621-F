<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}
include 'db.php'; // Database connection file

// Fetch recent failed login attempts (last 10)
$failed_logins = $conn->query("SELECT * FROM logs WHERE activity_type = 'Failed Login' ORDER BY timestamp DESC LIMIT 10");

// Fetch all logs for the logs table
$logs = $conn->query('SELECT * FROM logs ORDER BY timestamp DESC');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - IDS System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">IDS Dashboard</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-4">
        <h2>Real-Time Notifications</h2>
        <div class="list-group mb-4">
            <?php if ($failed_logins->num_rows > 0): ?>
                <?php while ($login = $failed_logins->fetch_assoc()): ?>
                    <div class="list-group-item list-group-item-danger">
                        <strong>Failed Login Attempt</strong><br>
                        <small><?= $login['timestamp'] ?> - IP: <?= $login['ip_address'] ?></small><br>
                        <?= $login['description'] ?>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="list-group-item">No recent failed login attempts.</div>
            <?php endif; ?>
        </div>

        <h2>Intrusion Detection Logs</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Timestamp</th>
                    <th>IP Address</th>
                    <th>Activity Type</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($log = $logs->fetch_assoc()): ?>
                    <tr>
                        <td><?= $log['id'] ?></td>
                        <td><?= $log['timestamp'] ?></td>
                        <td><?= $log['ip_address'] ?></td>
                        <td><?= $log['activity_type'] ?></td>
                        <td><?= $log['description'] ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
