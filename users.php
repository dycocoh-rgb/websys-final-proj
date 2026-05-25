<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireAdmin();
$page_title = "Users";
$users = $conn->query("SELECT u.*, p.fname, p.lname, p.sex, c.chapter_LOC FROM user_account u
    LEFT JOIN profile p ON u.user_id=p.user_id
    LEFT JOIN chapter c ON u.user_database=c.user_database
    ORDER BY u.user_id")->fetch_all(MYSQLI_ASSOC);
require_once '../includes/header.php';
?>
<div class="page-header"><h1><i class="bi bi-people-fill"></i> Users</h1><p><?= count($users) ?> registered users</p></div>
<div class="filter-bar">
  <div class="search-box"><span class="search-icon"><i class="bi bi-search"></i></span><input id="tableSearch" type="text" placeholder="Search users..."/></div>
</div>
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>User ID</th><th>Name</th><th>Email</th><th>Chapter</th><th>Sex</th><th>Joined</th></tr></thead>
      <tbody>
        <?php foreach ($users as $u): ?>
        <tr>
          <td><strong style="color:var(--orange)"><?= $u['user_id'] ?></strong></td>
          <td><?= htmlspecialchars("{$u['fname']} {$u['lname']}") ?></td>
          <td style="color:#777;font-size:12px"><?= htmlspecialchars($u['email']) ?></td>
          <td><?= htmlspecialchars($u['chapter_LOC']??'—') ?></td>
          <td><?= $u['sex']==='M'?'Male':'Female' ?></td>
          <td style="font-size:12px"><?= $u['created_at'] ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
<?php require_once '../includes/footer.php'; ?>
