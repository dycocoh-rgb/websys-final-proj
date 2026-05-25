<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();
$page_title = "My Blood Requests";
$user_id = $_SESSION['user_id'];

$ur = $conn->query("SELECT * FROM user_role WHERE user_id='$user_id' AND is_active=1")->fetch_assoc();
$recipient = $ur ? $conn->query("SELECT * FROM recipient WHERE user_role_id='{$ur['user_role_id']}'")->fetch_assoc() : null;

$requests = $recipient ? $conn->query("SELECT br.*, bl.release_date FROM blood_request br LEFT JOIN blood_release bl ON br.request_id=bl.request_id WHERE br.recipient_id='{$recipient['recipient_id']}' ORDER BY br.request_date DESC")->fetch_all(MYSQLI_ASSOC) : [];

$bt_colors = ['O+'=>'#e53935','A+'=>'#1e88e5','B+'=>'#43a047','AB+'=>'#8e24aa','O-'=>'#b71c1c','A-'=>'#1565c0','B-'=>'#2e7d32','AB-'=>'#6a1b9a'];
require_once 'includes/header.php';
?>
<div class="page-header">
  <h1><i class="bi bi-file-earmark-text-fill"></i> My Blood Requests</h1>
  <p>Track all your blood requests</p>
</div>
<?php if (!$recipient): ?>
<div class="alert alert-info">You need to <a href="recipient-register.php" style="font-weight:700">register as a recipient</a> first.</div>
<?php else: ?>
<div style="display:flex;justify-content:flex-end;margin-bottom:16px">
  <a href="request-blood.php" class="btn btn-blue">+ New Request</a>
</div>
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Request ID</th><th>Blood Type</th><th>Units</th><th>Location</th><th>Date</th><th>Status</th><th>Released On</th></tr></thead>
      <tbody>
        <?php foreach ($requests as $r): ?>
        <tr>
          <td><strong style="color:var(--blue)"><?= $r['request_id'] ?></strong></td>
          <td><span class="blood-badge" style="background:<?= $bt_colors[$r['blood_type']]??'#555' ?>"><?= $r['blood_type'] ?></span></td>
          <td><?= $r['units_requested'] ?></td>
          <td style="color:#777"><?= htmlspecialchars($r['request_location']) ?></td>
          <td><?= $r['request_date'] ?></td>
          <td><span class="badge badge-<?= $r['req_status'] ?>"><?= $r['req_status'] ?></span></td>
          <td><?= $r['release_date'] ?? '<span style="color:#aaa">—</span>' ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($requests)): ?>
        <tr><td colspan="7"><div class="empty"><div class="empty-icon"><i class="bi bi-file-earmark-text-fill"></i></div><p>No requests yet</p></div></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
