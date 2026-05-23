<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireAdmin();
$page_title = "Feedback";
$feedback = $conn->query("SELECT f.*, p.fname, p.lname FROM feedback f
    JOIN profile p ON f.user_id=p.user_id
    ORDER BY f.submitted_at DESC")->fetch_all(MYSQLI_ASSOC);
require_once '../includes/header.php';
?>
<div class="page-header"><h1>💬 User Feedback</h1><p><?= count($feedback) ?> feedback entries</p></div>
<div style="display:flex;flex-direction:column;gap:12px">
  <?php foreach ($feedback as $fb): ?>
  <div class="card" style="padding:16px 20px">
    <div style="display:flex;justify-content:space-between;align-items:flex-start">
      <div>
        <div style="font-weight:700;margin-bottom:4px"><?= htmlspecialchars("{$fb['fname']} {$fb['lname']}") ?></div>
        <p style="font-size:14px;color:#333">"<?= htmlspecialchars($fb['feedback']) ?>"</p>
      </div>
      <span style="font-size:12px;color:#aaa;white-space:nowrap;margin-left:16px"><?= $fb['submitted_at'] ?></span>
    </div>
  </div>
  <?php endforeach; ?>
  <?php if (empty($feedback)): ?>
  <div class="empty"><div class="empty-icon">💬</div><p>No feedback yet</p></div>
  <?php endif; ?>
</div>
<?php require_once '../includes/footer.php'; ?>
