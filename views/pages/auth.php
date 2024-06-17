<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/www/vkr/config/config.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = filter_var(trim($_POST['login']), FILTER_SANITIZE_EMAIL);
    $pass = filter_var(trim($_POST['pass']), FILTER_SANITIZE_EMAIL);

	//Get DB instance.
	$db = getDbInstance();
	$db->where("login", $login);
	$row = $db->get('users');
	if ($db->count >= 1) {

		$db_pass = $row[0]['pass'];
		$user_id = $row[0]['id'];
        $pass = md5($pass);
		if ($pass == $db_pass) {
			$_SESSION['user_logged_in'] = TRUE;
			$_SESSION['user_role'] = $row[0]['user_role'];
			$_SESSION['login'] = $row[0]['login'];
			$_SESSION['user_id'] = $row[0]['id'];
            //Authentication successfull redirect user
			header('Location:/www/vkr/index.php');
        } else {
		
			$_SESSION['login_failure'] = "Invalid user name or password";
			header('Location:/www/vkr/views/pages/login.php');
		}
        exit;
    } else {
		$_SESSION['login_failure'] = "Invalid user name or password";
		header('Location:/www/vkr/views/pages/login.php');
		exit;

	}
}else {
	die('Method Not allowed');
}
?>