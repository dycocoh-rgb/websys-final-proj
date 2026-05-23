<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: /blood-bank/index.php");
        exit();
    }
}

function requireAdmin() {
    if (!isAdmin()) {
        header("Location: /blood-bank/index.php");
        exit();
    }
}

function getDonorId($conn, $user_id) {
    $ur = $conn->query("SELECT user_role_id FROM user_role WHERE user_id='$user_id' AND is_active=1")->fetch_assoc();
    if (!$ur) return null;
    $d = $conn->query("SELECT donor_id FROM donor WHERE user_role_id='{$ur['user_role_id']}'")->fetch_assoc();
    return $d ? $d['donor_id'] : null;
}

function getRecipientId($conn, $user_id) {
    $ur = $conn->query("SELECT user_role_id FROM user_role WHERE user_id='$user_id' AND is_active=1")->fetch_assoc();
    if (!$ur) return null;
    $r = $conn->query("SELECT recipient_id FROM recipient WHERE user_role_id='{$ur['user_role_id']}'")->fetch_assoc();
    return $r ? $r['recipient_id'] : null;
}
?>
