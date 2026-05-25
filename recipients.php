<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireAdmin();
$page_title = "Recipients";
$recipients = $conn->query("SELECT rc.*, p.fname, p.lname, p.mobile_no,
    (SELECT COUNT(*) FROM blood_request WHERE recipient_id=rc.recipient_id) as req_count
    FROM recipient rc
    JOIN user_role ur ON rc.user_role_id=ur.user_role_id
    JOIN profile p ON ur.user_id=p.user_id
    ORDER BY rc.recipient_id")->fetch_all(MYSQLI_ASSOC);
require_once '../includes/header.php';
?>
<div class="page-header"><h1><i class="bi bi-hospital-fill"></i> Recipients</h1><p><?= count($recipients) ?> registered recipients</p></div>
<div class="filter-bar">
  <div class="search-box"><span class="search-icon"><i class="bi bi-search"></i></span><input id="tableSearch" type="text" placeholder="Search recipients..."/></div>
</div>
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Recipient ID</th><th>Name</th><th>Mobile</th><th>Last Request</th><th>Total Requests</th></tr></thead>
      <tbody>
        <?php foreach ($recipients as $r): ?>
        <tr>
          <td><strong style="color:var(--blue)"><?= $r['recipient_id'] ?></strong></td>
          <td><?= htmlspecialchars("{$r['fname']} {$r['lname']}") ?></td>
          <td style="color:#777"><?= htmlspecialchars($r['mobile_no']) ?></td>
          <td><?= $r['last_request_date'] ?? '—' ?></td>
          <td><strong><?= $r['req_count'] ?></strong></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>
