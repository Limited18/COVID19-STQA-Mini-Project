<?php
require_once __DIR__ . '/config.php';
if (!is_logged_in()) {
    header('Location: login.php');
    exit;
}
$error = '';
$commentText = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf()) {
        $error = 'Your session token was invalid. Refresh the page and try again.';
    } else {
        $commentText = trim((string)($_POST['comment_text'] ?? ''));
        $length = function_exists('mb_strlen') ? mb_strlen($commentText, 'UTF-8') : strlen($commentText);
        if ($length < 1 || $length > 500) {
            $error = 'Your comment must contain between 1 and 500 characters.';
        } else {
            $statement = $pdo->prepare('INSERT INTO comments (user_id, comment_text) VALUES (:user_id, :comment_text)');
            $statement->execute([
                ':user_id' => (int)$_SESSION['user_id'],
                ':comment_text' => $commentText,
            ]);
            header('Location: comments.php?posted=1');
            exit;
        }
    }
}
$statement = $pdo->query(
    'SELECT c.comment_text, c.created_at, u.name
     FROM comments c JOIN users u ON u.id = c.user_id
     ORDER BY c.created_at DESC LIMIT 100'
);
$comments = $statement->fetchAll();
$pageTitle = 'Community Comments';
require __DIR__ . '/header.php';
?>
<section class="page-intro"><span class="eyebrow">03 / COMMUNITY</span><h1>Kind words build <span>connection.</span></h1><p>Welcome, <?= e((string)($_SESSION['user_name'] ?? 'member')) ?>. Share a helpful, respectful message with the community.</p></section>
<section class="comments-layout">
  <div class="comment-form-card"><h2>Leave a message</h2><p class="muted">Maximum 500 characters. Please be respectful.</p>
    <?php if (isset($_GET['posted'])): ?><div class="alert alert-success">Your comment has been posted.</div><?php endif; ?>
    <?php if ($error !== ''): ?><div class="alert alert-error" role="alert"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="form-stack">
      <input type="hidden" name="csrf_token" value="<?= e(csrf_token()) ?>">
      <label for="comment_text">Your comment</label>
      <textarea id="comment_text" name="comment_text" rows="5" maxlength="500" required placeholder="Write an encouraging message..."><?= e($commentText) ?></textarea>
      <div class="char-count"><span id="char-count"><?= strlen($commentText) ?></span>/500 characters</div>
      <button class="btn btn-primary btn-full" type="submit">Post comment →</button>
    </form>
  </div>
  <div class="comment-list"><div class="list-heading"><h2>Community messages</h2><span class="count-pill"><?= count($comments) ?> shown</span></div>
    <?php if (!$comments): ?><div class="empty-state"><span>♡</span><h3>Be the first to share</h3><p>Your message can help make this space welcoming.</p></div><?php endif; ?>
    <?php foreach ($comments as $comment): ?>
      <article class="comment-item"><div class="avatar"><?= e(strtoupper(substr((string)$comment['name'], 0, 1))) ?></div><div class="comment-body"><div class="comment-meta"><strong><?= e($comment['name']) ?></strong><time><?= e(date('d M Y, H:i', strtotime($comment['created_at']))) ?></time></div><p><?= nl2br(e($comment['comment_text'])) ?></p></div></article>
    <?php endforeach; ?>
  </div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
