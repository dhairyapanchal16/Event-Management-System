<?php
<title>Dashboard - Event Management</title>
<link rel="stylesheet" href="css/style.css">
<script src="js/script.js" defer></script>
</head>
<body>
<header class="site-header">
<div class="container">
<h1>Welcome, <?=htmlspecialchars($_SESSION['user_name'])?></h1>
<nav>
<a href="index.php">Home</a>
<a href="dashboard.php">Dashboard</a>
<a href="logout.php">Logout</a>
</nav>
</div>
</header>


<main class="container">
<section class="events">
<h2>Available Events</h2>
<?php if(empty($events)): ?>
<p>No upcoming events.</p>
<?php else: ?>
<div class="events-grid">
<?php foreach($events as $ev): ?>
<div class="event-card">
<h3><?=htmlspecialchars($ev['title'])?></h3>
<p class="meta"><?=htmlspecialchars($ev['date'])?> • <?=htmlspecialchars($ev['location'])?></p>
<p><?=nl2br(htmlspecialchars($ev['description']))?></p>
<form method="post" action="register_event.php">
<input type="hidden" name="event_id" value="<?=intval($ev['id'])?>">
<button class="btn" type="submit">Register</button>
</form>
</div>
<?php endforeach; ?>
</div>
<?php endif; ?>
</section>


<section class="my-registrations">
<h2>My Registrations</h2>
<?php if(empty($registered)): ?>
<p>You have not registered for any events yet.</p>
<?php else: ?>
<ul class="reg-list">
<?php foreach($registered as $r): ?>
<li><?=htmlspecialchars($r['title'])?> — <?=htmlspecialchars($r['date'])?> (Registered at <?=htmlspecialchars($r['registered_at'])?>)</li>
<?php endforeach; ?>
</ul>
<?php endif; ?>
</section>
</main>


<footer class="site-footer">
<div class="container">Good luck with your project!</div>
</footer>
</body>
</html>