<?php
session_start();
session_destroy();
header("Location: /blood-bank/index.php");
exit();
?>
