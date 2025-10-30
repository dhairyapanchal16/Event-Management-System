<?php
session_start();
include('db.php');

// Fetch all events from the database
$events = [];
$sql = "SELECT * FROM events ORDER BY date ASC";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $events = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Event Management System</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="site-header">
  <div class="container">
    <h1>Event Management System</h1>
    <nav>
      <?php if (isset($_SESSION['user_id'])): ?>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
      <?php else: ?>
        <a href="login.php">Login</a>
        <a href="signup.php">Signup</a>
      <?php endif; ?>
    </nav>
  </div>
</header>

<main class="container">
  <section class="events">
    <h2>Upcoming Events</h2>
    <?php if (empty($events)): ?>
      <p>No events available right now.</p>
    <?php else: ?>
      <div class="events-grid">
        <?php foreach ($events as $event): ?>
          <div class="event-card">
            <h3><?= htmlspecialchars($event['title']) ?></h3>
            <p class="meta"><?= htmlspecialchars($event['date']) ?> • <?= htmlspecialchars($event['location']) ?></p>
            <p><?= nl2br(htmlspecialchars($event['description'])) ?></p>
            <?php if (isset($_SESSION['user_id'])): ?>
              <form method="post" action="register_event.php">
                <input type="hidden" name="event_id" value="<?= intval($event['id']) ?>">
                <button class="btn" type="submit">Register</button>
              </form>
            <?php else: ?>
              <p><a href="login.php">Login</a> to register</p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </section>
</main>

<footer class="site-footer">
  <div class="container">
    <p>© <?= date('Y') ?> Event Management System | Developed by Dhairya Panchal</p>
  </div>
</footer>
</body>
</html>
