<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();
$page_title = "Dashboard";

$user_id = $_SESSION['user_id'];
$profile = $conn->query("SELECT * FROM profile WHERE user_id='$user_id'")->fetch_assoc();
$user    = $conn->query("SELECT * FROM user_account WHERE user_id='$user_id'")->fetch_assoc();
$chapter = $user ? $conn->query("SELECT * FROM chapter WHERE user_database='{$user['user_database']}'")->fetch_assoc() : null;

// Role checks
$ur = $conn->query("SELECT * FROM user_role WHERE user_id='$user_id' AND is_active=1")->fetch_assoc();
$donor = $ur ? $conn->query("SELECT * FROM donor WHERE user_role_id='{$ur['user_role_id']}'")->fetch_assoc() : null;
$recipient = $ur ? $conn->query("SELECT * FROM recipient WHERE user_role_id='{$ur['user_role_id']}'")->fetch_assoc() : null;

// Stats
$appt_count = $donor ? $conn->query("SELECT COUNT(*) c FROM appointment WHERE donor_id='{$donor['donor_id']}'")->fetch_assoc()['c'] : 0;
$req_count  = $recipient ? $conn->query("SELECT COUNT(*) c FROM blood_request WHERE recipient_id='{$recipient['recipient_id']}'")->fetch_assoc()['c'] : 0;
$pending_req = $recipient ? $conn->query("SELECT COUNT(*) c FROM blood_request WHERE recipient_id='{$recipient['recipient_id']}' AND req_status='pending'")->fetch_assoc()['c'] : 0;

require_once 'includes/header.php';
?>
<div class="page-header">
  <h1>Welcome back, <?= htmlspecialchars($profile['fname'] ?? 'User') ?>! 👋</h1>
  <p>Here's your BloodBank overview</p>
</div>

<!-- Role Status Banner -->
<?php if (!$donor && !$recipient): ?>
<div class="alert alert-info" style="margin-bottom:24px">
  You haven't registered as a donor or recipient yet.
  <a href="donor-register.php" style="font-weight:700;color:var(--red)">Register as Donor</a> or
  <a href="recipient-register.php" style="font-weight:700;color:var(--blue)">Register as Recipient</a>
</div>
<?php endif; ?>

<div class="stats-grid">
  <?php if ($donor): ?>
  <div class="stat-card" style="border-left:4px solid var(--red)">
    <div class="stat-icon" style="background:#fce4ec">🩸</div>
    <div>
      <div class="stat-value"><?= $donor['no_times_donated'] ?></div>
      <div class="stat-label">Times Donated</div>
    </div>
  </div>
  <div class="stat-card" style="border-left:4px solid var(--purple)">
    <div class="stat-icon" style="background:#f3e5f5">📋</div>
    <div>
      <div class="stat-value"><?= $appt_count ?></div>
      <div class="stat-label">Appointments</div>
    </div>
  </div>
  <?php endif; ?>
  <?php if ($recipient): ?>
  <div class="stat-card" style="border-left:4px solid var(--blue)">
    <div class="stat-icon" style="background:#e3f2fd">📬</div>
    <div>
      <div class="stat-value"><?= $req_count ?></div>
      <div class="stat-label">Blood Requests</div>
    </div>
  </div>
  <div class="stat-card" style="border-left:4px solid var(--orange)">
    <div class="stat-icon" style="background:#fff3e0">⏳</div>
    <div>
      <div class="stat-value"><?= $pending_req ?></div>
      <div class="stat-label">Pending Requests</div>
    </div>
  </div>
  <?php endif; ?>
</div>

<div class="grid-2">
  <!-- Profile Summary -->
  <div class="card">
    <div class="card-title">👤 My Profile</div>
    <?php if ($profile): ?>
    <div class="profile-header">
      <div class="profile-avatar"><?= strtoupper(substr($profile['fname'],0,1)) ?></div>
      <div class="profile-info">
        <h2><?= htmlspecialchars("{$profile['fname']} {$profile['mname']}. {$profile['lname']}") ?></h2>
        <p><?= htmlspecialchars($user['email']) ?></p>
      </div>
    </div>
    <div class="info-grid">
      <div class="info-item"><label>Birth Date</label><span><?= $profile['birth_date'] ?></span></div>
      <div class="info-item"><label>Sex</label><span><?= $profile['sex']==='M'?'Male':'Female' ?></span></div>
      <div class="info-item"><label>Mobile</label><span><?= htmlspecialchars($profile['mobile_no']) ?></span></div>
      <div class="info-item"><label>Chapter</label><span><?= $chapter['chapter_LOC'] ?? '—' ?></span></div>
    </div>
    <a href="profile.php" class="btn btn-secondary btn-sm" style="margin-top:16px">Edit Profile</a>
    <?php else: ?>
    <div class="empty"><div class="empty-icon">👤</div><p>No profile found.</p></div>
    <?php endif; ?>
  </div>

  <!-- Role Info -->
  <div class="card">
    <div class="card-title">🏷️ My Roles</div>
    <?php if ($donor): ?>
    <div style="background:#fff5f5;border-radius:12px;padding:16px;margin-bottom:12px;border-left:4px solid var(--red)">
      <div style="font-weight:800;color:var(--red);margin-bottom:6px">🩸 Donor</div>
      <div style="font-size:13px;color:#555">Blood Type: <span style="font-weight:700;background:<?= ['O+'=>'#e53935','A+'=>'#1e88e5','B+'=>'#43a047','AB+'=>'#8e24aa','O-'=>'#b71c1c','A-'=>'#1565c0','B-'=>'#2e7d32','AB-'=>'#6a1b9a'][$donor['blood_type']]??'#555' ?>;color:#fff;padding:2px 10px;border-radius:20px;font-size:12px"><?= $donor['blood_type'] ?></span></div>
      <div style="font-size:13px;color:#555;margin-top:4px">Donations: <strong><?= $donor['no_times_donated'] ?></strong></div>
      <a href="appointments.php" class="btn btn-sm btn-primary" style="margin-top:10px">View Appointments</a>
    </div>
    <?php else: ?>
    <div style="background:#f8f9ff;border-radius:12px;padding:16px;margin-bottom:12px;border:2px dashed #e0e0e8;text-align:center">
      <div style="font-size:28px;margin-bottom:8px">🩸</div>
      <p style="color:#888;font-size:13px;margin-bottom:10px">Not registered as a donor yet</p>
      <a href="donor-register.php" class="btn btn-sm btn-primary">Register as Donor</a>
    </div>
    <?php endif; ?>

    <?php if ($recipient): ?>
    <div style="background:#f0f7ff;border-radius:12px;padding:16px;border-left:4px solid var(--blue)">
      <div style="font-weight:800;color:var(--blue);margin-bottom:6px">🏥 Recipient</div>
      <div style="font-size:13px;color:#555">Last Request: <strong><?= $recipient['last_request_date'] ?? 'None' ?></strong></div>
      <a href="my-requests.php" class="btn btn-sm btn-blue" style="margin-top:10px">View Requests</a>
    </div>
    <?php else: ?>
    <div style="background:#f8f9ff;border-radius:12px;padding:16px;border:2px dashed #e0e0e8;text-align:center">
      <div style="font-size:28px;margin-bottom:8px">🏥</div>
      <p style="color:#888;font-size:13px;margin-bottom:10px">Not registered as a recipient yet</p>
      <a href="recipient-register.php" class="btn btn-sm btn-blue">Register as Recipient</a>
    </div>
    <?php endif; ?>
  </div>
</div>

<!-- Upcoming Events -->
<div class="card" style="margin-top:20px">
  <div class="card-header">
    <h3>📅 Upcoming Blood Drive Events</h3>
    <a href="appointments.php" class="btn btn-sm btn-primary">Book Appointment</a>
  </div>
  <div class="event-cards">
    <?php
    $events = $conn->query("SELECT e.*, a.username as admin_name FROM event e JOIN admin a ON e.managed_by=a.admin_id WHERE e.event_date >= CURDATE() ORDER BY e.event_date LIMIT 6")->fetch_all(MYSQLI_ASSOC);
    foreach ($events as $ev):
      $appt_c = $conn->query("SELECT COUNT(*) c FROM appointment WHERE event_id='{$ev['event_id']}'")->fetch_assoc()['c'];
      $pct = $ev['capacity'] > 0 ? round(($appt_c/$ev['capacity'])*100) : 0;
    ?>
    <div class="event-card">
      <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:6px">
        <span style="font-size:11px;font-weight:700;color:var(--red)"><?= $ev['event_id'] ?></span>
        <span style="font-size:11px;color:#aaa"><?= $ev['event_date'] ?></span>
      </div>
      <h3><?= htmlspecialchars($ev['event_name']) ?></h3>
      <div class="event-meta">📍 <?= htmlspecialchars($ev['event_location']) ?></div>
      <div class="event-meta">👤 <?= htmlspecialchars($ev['admin_name']) ?></div>
      <div style="font-size:12px;color:#888;margin-top:8px"><?= $appt_c ?>/<?= $ev['capacity'] ?> slots filled</div>
      <div class="progress-bar"><div class="progress-fill" style="width:<?= min($pct,100) ?>%"></div></div>
    </div>
    <?php endforeach; ?>
    <?php if (empty($events)): ?>
    <div class="empty" style="grid-column:1/-1"><div class="empty-icon">📅</div><p>No upcoming events</p></div>
    <?php endif; ?>
  </div>
</div>
<?php require_once 'includes/footer.php'; ?>
