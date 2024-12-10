<?php
session_start();

if (!isset($_SESSION['email'])) {
    header('Location: /index.php');
    exit;
}

$userEmail = $_SESSION['email'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome <?php echo htmlspecialchars($_SESSION['email']); ?></h1>
    <p>You are logged in!</p>
    <a href="/logout">Logout</a>
</body>
</html>
