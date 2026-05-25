<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();
$page_title = "Become a Recipient";
$user_id = $_SESSION['user_id'];
$error = ''; $success = '';

$ur = $conn->query("SELECT * FROM user_role WHERE user_id='$user_id' AND is_active=1")->fetch_assoc();
$already_recipient = $ur ? $conn->query("SELECT * FROM recipient WHERE user_role_id='{$ur['user_role_id']}'")->fetch_assoc() : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$already_recipient) {
    $conn->begin_transaction();
    try {
        if (!$ur) {
            $ur_res = $conn->query("SELECT user_role_id FROM user_role ORDER BY user_role_id DESC LIMIT 1")->fetch_assoc();
            $last = $ur_res ? intval(substr($ur_res['user_role_id'], 2)) : 0;
            $ur_id = 'UR' . str_pad($last + 1, 3, '0', STR_PAD_LEFT);
            $conn->query("INSERT INTO user_role (user_role_id, user_id, role_id, time_assigned, is_active) VALUES ('$ur_id', '$user_id', 'R2', NOW(), 1)");
        } else {
            $ur_id = $ur['user_role_id'];
        }
        $rc_res = $conn->query("SELECT recipient_id FROM recipient ORDER BY recipient_id DESC LIMIT 1")->fetch_assoc();
        $last_rc = $rc_res ? intval(substr($rc_res['recipient_id'], 2)) : 0;
        $recipient_id = 'RC' . str_pad($last_rc + 1, 3, '0', STR_PAD_LEFT);
        $conn->query("INSERT INTO recipient (recipient_id, user_role_id, last_request_date) VALUES ('$recipient_id', '$ur_id', NULL)");
        $conn->commit();
        $success = "You are now registered as a recipient!";
        $already_recipient = $conn->query("SELECT * FROM recipient WHERE recipient_id='$recipient_id'")->fetch_assoc();
    } catch (Exception $e) {
        $conn->rollback();
        $error = "Registration failed. Please try again.";
    }
}
require_once 'includes/header.php';
?>
<div class="page-header">
  <h1><i class="bi bi-hospital-fill"></i> Become a Recipient</h1>
  <p>Register to request blood when you need it</p>
</div>
<?php if ($already_recipient): ?>
<div class="card" style="max-width:500px">
  <div style="text-align:center;padding:20px">
    <div style="font-size:56px;margin-bottom:12px"><i class="bi bi-check-square-fill" style="color:var(--green)"></i></div>
    <h2 style="margin-bottom:8px">You're a Registered Recipient!</h2>
    <p style="color:#888;margin-bottom:20px">You can now request blood when needed.</p>
    <a href="request-blood.php" class="btn btn-blue">Request Blood Now</a>
  </div>
</div>
<?php else: ?>
<?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
<div class="card" style="max-width:500px">
  <div class="card-title">Recipient Registration</div>
  <p style="color:#888;font-size:14px;margin-bottom:20px">Register as a recipient to be able to submit blood requests.</p>
  <div class="alert alert-info" style="margin-bottom:20px">As a recipient, you can request blood from our inventory. Requests are reviewed and fulfilled based on availability.</div>
  <form method="POST">
    <button type="submit" class="btn btn-blue btn-full">Register as Recipient</button>
  </form>
</div>
<?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
