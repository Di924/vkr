<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/www/vkr/config/config.php');
session_start();
session_destroy();
session_start();
$_SESSION['user_logged_in'] = FALSE;
header('Location:/www/vkr/');
exit;

 ?>