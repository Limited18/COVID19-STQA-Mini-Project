<?php
require_once __DIR__ . '/config.php';
if (is_logged_in()) {
    header('Location: comments.php');
    exit;
}
$errors = [];
$name = '';
$email = '';
$mobile = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $errors[] = 'Your session token was invalid. Refresh the page and try again.';
    }
    $name = trim((string)($_POST['name'] ?? ''));
    $email = strtolower(trim((string)($_POST['email'] ?? '')));
    $mobile = trim((string)($_POST['mobile'] ?? ''));
    $password = (string)($_POST['password'] ?? '');

    if (!preg_match('/^[A-Za-z ]{2,50}$/D', $name)) {
        $errors[] = 'Name must contain 2–50 letters and spaces (this demo rule uses English letters).';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190) {
        $errors[] = 'Enter a valid email address.';
    }
    if ($mobile !== '' && !preg_match('/^[6-9][0-9]{9}$/D', $mobile)) {
        $errors[] = 'Enter a valid 10-digit Indian mobile number, or leave it blank.';
    }
    if (strlen($password) < 8 || strlen($password) > 72 || !preg_match('/[A-Za-z]/', $password) || !preg_match('/[0-9]/', $password)) {
        $errors[] = 'Password must be 8–72 characters and include at least one letter and one number.';
    }

    if (!$errors) {
        $statement = $pdo->prepare('SELECT id FROM users WHERE email = :email LIMIT 1');
        $statement->execute([':email' => $email]);
        if ($statement->fetch()) {
            $errors[] = 'An account with this email already exists.';
        } else {
            $statement = $pdo->prepare('INSERT INTO users (name, email, mobile, password_hash) VALUES (:name, :email, :mobile, :password_hash)');
            try {
                $statement->execute([
                    ':name' => $name,
                    ':email' => $email,
                    ':mobile' => $mobile !== '' ? $mobile : null,
                    ':password_hash' => password_hash($password, PASSWORD_DEFAULT),
                ]);
                header('Location: login.php?registered=1');
                exit;
            } catch (PDOException $exception) {
                if ($exception->getCode() === '23000') {
                    $errors[] = 'An account with this email already exists.';
                } else {
                    error_log('Registration failed: ' . $exception->getMessage());
                    $errors[] = 'Registration could not be completed. Please try again.';
                }
            }
        }
    }
}
$pageTitle = 'Create Account';
require __DIR__ . '/header.php';
?>
<section class="auth-wrap">
  <div class="auth-aside"><span class="eyebrow">CARE STARTS WITH KNOWLEDGE</span><h1>Be part of a more<br><span>informed community.</span></h1><p>Create an account to share supportive messages and take part in this educational project.</p><div class="auth-decoration">+</div></div>
  <div class="auth-panel"><span class="eyebrow">GET STARTED</span><h2>Create your account</h2><p class="muted">Fields marked with * are required.</p>
    <?php if ($errors): ?><div class="alert alert-error" role="alert"><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
    <form method="post" class="form-stack" novalidate>
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
      <label>Full name *<input name="name" value="<?= e($name) ?>" required minlength="2" maxlength="50" pattern="[A-Za-z ]{2,50}" autocomplete="name" placeholder="Your name"></label>
      <label>Email address *<input type="email" name="email" value="<?= e($email) ?>" required maxlength="190" autocomplete="email" placeholder="you@example.com"></label>
      <label>Mobile number (optional)<input name="mobile" value="<?= e($mobile) ?>" inputmode="numeric" maxlength="10" pattern="[6-9][0-9]{9}" placeholder="10-digit Indian mobile"></label>
      <label>Password *<input type="password" name="password" required minlength="8" maxlength="72" autocomplete="new-password" placeholder="At least 8 characters"><small>Use at least 8 characters, including a letter and a number.</small></label>
      <button class="btn btn-primary btn-full" type="submit">Create account <span>→</span></button>
      <p class="form-foot">Already registered? <a href="login.php">Log in</a></p>
    </form>
  </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
