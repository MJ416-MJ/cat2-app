<?php
session_start();
require __DIR__ . '/db.php';
$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $message = trim($_POST['message']);
    if ($name !== "" && $message !== "") {
        $stmt = $conn->prepare("INSERT INTO feedback (name, message) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $message);
        $msg = $stmt->execute() ? "Feedback saved." : "Could not save feedback.";
    } else {
        $msg = "Both fields are required.";
    }
}
$rows = $conn->query("SELECT id, name, message, created FROM feedback ORDER BY id DESC");
?>
<!DOCTYPE html>
<html>
<head><meta charset="UTF-8"><title>Feedback</title>
<style>
body{font-family:Arial,sans-serif;background:#f2f4f8;padding:40px}
form,table{background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 8px #0002;max-width:520px}
input,textarea{width:100%;padding:8px;margin:6px 0 14px;box-sizing:border-box}
button{padding:10px 20px;background:#2a6fdb;color:#fff;border:0;border-radius:4px}
table{margin-top:20px;border-collapse:collapse;width:100%}
th,td{border-bottom:1px solid #ddd;padding:8px;text-align:left}
</style></head>
<body>
<form method="POST">
  <h2>Feedback Form</h2>
  <p><?php echo htmlspecialchars($msg); ?></p>
  <label>Name</label><input type="text" name="name" required>
  <label>Message</label><textarea name="message" rows="4" required></textarea>
  <button type="submit">Submit</button>
</form>
<table>
  <tr><th>ID</th><th>Name</th><th>Message</th><th>Date</th></tr>
  <?php while ($r = $rows->fetch_assoc()): ?>
  <tr>
    <td><?php echo $r['id']; ?></td>
    <td><?php echo htmlspecialchars($r['name']); ?></td>
    <td><?php echo htmlspecialchars($r['message']); ?></td>
    <td><?php echo $r['created']; ?></td>
  </tr>
  <?php endwhile; ?>
</table>
<p><a href="welcome.php">Back</a></p>
</body>
</html>
