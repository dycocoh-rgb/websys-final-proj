<?php
require_once __DIR__ . '/auth.php';
$current_page = basename($_SERVER['PHP_SELF']);
$is_admin_page = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;

// Get user info for display
$display_name = $_SESSION['fname'] ?? 'User';
$user_initial = strtoupper(substr($display_name, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BloodBank — <?= $page_title ?? 'Dashboard' ?></title>
  <link rel="stylesheet" href="<?= $is_admin_page ? '../' : '' ?>assets/style.css"/>
</head>
<body>
<div class="layout">
  <aside class="sidebar">
    <div class="sidebar-logo">
      <div class="logo-icon">🩸</div>
      <div class="logo-text">
        <h2>BloodBank</h2>
        <p><?= $is_admin_page ? 'Admin Panel' : 'User Portal' ?></p>
      </div>
    </div>
    <nav>
      <?php if ($is_admin_page): ?>
        <div class="nav-section">Main</div>
        <a href="/blood-bank/admin/index.php" class="nav-item <?= $current_page==='index.php'?'active':'' ?>">
          <span class="nav-icon">🏠</span><span>Dashboard</span>
        </a>
        <div class="nav-section">Blood Management</div>
        <a href="/blood-bank/admin/donors.php" class="nav-item <?= $current_page==='donors.php'?'active':'' ?>">
          <span class="nav-icon">🩸</span><span>Donors</span>
        </a>
        <a href="/blood-bank/admin/recipients.php" class="nav-item <?= $current_page==='recipients.php'?'active':'' ?>">
          <span class="nav-icon">🏥</span><span>Recipients</span>
        </a>
        <a href="/blood-bank/admin/inventory.php" class="nav-item <?= $current_page==='inventory.php'?'active':'' ?>">
          <span class="nav-icon">💉</span><span>Blood Inventory</span>
        </a>
        <a href="/blood-bank/admin/requests.php" class="nav-item <?= $current_page==='requests.php'?'active':'' ?>">
          <span class="nav-icon">📬</span><span>Blood Requests</span>
        </a>
        <div class="nav-section">Events</div>
        <a href="/blood-bank/admin/events.php" class="nav-item <?= $current_page==='events.php'?'active':'' ?>">
          <span class="nav-icon">📅</span><span>Events</span>
        </a>
        <a href="/blood-bank/admin/appointments.php" class="nav-item <?= $current_page==='appointments.php'?'active':'' ?>">
          <span class="nav-icon">📋</span><span>Appointments</span>
        </a>
        <div class="nav-section">Users</div>
        <a href="/blood-bank/admin/users.php" class="nav-item <?= $current_page==='users.php'?'active':'' ?>">
          <span class="nav-icon">👥</span><span>Users</span>
        </a>
        <a href="/blood-bank/admin/feedback.php" class="nav-item <?= $current_page==='feedback.php'?'active':'' ?>">
          <span class="nav-icon">💬</span><span>Feedback</span>
        </a>
      <?php else: ?>
        <div class="nav-section">Main</div>
        <a href="/blood-bank/dashboard.php" class="nav-item <?= $current_page==='dashboard.php'?'active':'' ?>">
          <span class="nav-icon">🏠</span><span>Dashboard</span>
        </a>
        <a href="/blood-bank/profile.php" class="nav-item <?= $current_page==='profile.php'?'active':'' ?>">
          <span class="nav-icon">👤</span><span>My Profile</span>
        </a>
        <div class="nav-section">Donor</div>
        <a href="/blood-bank/donor-register.php" class="nav-item <?= $current_page==='donor-register.php'?'active':'' ?>">
          <span class="nav-icon">🩸</span><span>Become a Donor</span>
        </a>
        <a href="/blood-bank/appointments.php" class="nav-item <?= $current_page==='appointments.php'?'active':'' ?>">
          <span class="nav-icon">📋</span><span>My Appointments</span>
        </a>
        <div class="nav-section">Recipient</div>
        <a href="/blood-bank/recipient-register.php" class="nav-item <?= $current_page==='recipient-register.php'?'active':'' ?>">
          <span class="nav-icon">🏥</span><span>Become a Recipient</span>
        </a>
        <a href="/blood-bank/request-blood.php" class="nav-item <?= $current_page==='request-blood.php'?'active':'' ?>">
          <span class="nav-icon">📬</span><span>Request Blood</span>
        </a>
        <a href="/blood-bank/my-requests.php" class="nav-item <?= $current_page==='my-requests.php'?'active':'' ?>">
          <span class="nav-icon">📄</span><span>My Requests</span>
        </a>
        <div class="nav-section">Other</div>
        <a href="/blood-bank/feedback.php" class="nav-item <?= $current_page==='feedback.php'?'active':'' ?>">
          <span class="nav-icon">💬</span><span>Give Feedback</span>
        </a>
      <?php endif; ?>
    </nav>
    <div class="sidebar-footer">
      <a href="/blood-bank/logout.php" class="nav-item" onclick="return confirm('Are you sure you want to log out?')">
        <span class="nav-icon">🚪</span><span>Logout</span>
      </a>
    </div>
  </aside>

  <div class="main">
    <div class="topbar">
      <div class="topbar-left">
        <strong><?= $page_title ?? 'Dashboard' ?></strong>
      </div>
      <div class="topbar-right">
        <?php if ($is_admin_page): ?>
          <a href="/blood-bank/admin/index.php" class="btn btn-sm btn-secondary">⚙️ Admin</a>
        <?php else: ?>
          <a href="/blood-bank/admin/index.php" class="btn btn-sm btn-secondary" style="<?= isAdmin()?'':'display:none' ?>">⚙️ Admin Panel</a>
        <?php endif; ?>
        <div class="user-chip">
          <div class="avatar"><?= $user_initial ?></div>
          <span><?= htmlspecialchars($display_name) ?></span>
        </div>
      </div>
    </div>
    <div class="content">
