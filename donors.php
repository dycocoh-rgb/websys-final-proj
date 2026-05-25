<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireAdmin();
$page_title = "Donors";
$bt_colors = ['O+'=>'#e53935','A+'=>'#1e88e5','B+'=>'#43a047','AB+'=>'#8e24aa','O-'=>'#b71c1c','A-'=>'#1565c0','B-'=>'#2e7d32','AB-'=>'#6a1b9a'];
$donors = $conn->query("SELECT d.*, p.fname, p.lname, p.mobile_no, ur.is_active FROM donor d
    JOIN user_role ur ON d.user_role_id=ur.user_role_id
    JOIN profile p ON ur.user_id=p.user_id
    ORDER BY d.donor_id")->fetch_all(MYSQLI_ASSOC);
require_once '../includes/header.php';
?>
<div class="page-header"><h1><i class="bi bi-droplet-fill"></i> Donors</h1><p><?= count($donors) ?> registered donors</p></div>
<div class="filter-bar">
  <div class="search-box"><span class="search-icon"><i class="bi bi-search"></i></span><input id="tableSearch" type="text" placeholder="Search donors..."/></div>
</div>
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Donor ID</th><th>Name</th><th>Blood Type</th><th>Donations</th><th>Mobile</th><th>Status</th></tr></thead>
      <tbody>
        <?php foreach ($donors as $d): ?>
        <tr>
          <td><strong style="color:var(--red)"><?= $d['donor_id'] ?></strong></td>
          <td><?= htmlspecialchars("{$d['fname']} {$d['lname']}") ?></td>
          <td><span class="blood-badge" style="background:<?= $bt_colors[$d['blood_type']]??'#555' ?>"><?= $d['blood_type'] ?></span></td>
          <td><strong><?= $d['no_times_donated'] ?></strong></td>
          <td style="color:#777"><?= htmlspecialchars($d['mobile_no']) ?></td>
          <td><span class="badge badge-<?= $d['is_active']?'active':'inactive' ?>"><?= $d['is_active']?'Active':'Inactive' ?></span></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>
