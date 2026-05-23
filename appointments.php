<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireAdmin();
$page_title = "Appointments";
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $appt_id = $conn->real_escape_string($_POST['appointment_id']);
    $status  = $conn->real_escape_string($_POST['appointment_status']);
    $conn->query("UPDATE appointment SET appointment_status='$status' WHERE appointment_id='$appt_id'");
    if ($status === 'completed') {
        $appt = $conn->query("SELECT donor_id FROM appointment WHERE appointment_id='$appt_id'")->fetch_assoc();
        if ($appt) {
            $conn->query("UPDATE donor SET no_times_donated=no_times_donated+1 WHERE donor_id='{$appt['donor_id']}'");
            $bu_res = $conn->query("SELECT blood_unit_id FROM blood_unit ORDER BY blood_unit_id DESC LIMIT 1")->fetch_assoc();
            $last_bu = $bu_res ? intval(substr($bu_res['blood_unit_id'], 2)) : 0;
            $bu_id = 'BU' . str_pad($last_bu + 1, 2, '0', STR_PAD_LEFT);
            $donor = $conn->query("SELECT blood_type FROM donor WHERE donor_id='{$appt['donor_id']}'")->fetch_assoc();
            $expiry = date('Y-m-d', strtotime('+42 days'));
            $conn->query("INSERT INTO blood_unit (blood_unit_id, appointment_id, units_collected, unit_status, expiry_date) VALUES ('$bu_id','$appt_id',1,'stored','$expiry')");
        }
    }
    $success = "Appointment updated.";
}

$appointments = $conn->query("SELECT a.*, e.event_name, d.blood_type, p.fname, p.lname FROM appointment a
    JOIN event e ON a.event_id=e.event_id
    JOIN donor d ON a.donor_id=d.donor_id
    JOIN user_role ur ON d.user_role_id=ur.user_role_id
    JOIN profile p ON ur.user_id=p.user_id
    ORDER BY a.appointment_date_time DESC")->fetch_all(MYSQLI_ASSOC);
$bt_colors = ['O+'=>'#e53935','A+'=>'#1e88e5','B+'=>'#43a047','AB+'=>'#8e24aa','O-'=>'#b71c1c','A-'=>'#1565c0','B-'=>'#2e7d32','AB-'=>'#6a1b9a'];
require_once '../includes/header.php';
?>
<div class="page-header"><h1>📋 Appointments</h1><p><?= count($appointments) ?> total appointments</p></div>
<?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<div class="filter-bar">
  <div class="search-box"><span class="search-icon">🔍</span><input id="tableSearch" type="text" placeholder="Search appointments..."/></div>
</div>
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>ID</th><th>Donor</th><th>Blood Type</th><th>Event</th><th>Date & Time</th><th>Status</th><th>Action</th></tr></thead>
      <tbody>
        <?php foreach ($appointments as $a): ?>
        <tr>
          <td><strong style="color:var(--purple)"><?= $a['appointment_id'] ?></strong></td>
          <td><?= htmlspecialchars("{$a['fname']} {$a['lname']}") ?></td>
          <td><span class="blood-badge" style="background:<?= $bt_colors[$a['blood_type']]??'#555' ?>"><?= $a['blood_type'] ?></span></td>
          <td style="font-size:12px"><?= htmlspecialchars($a['event_name']) ?></td>
          <td style="font-size:12px"><?= $a['appointment_date_time'] ?></td>
          <td><span class="badge badge-<?= str_replace('-','_',$a['appointment_status']) ?>"><?= $a['appointment_status'] ?></span></td>
          <td>
            <?php if ($a['appointment_status'] === 'scheduled'): ?>
            <form method="POST" style="display:inline">
              <input type="hidden" name="appointment_id" value="<?= $a['appointment_id'] ?>"/>
              <select name="appointment_status" style="padding:4px 8px;border-radius:6px;border:1px solid #ddd;font-size:12px">
                <option value="scheduled">Scheduled</option>
                <option value="completed">Completed</option>
                <option value="cancelled">Cancelled</option>
                <option value="no-show">No-show</option>
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
