<?php

session_start();
session_destroy();
// برگشت به صفحه‌ی ورود
header('Location: login.php');
exit;
?>
