<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireAdmin();
$page_title = "Admin Dashboard";

$total_donors     = $conn->query("SELECT COUNT(*) c FROM donor")->fetch_assoc()['c'];
$total_recipients = $conn->query("SELECT COUNT(*) c FROM recipient")->fetch_assoc()['c'];
$total_users      = $conn->query("SELECT COUNT(*) c FROM user_account")->fetch_assoc()['c'];
$stored_units     = $conn->query("SELECT COUNT(*) c FROM blood_unit WHERE unit_status='stored'")->fetch_assoc()['c'];
$pending_requests = $conn->query("SELECT COUNT(*) c FROM blood_request WHERE req_status='pending'")->fetch_assoc()['c'];
$total_events     = $conn->query("SELECT COUNT(*) c FROM event")->fetch_assoc()['c'];
$completed_appts  = $conn->query("SELECT COUNT(*) c FROM appointment WHERE appointment_status='completed'")->fetch_assoc()['c'];
$total_releases   = $conn->query("SELECT COUNT(*) c FROM blood_release")->fetch_assoc()['c'];

$bt_rows = $conn->query("SELECT blood_type, COUNT(*) c FROM donor GROUP BY blood_type ORDER BY c DESC")->fetch_all(MYSQLI_ASSOC);
$bt_colors = ['O+'=>'#e53935','A+'=>'#1e88e5','B+'=>'#43a047','AB+'=>'#8e24aa','O-'=>'#b71c1c','A-'=>'#1565c0','B-'=>'#2e7d32','AB-'=>'#6a1b9a'];

$recent_requests = $conn->query("SELECT br.*, p.fname, p.lname FROM blood_request br
    JOIN recipient r ON br.recipient_id=r.recipient_id
    JOIN user_role ur ON r.user_role_id=ur.user_role_id
    JOIN profile p ON ur.user_id=p.user_id
    ORDER BY br.request_date DESC LIMIT 5")->fetch_all(MYSQLI_ASSOC);

require_once '../includes/header.php';
?>
<div class="page-header"><h1>🏠 Admin Dashboard</h1><p>Blood Bank Management System Overview</p></div>
<div class="stats-grid">
  <div class="stat-card" style="border-left:4px solid #e53935"><div class="stat-icon" style="background:#fce4ec">🩸</div><div><div class="stat-value"><?= $total_donors ?></div><div class="stat-label">Total Donors</div></div></div>
  <div class="stat-card" style="border-left:4px solid #1e88e5"><div class="stat-icon" style="background:#e3f2fd">🏥</div><div><div class="stat-value"><?= $total_recipients ?></div><div class="stat-label">Total Recipients</div></div></div>
  <div class="stat-card" style="border-left:4px solid #43a047"><div class="stat-icon" style="background:#e8f5e9">💉</div><div><div class="stat-value"><?= $stored_units ?></div><div class="stat-label">Stored Units</div></div></div>
  <div class="stat-card" style="border-left:4px solid #fb8c00"><div class="stat-icon" style="background:#fff3e0">📅</div><div><div class="stat-value"><?= $total_events ?></div><div class="stat-label">Events</div></div></div>
  <div class="stat-card" style="border-left:4px solid #8e24aa"><div class="stat-icon" style="background:#f3e5f5">✅</div><div><div class="stat-value"><?= $completed_appts ?></div><div class="stat-label">Completed Donations</div></div></div>
  <div class="stat-card" style="border-left:4px solid #e53935"><div class="stat-icon" style="background:#fce4ec">⏳</div><div><div class="stat-value"><?= $pending_requests ?></div><div class="stat-label">Pending Requests</div></div></div>
  <div class="stat-card" style="border-left:4px solid #1e88e5"><div class="stat-icon" style="background:#e3f2fd">👥</div><div><div class="stat-value"><?= $total_users ?></div><div class="stat-label">Total Users</div></div></div>
  <div class="stat-card" style="border-left:4px solid #43a047"><div class="stat-icon" style="background:#e8f5e9">📦</div><div><div class="stat-value"><?= $total_releases ?></div><div class="stat-label">Units Released</div></div></div>
</div>

<div class="grid-2">
  <div class="card">
    <div class="card-title">🩸 Blood Type Distribution</div>
    <div style="display:flex;flex-wrap:wrap;gap:10px">
      <?php foreach ($bt_rows as $bt): ?>
      <div style="background:<?= $bt_colors[$bt['blood_type']]??'#555' ?>;color:#fff;border-radius:12px;padding:12px 18px;text-align:center;min-width:70px">
        <div style="font-size:20px;font-weight:900"><?= $bt['blood_type'] ?></div>
        <div style="font-size:12px;opacity:0.9"><?= $bt['c'] ?> donor<?= $bt['c']>1?'s':'' ?></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="card">
    <div class="card-title">📬 Recent Blood Requests</div>
    <table style="width:100%;font-size:13px">
      <thead><tr><th>ID</th><th>Recipient</th><th>Blood Type</th><th>Status</th></tr></thead>
      <tbody>
        <?php foreach ($recent_requests as $r): ?>
        <tr>
          <td><strong style="color:var(--blue)"><?= $r['request_id'] ?></strong></td>
          <td><?= htmlspecialchars("{$r['fname']} {$r['lname']}") ?></td>
          <td><span class="blood-badge" style="background:<?= $bt_colors[$r['blood_type']]??'#555' ?>"><?= $r['blood_type'] ?></span></td>
          <td><span class="badge badge-<?= $r['req_status'] ?>"><?= $r['req_status'] ?></span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>
