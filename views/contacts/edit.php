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
$profile_id = filter_input(INPUT_GET, 'profile_id', FILTER_VALIDATE_INT);
$images_folder = BASE_PATH . '/img/profile/';
$GLOBALS['edit'] = true;
$GLOBALS['add'] = false;

// ПОЛУЧЕНИЕ ИМЕЮЩИХСЯ ДАННЫХ
$db = getDbInstance();
$db->where('id', $profile_id);
$GLOBALS['users'] = $db->getOne("users");

//Handle update request. As the form's action attribute is set to the same script, but 'POST' method, 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // ПОЛУЧЕНИЕ ДАННЫХ ИЗ ЗАПРОСА В МАССИВ
    $data_to_update = filter_input_array(INPUT_POST);
    // ЕСЛИ ОТПРАВЛЕНО ФОТО
    if ($_FILES['image']['name']) {
        //Обрезка фото и загрузка на сервер
        $editor = new PhotoEditor($images_folder);
        $editor->createFoto(200);
        $saveto = $editor->getNameFoto();
        $data_to_update['photo'] = $saveto;
    }
    // УСТАНОВЛЕНИЕ ВРЕМЕНИ ОБНОВЛЕНИЯ
    $data_to_update['updated_at'] = date('Y-m-d H:i:s');
    // ПРОВЕРКА ПАРОЛЯ
    if ($data_to_update['pass']) {
        $data_to_update['pass'] = md5($data_to_update['pass']);
    }else {
        $data_to_update['pass'] = $GLOBALS['users']['pass'];
    }
     // ОТПРАВЛЕНИЕ ДАННЫХ
    $db = getDbInstance();
    $db->where('id',$profile_id);
    $stat = $db->update('users', $data_to_update);
    // ЕСЛИ УСПЕШНО...
    if($stat)
    {
        $_SESSION['success'] = "Данные пользователя изменены!";
        //Redirect to the listing page,
        header('location: index.php');
        //Important! Don't execute the rest put the exit/die. 
        exit();
    }
}
// ГЕНЕРАЦИЯ ФОРМЫ (ЗАГОЛОВОК, КЛАСС, ИМЯ ФОРМЫ)
form_generator("Изменить данные пользователя", "", "users");
?>
