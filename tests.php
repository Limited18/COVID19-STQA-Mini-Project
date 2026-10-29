<?php
$pageTitle = 'Regex Test Cases';
require __DIR__ . '/header.php';
$cases = [
    ['TC01', 'Name', 'Vivek Gamane', '^[A-Za-z ]{2,50}$', true, 'Name matches the illustrative rule.'],
    ['TC02', 'Name', 'Vivek123', '^[A-Za-z ]{2,50}$', false, 'Digits are not allowed by this demo rule.'],
    ['TC03', 'Email', 'student@example.com', 'FILTER_VALIDATE_EMAIL', true, 'Valid email format.'],
    ['TC04', 'Email', 'student@com', 'FILTER_VALIDATE_EMAIL', false, 'Invalid or incomplete email format.'],
    ['TC05', 'Mobile', '9876543210', '^[6-9][0-9]{9}$', true, '10-digit Indian mobile format.'],
    ['TC06', 'Mobile', '1234567890', '^[6-9][0-9]{9}$', false, 'Does not begin with 6, 7, 8 or 9.'],
    ['TC07', 'Password', 'Vivek123', 'letter + digit + 8 chars', true, 'Meets illustrative password rule.'],
    ['TC08', 'Password', 'abc', 'letter + digit + 8 chars', false, 'Too short and has no digit.'],
    ['TC09', 'Comment', '500 characters', 'length 1–500', true, 'Maximum boundary is accepted.'],
    ['TC10', 'Comment', '501 characters', 'length 1–500', false, 'One character beyond maximum is rejected.'],
    ['TC11', 'Name', 'A', '^[A-Za-z ]{2,50}$', false, 'Below minimum length.'],
    ['TC12', 'Name', str_repeat('A', 51), '^[A-Za-z ]{2,50}$', false, 'Above maximum length.'],
];
?>
<section class="page-intro"><span class="eyebrow">STQA / VALIDATION LAB</span><h1>Regex test <span>cases.</span></h1><p>Test matrix for the Software Testing and Quality Assurance mini project. These are illustrative expected outcomes, not a claim that automated execution has occurred.</p></section>
<section class="test-panel">
  <div class="table-scroll"><table class="test-table">
    <thead><tr><th>Test ID</th><th>Field</th><th>Sample input</th><th>Rule / check</th><th>Expected result</th></tr></thead>
    <tbody><?php foreach ($cases as $case): ?>
      <tr><td><strong><?= e($case[0]) ?></strong></td><td><?= e($case[1]) ?></td><td><code><?= e($case[2]) ?></code></td><td><?= e($case[5]) ?><br><small><?= e($case[3]) ?></small></td><td><span class="result-pill <?= $case[4] ? 'result-accept' : 'result-reject' ?>"><?= $case[4] ? 'Accept' : 'Reject' ?></span></td></tr>
    <?php endforeach; ?></tbody>
  </table></div>
  <div class="test-note"><strong>Testing reminder</strong><p>Run tests against the actual forms and record actual Pass/Fail results. Regex checks format only; they do not prove that an email address or phone number is real. Also test duplicate email handling, password hashing, prepared statements, session access, and safe HTML output.</p></div>
</section>
<?php require __DIR__ . '/footer.php'; ?>
