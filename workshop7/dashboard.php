<?php
session_start();

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit;
}

// Theme cookie
$theme = $_COOKIE['theme'] ?? 'light';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            background-color: <?php echo ($theme == 'dark') ? '#121212' : '#ffffff'; ?>;
            color: <?php echo ($theme == 'dark') ? '#ffffff' : '#000000'; ?>;
        }
    </style>
</head>
<body>

<h2>Welcome, <?php echo $_SESSION['student_name']; ?> </h2>

<nav>
    <a href="dashboard.php">Dashboard</a> |
    <a href="preference.php">Change Theme</a> |
    <a href="logout.php">Logout</a>
</nav>

</body>
</html>
