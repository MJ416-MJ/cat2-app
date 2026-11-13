<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Welcome</title></head>
<body style="font-family:Arial,sans-serif;padding:40px">
  <h2>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h2>
  <p>You are logged in.</p>
  <p><a href="feedback.php">Feedback form</a> | <a href="logout.php">Log out</a></p>
</body>
</html>
