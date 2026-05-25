<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireAdmin();
$page_title = "Blood Requests";
$success = '';
$bt_colors = ['O+'=>'#e53935','A+'=>'#1e88e5','B+'=>'#43a047','AB+'=>'#8e24aa','O-'=>'#b71c1c','A-'=>'#1565c0','B-'=>'#2e7d32','AB-'=>'#6a1b9a'];

// Update status
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['request_id'])) {
    $rid    = $conn->real_escape_string($_POST['request_id']);
    $status = $conn->real_escape_string($_POST['req_status']);
    $conn->query("UPDATE blood_request SET req_status='$status' WHERE request_id='$rid'");

    if ($status === 'completed' && isset($_POST['blood_unit_id'])) {
        $buid = $conn->real_escape_string($_POST['blood_unit_id']);
        $re_res = $conn->query("SELECT release_id FROM blood_release ORDER BY release_id DESC LIMIT 1")->fetch_assoc();
        $last_re = $re_res ? intval(substr($re_res['release_id'], 2)) : 0;
        $re_id = 'RE' . str_pad($last_re + 1, 2, '0', STR_PAD_LEFT);
        $conn->query("INSERT INTO blood_release (release_id, request_id, blood_unit_id, units_released, release_date) VALUES ('$re_id', '$rid', '$buid', 1, CURDATE())");
        $conn->query("UPDATE blood_unit SET unit_status='released' WHERE blood_unit_id='$buid'");
    }
    $success = "Request updated successfully.";
}

$requests = $conn->query("SELECT br.*, p.fname, p.lname FROM blood_request br
    JOIN recipient r ON br.recipient_id=r.recipient_id
    JOIN user_role ur ON r.user_role_id=ur.user_role_id
    JOIN profile p ON ur.user_id=p.user_id
    ORDER BY br.request_date DESC")->fetch_all(MYSQLI_ASSOC);
$stored_units = $conn->query("SELECT bu.*, d.blood_type FROM blood_unit bu JOIN appointment a ON bu.appointment_id=a.appointment_id JOIN donor d ON a.donor_id=d.donor_id WHERE bu.unit_status='stored'")->fetch_all(MYSQLI_ASSOC);
require_once '../includes/header.php';
?>
<div class="page-header"><h1><i class="bi bi-envelope-fill"></i> Blood Requests</h1><p>Manage and fulfill blood requests</p></div>
<?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>ID</th><th>Recipient</th><th>Blood Type</th><th>Units</th><th>Location</th><th>Date</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
        <?php foreach ($requests as $r): ?>
        <tr>
          <td><strong style="color:var(--blue)"><?= $r['request_id'] ?></strong></td>
          <td><?= htmlspecialchars("{$r['fname']} {$r['lname']}") ?></td>
          <td><span class="blood-badge" style="background:<?= $bt_colors[$r['blood_type']]??'#555' ?>"><?= $r['blood_type'] ?></span></td>
          <td><?= $r['units_requested'] ?></td>
          <td style="font-size:12px;color:#777"><?= htmlspecialchars($r['request_location']) ?></td>
          <td style="font-size:12px"><?= $r['request_date'] ?></td>
          <td><span class="badge badge-<?= $r['req_status'] ?>"><?= $r['req_status'] ?></span></td>
          <td>
            <?php if ($r['req_status'] === 'pending'): ?>
            <form method="POST" style="display:inline">
              <input type="hidden" name="request_id" value="<?= $r['request_id'] ?>"/>
              <select name="req_status" style="padding:4px 8px;border-radius:6px;border:1px solid #ddd;font-size:12px">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
              </select>
              <select name="blood_unit_id" style="padding:4px 8px;border-radius:6px;border:1px solid #ddd;font-size:12px;margin-left:4px">
                <option value="">Assign unit</option>
                <?php foreach ($stored_units as $bu): ?>
                  <?php if ($bu['blood_type'] === $r['blood_type']): ?>
                    <option value="<?= $bu['blood_unit_id'] ?>"><?= $bu['blood_unit_id'] ?> (<?= $bu['blood_type'] ?>)</option>
                  <?php endif; ?>
                <?php endforeach; ?>
              </select>
              <button type="submit" class="btn btn-sm btn-primary" style="margin-left:4px">Update</button>
            </form>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>
