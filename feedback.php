<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();
$page_title = "Give Feedback";
$user_id = $_SESSION['user_id'];
$success = ''; $error = '';
 
// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $conn->real_escape_string($_POST['delete_id']);
    // Only allow deleting own feedback
    $check = $conn->query("SELECT feedback_id FROM feedback WHERE feedback_id='$delete_id' AND user_id='$user_id'")->fetch_assoc();
    if ($check) {
        $conn->query("DELETE FROM feedback WHERE feedback_id='$delete_id' AND user_id='$user_id'");
        $success = "Feedback deleted successfully.";
    } else {
        $error = "Unable to delete feedback.";
    }
}
 
// Handle submit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['feedback'])) {
    $feedback = $conn->real_escape_string(trim($_POST['feedback']));
    $conn->query("INSERT INTO feedback (user_id, feedback, submitted_at) VALUES ('$user_id', '$feedback', NOW())");
    $success = "Thank you for your feedback!";
}
 
$my_feedback = $conn->query("SELECT * FROM feedback WHERE user_id='$user_id' ORDER BY submitted_at DESC")->fetch_all(MYSQLI_ASSOC);
require_once 'includes/header.php';
?>
<div class="page-header"><h1>💬 Give Feedback</h1><p>Share your experience with us</p></div>
<?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
<div class="grid-2">
  <div class="card">
    <div class="card-title">Submit Feedback</div>
    <form method="POST">
      <div class="form-group">
        <label>Your Feedback</label>
        <textarea name="feedback" rows="5" placeholder="Share your experience..." required></textarea>
      </div>
      <button type="submit" class="btn btn-primary btn-full">Submit Feedback</button>
    </form>
  </div>
  <div class="card">
    <div class="card-title">My Previous Feedback</div>
    <?php if (empty($my_feedback)): ?>
    <div class="empty"><div class="empty-icon">💬</div><p>No feedback submitted yet</p></div>
    <?php else: ?>
    <?php foreach ($my_feedback as $fb): ?>
    <div style="background:#f8f9ff;border-radius:10px;padding:14px;margin-bottom:10px;border-left:3px solid var(--red);position:relative">
      <p style="font-size:14px;color:#333;margin-bottom:6px">"<?= htmlspecialchars($fb['feedback']) ?>"</p>
      <span style="font-size:12px;color:#aaa"><?= $fb['submitted_at'] ?></span>
      <form method="POST" style="display:inline;position:absolute;top:10px;right:10px"
            onsubmit="return confirm('Are you sure you want to delete this feedback? This cannot be undone.')">
        <input type="hidden" name="delete_id" value="<?= $fb['feedback_id'] ?>">
        <button type="submit"
          style="background:#fff0f0;border:1px solid #f5c2c2;color:#c0392b;font-size:11px;font-weight:600;
                 padding:4px 10px;border-radius:6px;cursor:pointer;">
          Delete
        </button>
      </form>
    </div>
    <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>
<?php require_once 'includes/footer.php'; ?>