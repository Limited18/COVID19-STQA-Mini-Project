<?php
require_once __DIR__ . '/config.php';
if (is_logged_in()) {
    header('Location: comments.php');
    exit;
}
$error = '';
$email = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $error = 'Your session token was invalid. Refresh the page and try again.';
    } else {
        $email = strtolower(trim((string)($_POST['email'] ?? '')));
        $password = (string)($_POST['password'] ?? '');
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $password === '') {
            $error = 'Enter a valid email address and password.';
        } else {
            $statement = $pdo->prepare('SELECT id, name, password_hash FROM users WHERE email = :email LIMIT 1');
            $statement->execute([':email' => $email]);
            $user = $statement->fetch();
            if ($user && password_verify($password, $user['password_hash'])) {
                session_regenerate_id(true);
                $_SESSION['user_id'] = (int)$user['id'];
                $_SESSION['user_name'] = $user['name'];
                header('Location: comments.php');
                exit;
            }
            $error = 'Email or password is incorrect.';
        }
    }
}
$pageTitle = 'Log In';
require __DIR__ . '/header.php';
?>
<section class="auth-wrap login-wrap">
  <div class="auth-aside"><span class="eyebrow">YOUR COMMUNITY</span><h1>Good information<br><span>travels together.</span></h1><p>Log in to share helpful, respectful messages with the CareAware community.</p><div class="auth-decoration">♡</div></div>
  <div class="auth-panel"><span class="eyebrow">WELCOME BACK</span><h2>Log in to your account</h2><p class="muted">Enter your registered details below.</p>
    <?php if (isset($_GET['registered'])): ?><div class="alert alert-success">Registration successful. You can now log in.</div><?php endif; ?>
    <?php if ($error !== ''): ?><div class="alert alert-error" role="alert"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="form-stack" novalidate>
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
      <label>Email address<input type="email" name="email" value="<?= e($email) ?>" required maxlength="190" autocomplete="email" placeholder="you@example.com"></label>
      <label>Password<input type="password" name="password" required maxlength="72" autocomplete="current-password" placeholder="Your password"></label>
      <button class="btn btn-primary btn-full" type="submit">Log in <span>→</span></button>
      <p class="form-foot">New here? <a href="register.php">Create an account</a></p>
    </form>
  </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
