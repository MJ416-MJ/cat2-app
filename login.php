<?php
session_start();
require __DIR__ . '/db.php';
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $username;
            header("Location: welcome.php");
            exit;
        }
    }
    $msg = "Invalid username or password.";
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Login</title>
<style>
body{font-family:Arial,sans-serif;background:#f2f4f8;display:flex;justify-content:center;padding-top:60px}
form{background:#fff;padding:30px;border-radius:8px;width:300px;box-shadow:0 2px 8px #0002}
input{width:100%;padding:8px;margin:6px 0 14px;box-sizing:border-box}
button{width:100%;padding:10px;background:#2a6fdb;color:#fff;border:0;border-radius:4px}
</style></head>
<body>
<form method="POST">
  <h2>CAT2 Login- 192224 </h2>
  <p style="color:#c00"><?php echo $msg; ?></p>
  <label>Username</label><input type="text" name="username" required>
  <label>Password</label><input type="password" name="password" required>
  <button type="submit">Log in</button>
  <p><a href="signup.php">Need an account? Sign up</a></p>
</form>
</body>
</html>
