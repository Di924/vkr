<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/www/vkr/config/config.php');
require_once(BASE_PATH . '/includes/header.php');
// проверка
if($_SESSION['user_role']!='2'){
    $_SESSION['failure'] = "У вас не хватает прав для совершения этого действия";
    header('location: index.php');
    exit;
}
$del_id = filter_input(INPUT_GET, 'del_id', FILTER_VALIDATE_INT);
$user_name = filter_input(INPUT_GET, 'user_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $db = getDbInstance();
    $db->where('id', $del_id);
    $status = $db->delete('users');
    
    if ($status) 
    {
        $_SESSION['info'] = "Пользователь удален успешно!";
        header('location: index.php');
        exit;
    }
    else
    {
    	$_SESSION['failure'] = "Ошибка удаления";
    	header('location: index.php');
        exit;
    }
}
?>
<form action="" method="POST">
    <!-- content -->
    <div  class="container bg-light-50">
        <div class="">
            <input type="hidden" name="del_id" id="del_id" value="<?php echo $del_id; ?>">
            <p>Пользователь "<?php echo $user_name; ?>"</p>
            <p>Будет удален. Продолжить?</p>
        </div>
        <div class="">
            <button type="submit" class="btn btn-success pull-left">Да</button>
            <a href="index.php" class="btn btn-danger">Нет</a>
        </div>
    </div>
</form>
