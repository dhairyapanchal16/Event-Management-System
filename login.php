<?php
require_once 'db.php';
session_start();
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$email = trim($_POST['email']);
$password = $_POST['password'];
if (empty($email) || empty($password)) {
$msg = 'Please fill all fields.';
} else {
$stmt = $mysqli->prepare('SELECT id, name, password FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 1) {
$stmt->bind_result($id, $name, $hash);
$stmt->fetch();
if (password_verify($password, $hash)) {
// login success
$_SESSION['user_id'] = $id;
$_SESSION['user_name'] = $name;
header('Location: dashboard.php');
exit;
} else {
$msg = 'Invalid credentials.';
}
} else {
$msg = 'Invalid credentials.';
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
<title>Login - Event Management</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<div class="container auth">
<h2>Login</h2>
<?php if ($msg): ?><div class="error"><?=htmlspecialchars($msg)?></div><?php endif; ?>
<?php if (isset($_GET['registered'])): ?><div class="success">Registration successful. Please login.</div><?php endif; ?>
<form method="post" action="">
<label>Email</label>
<input type="email" name="email" required>
<label>Password</label>
<input type="password" name="password" required>
<button type="submit">Login</button>
</form>
<p>No account? <a href="signup.php">Sign up</a></p>
</div>
</body>
</html>