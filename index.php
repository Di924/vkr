<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'] . '/www/vkr/config/config.php');
include_once(BASE_PATH . '/includes/header.php');
include_once(BASE_PATH . '/includes/addmenu.php');
?>

<div class="container bg-light-50">
    <!--здесь подключаются страницы-->
    <div id="page-wrapper">
        <?php include_once('views/pages/info.php'); ?>
    </div>
    <!--/#page-wrapper -->
</div>
<!--/container -->
<?php include BASE_PATH.'/includes/footer.php'; ?>