<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/www/vkr/config/config.php');
include_once(BASE_PATH . '/includes/header.php');
// проверка
if($_SESSION['user_role']!='2'){
    $_SESSION['failure'] = "У вас не хватает прав для совершения этого действия";
    header('location: index.php');
    exit;
}
// РЕДАКТОР ФОТО
require_once BASE_PATH . '/model/PhotoEditor.php';
// ПЕРЕМЕННЫЕ
$news_id = filter_input(INPUT_GET, 'news_id', FILTER_VALIDATE_INT);
$images_folder = BASE_PATH . '/img/news/';
$GLOBALS['edit'] = true;
$GLOBALS['add'] = false;

// ПОЛУЧЕНИЕ ИМЕЮЩИХСЯ ДАННЫХ
$db = getDbInstance();
$db->where('id', $news_id);
$GLOBALS['news'] = $db->getOne("news");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ПОЛУЧЕНИЕ ДАННЫХ ИЗ ПОСТ ЗАПРОСА ФОРМЫ
    $data_to_update = filter_input_array(INPUT_POST);
    // ЕСЛИ ОТПРАВЛЕНО ФОТО
    if ($_FILES['image']['name']) {
        //Обрезка фото и загрузка на сервер
        $editor = new PhotoEditor($images_folder);
        $editor->createFoto(200);
        $saveto = $editor->getNameFoto();
        $data_to_update['image'] = $saveto;
    }
    // ОТПРАВЛЕНИЕ ДАННЫХ
    $db = getDbInstance();
    $db->where('id',$news_id);
    $stat = $db->update('news', $data_to_update);
    // ЕСЛИ УСПЕШНО...
    if($stat) {
        $_SESSION['success'] = "Успешно обновлено!";
        //Redirect to the listing page,
        header('location: index.php');
        exit();
    }
}
// ГЕНЕРАЦИЯ ФОРМЫ (ЗАГОЛОВОК, КЛАСС, ИМЯ ФОРМЫ)
form_generator("Обновить новость", "", "news");?>
 <?php include BASE_PATH.'/includes/footer.php'; ?>