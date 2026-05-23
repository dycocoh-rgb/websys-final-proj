<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();
$page_title = "Request Blood";
$user_id = $_SESSION['user_id'];
$error = ''; $success = '';

$ur = $conn->query("SELECT * FROM user_role WHERE user_id='$user_id' AND is_active=1")->fetch_assoc();
$recipient = $ur ? $conn->query("SELECT * FROM recipient WHERE user_role_id='{$ur['user_role_id']}'")->fetch_assoc() : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $recipient) {
    $blood_type     = $conn->real_escape_string($_POST['blood_type']);
    $units          = intval($_POST['units_requested']);
    $location       = $conn->real_escape_string(trim($_POST['request_location']));
    $date           = $conn->real_escape_string($_POST['request_date']);
    $recipient_id   = $recipient['recipient_id'];

    $rq_res = $conn->query("SELECT request_id FROM blood_request ORDER BY request_id DESC LIMIT 1")->fetch_assoc();
    $last_rq = $rq_res ? intval(substr($rq_res['request_id'], 2)) : 0;
    $request_id = 'RQ' . str_pad($last_rq + 1, 2, '0', STR_PAD_LEFT);

    $conn->query("INSERT INTO blood_request (request_id, recipient_id, blood_type, units_requested, request_location, request_date, req_status)
        VALUES ('$request_id', '$recipient_id', '$blood_type', $units, '$location', '$date', 'pending')");
    $conn->query("UPDATE recipient SET last_request_date='$date' WHERE recipient_id='$recipient_id'");
    $success = "Blood request submitted successfully! Request ID: $request_id";
}
require_once 'includes/header.php';
?>
<div class="page-header">
  <h1>📬 Request Blood</h1>
  <p>Submit a blood request and we'll process it as soon as possible</p>
</div>
<?php if (!$recipient): ?>
<div class="alert alert-info">You need to <a href="recipient-register.php" style="font-weight:700;color:var(--blue)">register as a recipient</a> first before requesting blood.</div>
<?php else: ?>
<?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= $success ?> <a href="my-requests.php">View my requests</a></div><?php endif; ?>
<div class="card" style="max-width:560px">
  <div class="card-title">Blood Request Form</div>
  <form method="POST">
    <div class="form-group">
      <label>Blood Type Needed</label>
      <select name="blood_type" required>
        <option value="">Select blood type</option>
        <?php foreach (['O+','O-','A+','A-','B+','B-','AB+','AB-'] as $bt): ?>
          <option value="<?= $bt ?>"><?= $bt ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="form-group">
      <label>Units Requested</label>
      <input type="number" name="units_requested" min="1" max="10" value="1" required/>
    </div>
    <div class="form-group">
      <label>Hospital / Clinic Location</label>
      <input type="text" name="request_location" placeholder="e.g. Legazpi General Hospital" required/>
    </div>
    <div class="form-group">
      <label>Date Needed</label>
      <input type="date" name="request_date" required/>
    </div>
    <div class="alert alert-info">Requests are reviewed by our admin team. You will be notified once your request is processed.</div>
    <button type="submit" class="btn btn-blue btn-full">Submit Request</button>
  </form>
</div>
<?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
