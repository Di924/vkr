<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/www/vkr/config/config.php');
include_once(BASE_PATH . '/includes/header.php');
include_once(BASE_PATH . '/includes/addmenu.php');
include_once(BASE_PATH . '/model/Roles.php');

//Get DB instance.
$db = getDbInstance();
$db->where("login", $_SESSION['login']);
$row = $db->get('users');
$image_url = '/www/vkr/img/profile/'.$row[0]['photo'];
$roles = new Roles();
?>
<!-- Main container -->
<div  class="container bg-light-50">
    <!--здесь подключаются страницы-->
    <div id="page-wrapper">
            <?php require_once(BASE_PATH . '/includes/flash_messages.php'); ?>
            <div class="row">
                <div class="col-sm-3">
                    <!-- Фото профиля -->
                    <img style="width:100%; object-fit: cover;" class="rounded-circle" src="<?= $image_url ?>">
                </div>
                <div class="col col-sm-9">
                    <!-- Информация -->
                    <div class="row">
                        <div class="col-sm-8 text-center">
                            <h2><?php echo $row[0]['surname'].' '.$row[0]['name'].' '.$row[0]['patronymic'] ?></h2>
                            
                        </div>
                        <div class="col-sm-1 text-center">
                            <a href="edit.php?profile_id=<?php echo $row[0]['id']; ?>&role=<?php echo $row[0]['user_role']; ?>&profile_foto=<?php echo $image_url; ?>" class="btn btn-primary">Редактировать профиль</a>
                            <button class="btn btn-primary button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Информация</button>
                        </div>
                    </div>
                    <div class="row">
                    <div class="collapse" id="collapseExample">
                        <p><?php echo 'Почта: '.$row[0]['login'] ?></p>
                        <p>
                            <?php 
                                foreach ($roles->setOrderingValues() as $opt_value => $opt_name):
                                    if ($row[0]['user_role'] == $opt_value) {
                                        echo 'Роль: '.$opt_name;
                                    }
                                endforeach;
                            ?>
                        </p>
                        <p><?php echo 'Дата регистрации: '.$row[0]['created_at'] ?></p>
                        <p><?PHP if(in_array('gd',get_loaded_extensions())) {echo 'Да, GD модуль пашет!!'; } else { echo 'Увы.. Нет поддержки GD.'; }?></p>
                    </div>
                        
                    </div>
                </div>
            </div>
        <!--/page-wrapper -->
    </div>
    <!-- //Main container -->
</div>
 <?php include BASE_PATH.'/includes/footer.php'; ?>