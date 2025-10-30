<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}
$user_id = $_SESSION['user_id'];
$event_id = intval($_POST['event_id']);

$check = $mysqli->prepare('SELECT id FROM registrations WHERE user_id=? AND event_id=?');
$check->bind_param('ii', $user_id, $event_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
  header('Location: dashboard.php?msg=already');
  exit;
}

$insert = $mysqli->prepare('INSERT INTO registrations (user_id, event_id) VALUES (?, ?)');
$insert->bind_param('ii', $user_id, $event_id);
$insert->execute();
header('Location: dashboard.php?msg=registered');
?>
