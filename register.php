<?php
session_start();
if (isset($_SESSION['user_id'])) { header("Location: /blood-bank/dashboard.php"); exit(); }
require_once 'includes/db.php';
$error = ''; $success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname      = $conn->real_escape_string(trim($_POST['fname']));
    $lname      = $conn->real_escape_string(trim($_POST['lname']));
    $mname      = $conn->real_escape_string(trim($_POST['mname']));
    $birth_date = $conn->real_escape_string($_POST['birth_date']);
    $sex        = $conn->real_escape_string($_POST['sex']);
    $address    = $conn->real_escape_string(trim($_POST['address']));
    $mobile_no  = $conn->real_escape_string(trim($_POST['mobile_no']));
    $email      = $conn->real_escape_string(trim($_POST['email']));
    $password   = trim($_POST['password']);
    $confirm    = trim($_POST['confirm_password']);
    $db         = $conn->real_escape_string($_POST['user_database']);

    if ($password !== $confirm) { $error = "Passwords do not match."; }
    elseif (strlen($password) < 6) { $error = "Password must be at least 6 characters."; }
    else {
        $exists = $conn->query("SELECT user_id FROM user_account WHERE email='$email'")->num_rows;
        if ($exists) { $error = "Email is already registered."; }
        else {
            $conn->begin_transaction();
            try {
                // Generate IDs
                $uid_res = $conn->query("SELECT user_id FROM user_account ORDER BY user_id DESC LIMIT 1")->fetch_assoc();
                $last_num = $uid_res ? intval(substr($uid_res['user_id'], 1)) : 0;
                $user_id = 'U' . str_pad($last_num + 1, 3, '0', STR_PAD_LEFT);

                $pid_res = $conn->query("SELECT profile_id FROM profile ORDER BY profile_id DESC LIMIT 1")->fetch_assoc();
                $last_pid = $pid_res ? intval(substr($pid_res['profile_id'], 1)) : 0;
                $profile_id = 'P' . str_pad($last_pid + 1, 3, '0', STR_PAD_LEFT);

                $conn->query("INSERT INTO user_account (user_id, user_database, email, password, created_at)
                    VALUES ('$user_id', '$db', '$email', '$password', CURDATE())");

                $conn->query("INSERT INTO profile (profile_id, user_id, fname, lname, mname, birth_date, sex, address, mobile_no)
                    VALUES ('$profile_id', '$user_id', '$fname', '$lname', '$mname', '$birth_date', '$sex', '$address', '$mobile_no')");

                $conn->commit();
                $success = "Account created successfully! You can now log in.";
            } catch (Exception $e) {
                $conn->rollback();
                $error = "Registration failed. Please try again.";
            }
        }
    }
}

$chapters = $conn->query("SELECT * FROM chapter")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BloodBank — Register</title>
  <link rel="stylesheet" href="assets/style.css"/>
</head>
<body>
<div class="auth-wrap">
  <div class="auth-card" style="max-width:520px">
    <div class="auth-logo">
      <div class="icon">🩸</div>
      <div><h1>BloodBank</h1><p>Create your account</p></div>
    </div>
    <h2>Create Account</h2>
    <p class="subtitle">Join the BloodBank community</p>
    <?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
    <?php if ($success): ?><div class="alert alert-success"><?= $success ?> <a href="index.php">Login now</a></div><?php endif; ?>
    <?php if (!$success): ?>
    <form method="POST">
      <div class="form-row">
        <div class="form-group">
          <label>First Name</label>
          <input type="text" name="fname" placeholder="First name" required/>
        </div>
        <div class="form-group">
          <label>Last Name</label>
          <input type="text" name="lname" placeholder="Last name" required/>
        </div>
      </div>
      <div class="form-group">
        <label>Middle Name</label>
        <input type="text" name="mname" placeholder="Middle name"/>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Birth Date</label>
          <input type="date" name="birth_date" required/>
        </div>
        <div class="form-group">
          <label>Sex</label>
          <select name="sex" required>
            <option value="">Select</option>
            <option value="M">Male</option>
            <option value="F">Female</option>
          </select>
        </div>
      </div>
      <div class="form-group">
        <label>Address</label>
        <input type="text" name="address" placeholder="Your address" required/>
      </div>
      <div class="form-group">
        <label>Mobile Number</label>
        <input type="text" name="mobile_no" placeholder="+63912345678" required/>
      </div>
      <div class="form-group">
        <label>Chapter</label>
        <select name="user_database" required>
          <option value="">Select your chapter</option>
          <?php foreach ($chapters as $ch): ?>
            <option value="<?= $ch['user_database'] ?>"><?= $ch['chapter_LOC'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Email</label>
        <input type="email" name="email" placeholder="your@email.com" required/>
      </div>
      <div class="form-row">
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" placeholder="Min. 6 characters" required/>
        </div>
        <div class="form-group">
          <label>Confirm Password</label>
          <input type="password" name="confirm_password" placeholder="Repeat password" required/>
        </div>
      </div>
      <button type="submit" class="btn btn-primary btn-full">Create Account</button>
    </form>
    <?php endif; ?>
    <div class="auth-link">Already have an account? <a href="index.php">Sign in</a></div>
  </div>
</div>
<script src="assets/script.js"></script>
</body>
</html>
