<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();
$page_title = "Become a Donor";
$user_id = $_SESSION['user_id'];
$error = ''; $success = '';

// Check if already a donor
$ur = $conn->query("SELECT * FROM user_role WHERE user_id='$user_id' AND is_active=1")->fetch_assoc();
$already_donor = $ur ? $conn->query("SELECT * FROM donor WHERE user_role_id='{$ur['user_role_id']}'")->fetch_assoc() : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$already_donor) {
    $blood_type = $conn->real_escape_string($_POST['blood_type']);
    $conn->begin_transaction();
    try {
        // Get or create user_role
        if (!$ur) {
            $ur_res = $conn->query("SELECT user_role_id FROM user_role ORDER BY user_role_id DESC LIMIT 1")->fetch_assoc();
            $last = $ur_res ? intval(substr($ur_res['user_role_id'], 2)) : 0;
            $ur_id = 'UR' . str_pad($last + 1, 3, '0', STR_PAD_LEFT);
            $conn->query("INSERT INTO user_role (user_role_id, user_id, role_id, time_assigned, is_active) VALUES ('$ur_id', '$user_id', 'R1', NOW(), 1)");
        } else {
            $ur_id = $ur['user_role_id'];
        }
        // Generate donor_id
        $d_res = $conn->query("SELECT donor_id FROM donor ORDER BY donor_id DESC LIMIT 1")->fetch_assoc();
        $last_d = $d_res ? intval(substr($d_res['donor_id'], 1)) : 0;
        $donor_id = 'D' . str_pad($last_d + 1, 3, '0', STR_PAD_LEFT);

        $conn->query("INSERT INTO donor (donor_id, user_role_id, no_times_donated, blood_type) VALUES ('$donor_id', '$ur_id', 0, '$blood_type')");
        $conn->commit();
        $success = "You are now registered as a donor!";
        $already_donor = $conn->query("SELECT * FROM donor WHERE donor_id='$donor_id'")->fetch_assoc();
    } catch (Exception $e) {
        $conn->rollback();
        $error = "Registration failed. Please try again.";
    }
}
require_once 'includes/header.php';
?>
<div class="page-header">
  <h1><i class="bi bi-droplet-fill" style="color:var(--red)"></i> Become a Donor</h1>
  <p>Register to help save lives by donating blood</p>
</div>
<?php if ($already_donor): ?>
<div class="card" style="max-width:500px">
  <div style="text-align:center;padding:20px">
    <div style="font-size:56px;margin-bottom:12px;"><i class="bi bi-check-square-fill" style="color:var(--green)"></i></div>
    <h2 style="margin-bottom:8px">You're a Registered Donor!</h2>
    <p style="color:#888;margin-bottom:20px">Thank you for being a life-saver.</p>
    <div style="background:#fff5f5;border-radius:12px;padding:16px;margin-bottom:20px">
      <div style="font-size:13px;color:#555">Your Blood Type</div>
      <div style="font-size:32px;font-weight:900;color:var(--red)"><?= $already_donor['blood_type'] ?></div>
      <div style="font-size:13px;color:#555">Donations Made: <strong><?= $already_donor['no_times_donated'] ?></strong></div>
    </div>
    <a href="appointments.php" class="btn btn-primary">Book an Appointment</a>
  </div>
</div>
<?php else: ?>
<?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<div class="card" style="max-width:500px">
  <div class="card-title">Donor Registration</div>
  <p style="color:#888;font-size:14px;margin-bottom:20px">Please provide your blood type to complete your donor registration.</p>
  <form method="POST">
    <div class="form-group">
      <label>Blood Type</label>
      <select name="blood_type" required>
        <option value="">Select your blood type</option>
        <?php foreach (['O+','O-','A+','A-','B+','B-','AB+','AB-'] as $bt): ?>
          <option value="<?= $bt ?>"><?= $bt ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="alert alert-info">By registering, you agree to donate blood at scheduled events. You can book appointments after registering.</div>
    <button type="submit" class="btn btn-primary btn-full">Register as Donor</button>
  </form>
</div>
<?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
