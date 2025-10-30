<?php
require_once 'db.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$password = $_POST['password'];


if (empty($name) || empty($email) || empty($password)) {
$msg = 'Please fill all fields.';
} else {
// check if email exists
$stmt = $mysqli->prepare('SELECT id FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
$msg = 'Email already registered.';
} else {
$hash = password_hash($password, PASSWORD_DEFAULT);
$ins = $mysqli->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
$ins->bind_param('sss', $name, $email, $hash);
if ($ins->execute()) {
header('Location: login.php?registered=1');
exit;
} else {
$msg = 'Registration failed. Try again.';
}
}
$stmt->close();
}
}
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Sign Up - Event Management</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container auth">
<h2>Sign Up</h2>
<?php if($msg): ?><div class="error"><?=htmlspecialchars($msg)?></div><?php endif; ?>
<form method="post" action="">
<label>Name</label>
<input type="text" name="name" required>
<label>Email</label>
<input type="email" name="email" required>
<label>Password</label>
<input type="password" name="password" required>
<button type="submit">Register</button>
</form>
<p>Already have an account? <a href="login.php">Login</a></p>
</div>
</body>
</html>