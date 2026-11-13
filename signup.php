<?php
require __DIR__ . '/db.php';
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    if ($username === "" || $email === "" || $password === "") {
        $msg = "All fields are required.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hash);
        if ($stmt->execute()) {
            $msg = "Account created for " . htmlspecialchars($username) . ". You can now <a href='login.php'>log in</a>.";
        } else {
            $msg = "Could not create account (username may already exist).";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Sign Up</title>
<style>
body{font-family:Arial,sans-serif;background:#f2f4f8;display:flex;justify-content:center;padding-top:60px}
form{background:#fff;padding:30px;border-radius:8px;width:300px;box-shadow:0 2px 8px #0002}
input{width:100%;padding:8px;margin:6px 0 14px;box-sizing:border-box}
button{width:100%;padding:10px;background:#2a6fdb;color:#fff;border:0;border-radius:4px}
</style></head>
<body>
<form method="POST">
  <h2>CAT 2 Sign Up- 192224</h2>
  <p><?php echo $msg; ?></p>
  <label>Username</label><input type="text" name="username" required>
  <label>Email</label><input type="email" name="email" required>
  <label>Password</label><input type="password" name="password" required>
  <button type="submit">Create account</button>
  <p><a href="login.php">Already registered? Log in</a></p>
</form>
</body>
</html>
