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
$images_folder = BASE_PATH . '/img/profile/';
$GLOBALS['edit'] = false;
$GLOBALS['add'] = true;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ПОЛУЧЕНИЕ ДАННЫХ ИЗ ПОСТ ЗАПРОСА ФОРМЫ
    $data_to_store = array_filter($_POST);
    // ПРОВЕРКА ПЕРЕДАВАЕМЫХ ДАННЫХ
    if(mb_strlen($data_to_store['login']) < 3 || mb_strlen($data_to_store['login']) > 90){
        echo "Недопустимая длина логина!";
        exit();
    }else if(mb_strlen($data_to_store['pass']) < 8 || mb_strlen($data_to_store['pass']) > 50){
        echo "<p>Недопустимая длина пароля! Пароль должен содержать от 8 до 50 символов.</p>";
        echo "<p>Используйте для пароля цифры и символы.</p>";
        exit();
    }else{ 
        // ЕСЛИ ОТПРАВЛЕНО ФОТО
        if ($_FILES['image']['name']) {
            //Обрезка фото и загрузка на сервер
            $editor = new PhotoEditor($images_folder);
            $editor->createFoto(200);
            $saveto = $editor->getNameFoto();
            $data_to_store['photo'] = $saveto;
        }
        $data_to_store['created_at'] = date('Y-m-d H:i:s');
        $data_to_store['pass'] = md5($data_to_store['pass']);
        // ОТПРАВЛЕНИЕ ДАННЫХ
        $db = getDbInstance();
        $last_id = $db->insert('users', $data_to_store);
        // ЕСЛИ УСПЕШНО...
        if($last_id){
            $_SESSION['success'] = "Пользователь добавлен!";
            header('location:index.php');
        }else{
            echo 'Ошибка добавления: ' . $db->getLastError();
        }
        exit();
    }
}
// ГЕНЕРАЦИЯ ФОРМЫ (ЗАГОЛОВОК, КЛАСС, ИМЯ ФОРМЫ)
form_generator("Добавить пользователя", "form", "users");
?>