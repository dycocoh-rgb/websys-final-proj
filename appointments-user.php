<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';
requireLogin();
$page_title = "My Appointments";
$user_id = $_SESSION['user_id'];
$error = ''; $success = '';

$ur = $conn->query("SELECT * FROM user_role WHERE user_id='$user_id' AND is_active=1")->fetch_assoc();
$donor = $ur ? $conn->query("SELECT * FROM donor WHERE user_role_id='{$ur['user_role_id']}'")->fetch_assoc() : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $donor) {
    $event_id = $conn->real_escape_string($_POST['event_id']);
    $datetime = $conn->real_escape_string($_POST['appointment_datetime']);
    $donor_id = $donor['donor_id'];

    $event = $conn->query("SELECT * FROM event WHERE event_id='$event_id'")->fetch_assoc();
    if ($event) {
        $cap = $conn->query("SELECT COUNT(*) c FROM appointment WHERE event_id='$event_id'")->fetch_assoc()['c'];
        if ($cap >= $event['capacity']) {
            $error = "This event is already at full capacity.";
        } else {
            $a_res = $conn->query("SELECT appointment_id FROM appointment ORDER BY appointment_id DESC LIMIT 1")->fetch_assoc();
            $last_a = $a_res ? intval(substr($a_res['appointment_id'], 1)) : 0;
            $appt_id = 'A' . str_pad($last_a + 1, 3, '0', STR_PAD_LEFT);
            $conn->query("INSERT INTO appointment (appointment_id, donor_id, event_id, appointment_date_time, appointment_location, appointment_status)
                VALUES ('$appt_id', '$donor_id', '$event_id', '$datetime', '{$event['event_location']}', 'scheduled')");
            $success = "Appointment booked successfully!";
        }
    }
}

$events = $conn->query("SELECT * FROM event WHERE event_date >= CURDATE() ORDER BY event_date")->fetch_all(MYSQLI_ASSOC);
$appointments = $donor ? $conn->query("SELECT a.*, e.event_name, e.event_location FROM appointment a JOIN event e ON a.event_id=e.event_id WHERE a.donor_id='{$donor['donor_id']}' ORDER BY a.appointment_date_time DESC")->fetch_all(MYSQLI_ASSOC) : [];

require_once 'includes/header.php';
?>
<div class="page-header">
  <h1>📋 My Appointments</h1>
  <p>Book and manage your donation appointments</p>
</div>

<?php if (!$donor): ?>
<div class="alert alert-info">You need to <a href="donor-register.php" style="font-weight:700;color:var(--red)">register as a donor</a> first before booking appointments.</div>
<?php else: ?>
<?php if ($error): ?><div class="alert alert-error"><?= $error ?></div><?php endif; ?>
<?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>

<div class="grid-2" style="margin-bottom:24px">
  <div class="card">
    <div class="card-title">📅 Book New Appointment</div>
    <form method="POST">
      <div class="form-group">
        <label>Select Event</label>
        <select name="event_id" required>
          <option value="">Choose an event</option>
          <?php foreach ($events as $ev): ?>
            <option value="<?= $ev['event_id'] ?>"><?= htmlspecialchars($ev['event_name']) ?> — <?= $ev['event_date'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group">
        <label>Preferred Date & Time</label>
        <input type="datetime-local" name="appointment_datetime" required/>
      </div>
      <button type="submit" class="btn btn-primary btn-full">Book Appointment</button>
    </form>
  </div>
  <div class="card">
    <div class="card-title">🩸 Donor Info</div>
    <div style="text-align:center;padding:10px">
      <div style="font-size:48px;font-weight:900;color:var(--red)"><?= $donor['blood_type'] ?></div>
      <div style="font-size:14px;color:#888;margin-bottom:16px">Your Blood Type</div>
      <div style="font-size:28px;font-weight:800"><?= $donor['no_times_donated'] ?></div>
      <div style="font-size:14px;color:#888">Times Donated</div>
    </div>
  </div>
</div>

<div class="card">
  <div class="card-title">My Appointment History</div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>ID</th><th>Event</th><th>Location</th><th>Date & Time</th><th>Status</th></tr></thead>
      <tbody>
        <?php foreach ($appointments as $a): ?>
        <tr>
          <td><strong style="color:var(--purple)"><?= $a['appointment_id'] ?></strong></td>
          <td><?= htmlspecialchars($a['event_name']) ?></td>
          <td style="color:#777"><?= htmlspecialchars($a['event_location']) ?></td>
          <td><?= $a['appointment_date_time'] ?></td>
          <td><span class="badge badge-<?= $a['appointment_status'] ?>"><?= $a['appointment_status'] ?></span></td>
        </tr>
        <?php endforeach; ?>
        <?php if (empty($appointments)): ?>
        <tr><td colspan="5"><div class="empty"><div class="empty-icon">📋</div><p>No appointments yet</p></div></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif; ?>
<?php require_once 'includes/footer.php'; ?>
