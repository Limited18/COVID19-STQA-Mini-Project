<?php
require_once __DIR__ . '/config.php';
$pageTitle = $pageTitle ?? 'COVID-19 Awareness';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="Educational COVID-19 awareness information and community project.">
  <title><?= e($pageTitle) ?> | CareAware</title>
  <link rel="stylesheet" href="style.css">
  <script defer src="script.js"></script>
</head>
<body>
<header class="site-header">
  <a class="brand" href="index.php" aria-label="CareAware home">
    <span class="brand-mark">+</span>
    <span>Care<span class="brand-accent">Aware</span><small>COVID-19 INFORMATION</small></span>
  </a>
  <button class="menu-toggle" type="button" aria-label="Toggle navigation" aria-expanded="false">☰</button>
  <nav class="nav-links" aria-label="Main navigation">
    <a href="index.php">Home</a>
    <a href="index.php#symptoms">Symptoms</a>
    <a href="index.php#prevention">Prevention</a>
    <a href="tests.php">Regex Tests</a>
    <?php if (is_logged_in()): ?>
      <a href="comments.php">Community</a>
      <a class="nav-cta" href="logout.php">Log out</a>
    <?php else: ?>
      <a href="login.php">Log in</a>
      <a class="nav-cta" href="register.php">Create account</a>
    <?php endif; ?>
  </nav>
</header>
<main>
