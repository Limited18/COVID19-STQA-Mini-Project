<?php
require_once __DIR__ . '/config.php';
$pageTitle = 'COVID-19 Awareness';
$latestComments = [];
try {
    $query = $pdo->query(
        'SELECT u.name, c.comment_text, c.created_at
         FROM comments c JOIN users u ON u.id = c.user_id
         ORDER BY c.created_at DESC LIMIT 3'
    );
    $latestComments = $query->fetchAll();
} catch (Throwable $exception) {
    error_log('Home comments read failed: ' . $exception->getMessage());
}
require __DIR__ . '/header.php';
?>
<section class="hero">
  <div class="hero-copy">
    <div class="eyebrow"><span class="pulse-dot"></span> KNOW MORE. STAY AWARE.</div>
    <h1>Small steps.<br><span>Stronger protection.</span></h1>
    <p class="hero-lead">Clear, practical information to help you understand COVID-19, recognize common symptoms, and make informed choices for your wellbeing.</p>
    <div class="hero-actions">
      <a class="btn btn-primary" href="#prevention">Explore prevention <span>↗</span></a>
      <a class="text-link" href="#symptoms">Learn about symptoms <span>→</span></a>
    </div>
    <div class="trust-line"><span class="check-circle">✓</span> Awareness first · Information for everyone</div>
  </div>
  <div class="hero-visual" aria-label="Decorative health awareness illustration">
    <div class="orbit orbit-one"></div><div class="orbit orbit-two"></div>
    <div class="health-card card-top"><span class="mini-icon mint">✦</span><div><strong>Stay informed</strong><small>Use trusted sources</small></div></div>
    <div class="virus-art"><div class="virus-core"><span></span><span></span><span></span><span></span><span></span><i></i></div></div>
    <div class="health-card card-bottom"><span class="mini-icon blue">♡</span><div><strong>Care for each other</strong><small>Healthy habits matter</small></div></div>
    <div class="floating-plus plus-a">+</div><div class="floating-plus plus-b">+</div>
  </div>
</section>
<section class="stats-strip" aria-label="Key themes">
  <div><span class="stat-icon">01</span><p><strong>Understand</strong><small>Learn the basics</small></p></div>
  <div><span class="stat-icon">02</span><p><strong>Prevent</strong><small>Build healthy habits</small></p></div>
  <div><span class="stat-icon">03</span><p><strong>Support</strong><small>Look out for others</small></p></div>
</section>
<section class="content-section" id="symptoms">
  <div class="section-heading">
    <div><span class="eyebrow">01 / RECOGNIZE</span><h2>Know the common <span>symptoms.</span></h2></div>
    <p>Symptoms can vary from person to person. If you feel unwell, follow current local health advice.</p>
  </div>
  <div class="info-grid">
    <article class="info-card"><span class="card-symbol coral">↗</span><h3>Fever or chills</h3><p>A raised temperature or feeling unusually cold may occur.</p></article>
    <article class="info-card"><span class="card-symbol blue">≈</span><h3>Cough or sore throat</h3><p>Respiratory symptoms can include cough, throat irritation, or congestion.</p></article>
    <article class="info-card"><span class="card-symbol violet">◌</span><h3>Fatigue or body aches</h3><p>Tiredness, headache, and muscle aches may also be present.</p></article>
    <article class="info-card"><span class="card-symbol mint">✳</span><h3>Changes in smell or taste</h3><p>Some people experience changes in their sense of smell or taste.</p></article>
  </div>
  <p class="medical-note"><strong>Important:</strong> This website does not diagnose illness. Seek urgent medical help for severe symptoms such as difficulty breathing or chest pain, and follow local emergency guidance.</p>
</section>
<section class="prevention-section" id="prevention">
  <div class="prevention-art"><div class="shield"><span>✓</span></div><div class="art-label">PREVENTION STARTS WITH AWARENESS</div></div>
  <div class="prevention-copy">
    <span class="eyebrow">02 / PROTECT</span><h2>Everyday habits can <span>make a difference.</span></h2>
    <ul class="habit-list">
      <li><span>✓</span><div><strong>Keep hands clean</strong><p>Wash with soap and water regularly.</p></div></li>
      <li><span>✓</span><div><strong>Improve ventilation</strong><p>Prefer well-ventilated spaces when possible.</p></div></li>
      <li><span>✓</span><div><strong>Stay home when unwell</strong><p>Reduce close contact and follow current health advice.</p></div></li>
      <li><span>✓</span><div><strong>Use trusted information</strong><p>Check guidance from recognized public-health authorities.</p></div></li>
    </ul>
    <a class="btn btn-dark" href="https://www.who.int/health-topics/coronavirus" target="_blank" rel="noopener noreferrer">Visit WHO information ↗</a>
  </div>
</section>
<section class="community-section">
  <div class="section-heading"><div><span class="eyebrow">03 / COMMUNITY</span><h2>Share a thoughtful <span>message.</span></h2></div><a class="text-link" href="<?= is_logged_in() ? 'comments.php' : 'register.php' ?>">Join the community →</a></div>
  <?php if ($latestComments): ?>
    <div class="comment-preview-grid">
      <?php foreach ($latestComments as $comment): ?>
        <article class="quote-card"><span class="quote-mark">“</span><p><?= e($comment['comment_text']) ?></p><small>— <?= e($comment['name']) ?></small></article>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <div class="empty-community"><span>♡</span><div><strong>A little kindness goes a long way.</strong><p>Create an account to share an encouraging message with the community.</p></div><a class="btn btn-primary" href="<?= is_logged_in() ? 'comments.php' : 'register.php' ?>">Get involved</a></div>
  <?php endif; ?>
</section>
<section class="source-banner"><div><span class="eyebrow">TRUSTED INFORMATION</span><h2>Stay curious. Check your sources.</h2><p>Public-health guidance can change. Use official resources for current recommendations.</p></div><a class="btn btn-light" href="https://www.cdc.gov/covid/" target="_blank" rel="noopener noreferrer">CDC COVID-19 resources ↗</a></section>
<?php require __DIR__ . '/footer.php'; ?>
