<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireAdmin();
$page_title = "Events";
$success = ''; $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = $conn->real_escape_string(trim($_POST['event_name']));
    $date     = $conn->real_escape_string($_POST['event_date']);
    $location = $conn->real_escape_string(trim($_POST['event_location']));
    $capacity = intval($_POST['capacity']);
    $admin    = $conn->real_escape_string($_POST['managed_by']);
    $e_res = $conn->query("SELECT event_id FROM event ORDER BY event_id DESC LIMIT 1")->fetch_assoc();
    $last_e = $e_res ? intval(substr($e_res['event_id'], 1)) : 0;
    $event_id = 'E' . str_pad($last_e + 1, 2, '0', STR_PAD_LEFT);
    $conn->query("INSERT INTO event (event_id, event_name, event_date, event_location, capacity, managed_by) VALUES ('$event_id','$name','$date','$location',$capacity,'$admin')");
    $success = "Event '$name' created successfully!";
}

$events = $conn->query("SELECT e.*, a.username as admin_name, (SELECT COUNT(*) FROM appointment WHERE event_id=e.event_id) as appt_count FROM event e JOIN admin a ON e.managed_by=a.admin_id ORDER BY e.event_date")->fetch_all(MYSQLI_ASSOC);
$admins = $conn->query("SELECT * FROM admin")->fetch_all(MYSQLI_ASSOC);
require_once '../includes/header.php';
?>
<div class="page-header"><h1>📅 Events</h1><p><?= count($events) ?> blood drive events</p></div>
<?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<div class="grid-2" style="margin-bottom:24px">
  <div class="card">
    <div class="card-title">Add New Event</div>
    <form method="POST">
      <div class="form-group"><label>Event Name</label><input type="text" name="event_name" required/></div>
      <div class="form-row">
        <div class="form-group"><label>Date</label><input type="date" name="event_date" required/></div>
        <div class="form-group"><label>Capacity</label><input type="number" name="capacity" min="1" required/></div>
      </div>
      <div class="form-group"><label>Location</label><input type="text" name="event_location" required/></div>
      <div class="form-group"><label>Managed By</label>
        <select name="managed_by" required>
          <?php foreach ($admins as $a): ?><option value="<?= $a['admin_id'] ?>"><?= htmlspecialchars($a['username']) ?></option><?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary btn-full">Create Event</button>
    </form>
  </div>
  <div>
    <div class="event-cards">
      <?php foreach (array_slice($events, 0, 4) as $ev):
        $pct = $ev['capacity'] > 0 ? round(($ev['appt_count']/$ev['capacity'])*100) : 0; ?>
      <div class="event-card">
        <div style="display:flex;justify-content:space-between;margin-bottom:6px">
          <span style="font-size:11px;font-weight:700;color:var(--red)"><?= $ev['event_id'] ?></span>
          <span style="font-size:11px;color:#aaa"><?= $ev['event_date'] ?></span>
        </div>
        <h3><?= htmlspecialchars($ev['event_name']) ?></h3>
        <div class="event-meta">📍 <?= htmlspecialchars($ev['event_location']) ?></div>
        <div class="event-meta">👤 <?= htmlspecialchars($ev['admin_name']) ?></div>
        <div style="font-size:12px;color:#888;margin-top:8px"><?= $ev['appt_count'] ?>/<?= $ev['capacity'] ?> slots</div>
        <div class="progress-bar"><div class="progress-fill" style="width:<?= min($pct,100) ?>%"></div></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<div class="card">
  <div class="card-title">All Events</div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>ID</th><th>Event Name</th><th>Date</th><th>Location</th><th>Capacity</th><th>Booked</th><th>Manager</th></tr></thead>
      <tbody>
        <?php foreach ($events as $ev): ?>
        <tr>
          <td><strong style="color:var(--red)"><?= $ev['event_id'] ?></strong></td>
          <td><?= htmlspecialchars($ev['event_name']) ?></td>
          <td><?= $ev['event_date'] ?></td>
          <td style="color:#777;font-size:12px"><?= htmlspecialchars($ev['event_location']) ?></td>
          <td><?= $ev['capacity'] ?></td>
          <td><?= $ev['appt_count'] ?></td>
          <td><?= htmlspecialchars($ev['admin_name']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>
