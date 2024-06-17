<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/www/vkr/config/config.php');
include_once(BASE_PATH . '/includes/header.php');
// проверка
if($_SESSION['user_role']=='1'){
    $_SESSION['failure'] = "У вас не хватает прав для совершения этого действия";
    header('location: index.php');
    exit;
}
// РЕДАКТОР ФОТО
require_once BASE_PATH . '/model/PhotoEditor.php';
// ПЕРЕМЕННЫЕ
$GLOBALS['edit'] = false;
$GLOBALS['add'] = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ПОЛУЧЕНИЕ ДАННЫХ ИЗ ПОСТ ЗАПРОСА ФОРМЫ
    $data_to_parse = array_filter($_POST);
    $args['name']        = $data_to_parse['name'];
    $args['description'] = $data_to_parse['description'];
    $args['status_id']   = $data_to_parse['status_id'];
    $args['priority']    = $data_to_parse['priority'];
    $args['dashboard_id']= $data_to_parse['dashboard_id'];
    $args['end_date']    = $data_to_parse['end_date'];
    $args['tag_id']      = isset($data_to_parse['tag_id'])?explode(",", $data_to_parse['tag_id']):"";
    $args['user_id']     = $data_to_parse['user_id'];
    $args['nuser_id']    = $data_to_parse['nuser_id'];
    require_once BASE_PATH . '/model/PDOclass.php';
    $PDOclass = new PDOclass();
    $PDOclass->SetTask($args);
    $_SESSION['success'] = "Пользователь добавлен!";
            header('location:index.php');
}
// ГЕНЕРАЦИЯ ФОРМЫ (ЗАГОЛОВОК, КЛАСС, ИМЯ ФОРМЫ)
form_generator("Новая задача", "form", "task");
?> 