<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireAdmin();
$page_title = "Blood Inventory";
$bt_colors = ['O+'=>'#e53935','A+'=>'#1e88e5','B+'=>'#43a047','AB+'=>'#8e24aa','O-'=>'#b71c1c','A-'=>'#1565c0','B-'=>'#2e7d32','AB-'=>'#6a1b9a'];
$units = $conn->query("SELECT bu.*, d.blood_type, p.fname, p.lname FROM blood_unit bu
    JOIN appointment a ON bu.appointment_id=a.appointment_id
    JOIN donor d ON a.donor_id=d.donor_id
    JOIN user_role ur ON d.user_role_id=ur.user_role_id
    JOIN profile p ON ur.user_id=p.user_id
    ORDER BY bu.blood_unit_id")->fetch_all(MYSQLI_ASSOC);
$stored = array_filter($units, fn($u) => $u['unit_status']==='stored');
$released = array_filter($units, fn($u) => $u['unit_status']==='released');
$reserved = array_filter($units, fn($u) => $u['unit_status']==='reserved');
require_once '../includes/header.php';
?>
<div class="page-header"><h1><i class="bi bi-capsule"></i> Blood Inventory</h1><p><?= count($units) ?> total blood units</p></div>
<div class="stats-grid" style="grid-template-columns:repeat(4,1fr)">
  <div class="stat-card" style="border-left:4px solid #43a047"><div class="stat-icon" style="background:#e8f5e9">🟢</div><div><div class="stat-value"><?= count($stored) ?></div><div class="stat-label">Stored</div></div></div>
  <div class="stat-card" style="border-left:4px solid #1e88e5"><div class="stat-icon" style="background:#e3f2fd">🔵</div><div><div class="stat-value"><?= count($released) ?></div><div class="stat-label">Released</div></div></div>
  <div class="stat-card" style="border-left:4px solid #8e24aa"><div class="stat-icon" style="background:#f3e5f5">🟣</div><div><div class="stat-value"><?= count($reserved) ?></div><div class="stat-label">Reserved</div></div></div>
  <div class="stat-card" style="border-left:4px solid #e53935"><div class="stat-icon" style="background:#fce4ec"><i class="bi bi-box-seam"></i></div><div><div class="stat-value"><?= count($units) ?></div><div class="stat-label">Total Units</div></div></div>
</div>
<div class="filter-bar">
  <div class="search-box"><span class="search-icon"><i class="bi bi-search"></i></span><input id="tableSearch" type="text" placeholder="Search units..."/></div>
</div>
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Unit ID</th><th>Donor</th><th>Blood Type</th><th>Appointment</th><th>Status</th><th>Expiry Date</th></tr></thead>
      <tbody>
        <?php foreach ($units as $u): ?>
        <tr>
          <td><strong style="color:var(--green)"><?= $u['blood_unit_id'] ?></strong></td>
          <td><?= htmlspecialchars("{$u['fname']} {$u['lname']}") ?></td>
          <td><span class="blood-badge" style="background:<?= $bt_colors[$u['blood_type']]??'#555' ?>"><?= $u['blood_type'] ?></span></td>
          <td style="font-size:12px"><?= $u['appointment_id'] ?></td>
          <td><span class="badge badge-<?= $u['unit_status'] ?>"><?= $u['unit_status'] ?></span></td>
          <td style="color:<?= strtotime($u['expiry_date'])<time()?'#e53935':'#555' ?>;font-size:12px"><?= $u['expiry_date'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>
