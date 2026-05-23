<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();
$page_title = "My Profile";
$user_id = $_SESSION['user_id'];
$error = ''; $success = '';

$profile = $conn->query("SELECT * FROM profile WHERE user_id='$user_id'")->fetch_assoc();
$user    = $conn->query("SELECT * FROM user_account WHERE user_id='$user_id'")->fetch_assoc();
$chapter = $conn->query("SELECT * FROM chapter WHERE user_database='{$user['user_database']}'")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname     = $conn->real_escape_string(trim($_POST['fname']));
    $lname     = $conn->real_escape_string(trim($_POST['lname']));
    $mname     = $conn->real_escape_string(trim($_POST['mname']));
    $address   = $conn->real_escape_string(trim($_POST['address']));
    $mobile_no = $conn->real_escape_string(trim($_POST['mobile_no']));
    $conn->query("UPDATE profile SET fname='$fname', lname='$lname', mname='$mname', address='$address', mobile_no='$mobile_no' WHERE user_id='$user_id'");
    $_SESSION['fname'] = $fname;
    $success = "Profile updated successfully!";
    $profile = $conn->query("SELECT * FROM profile WHERE user_id='$user_id'")->fetch_assoc();
}
require_once 'includes/header.php';
?>
<div class="page-header">
  <h1>👤 My Profile</h1>
  <p>Manage your personal information</p>
</div>
<?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<div class="grid-2">
  <div class="card">
    <div class="profile-header">
      <div class="profile-avatar"><?= strtoupper(substr($profile['fname']??'U',0,1)) ?></div>
      <div class="profile-info">
        <h2><?= htmlspecialchars("{$profile['fname']} {$profile['mname']}. {$profile['lname']}") ?></h2>
        <p><?= htmlspecialchars($user['email']) ?></p>
        <p style="font-size:12px;color:#aaa;margin-top:2px">📍 <?= $chapter['chapter_LOC'] ?? '—' ?></p>
      </div>
    </div>
    <hr class="divider"/>
    <div class="info-grid">
      <div class="info-item"><label>User ID</label><span><?= $profile['user_id'] ?></span></div>
      <div class="info-item"><label>Profile ID</label><span><?= $profile['profile_id'] ?></span></div>
      <div class="info-item"><label>Birth Date</label><span><?= $profile['birth_date'] ?></span></div>
      <div class="info-item"><label>Sex</label><span><?= $profile['sex']==='M'?'Male':'Female' ?></span></div>
      <div class="info-item"><label>Mobile</label><span><?= htmlspecialchars($profile['mobile_no']) ?></span></div>
      <div class="info-item"><label>Member Since</label><span><?= $user['created_at'] ?></span></div>
      <div class="info-item" style="grid-column:1/-1"><label>Address</label><span><?= htmlspecialchars($profile['address']) ?></span></div>
    </div>
  </div>
  <div class="card">
    <div class="card-title">Edit Profile</div>
    <form method="POST">
      <div class="form-row">
        <div class="form-group"><label>First Name</label><input type="text" name="fname" value="<?= htmlspecialchars($profile['fname']) ?>" required/></div>
        <div class="form-group"><label>Last Name</label><input type="text" name="lname" value="<?= htmlspecialchars($profile['lname']) ?>" required/></div>
      </div>
      <div class="form-group"><label>Middle Name</label><input type="text" name="mname" value="<?= htmlspecialchars($profile['mname']??'') ?>"/></div>
      <div class="form-group"><label>Address</label><input type="text" name="address" value="<?= htmlspecialchars($profile['address']) ?>" required/></div>
      <div class="form-group"><label>Mobile Number</label><input type="text" name="mobile_no" value="<?= htmlspecialchars($profile['mobile_no']) ?>" required/></div>
      <button type="submit" class="btn btn-primary btn-full">Save Changes</button>
    </form>
  </div>
</div>
<?php require_once 'includes/footer.php'; ?>
