<?php

class PDOclass{
    // объявление свойства
    public $conn;
    public $rows;
    public $target;
    public $images_folder;
    public $saveto;
    public $w_src; // ширина
    public $h_src; // высота
    public $w = 200; // по умолчанию сжимает до 200х200
    public $dest;
    public $type;
    public $im;
    public $date;

    // объявление метода
    public function __construct(){
        try {
            // подключаемся к серверу
            $this->conn = new PDO("mysql:host=localhost;dbname=register", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        }
        catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        } 
        return $this->conn;
    }
    public function GetListDashboard(){
        if (isset($_SESSION['user_id'])) {            
            $qery = 'SELECT 
                team.id,
                team.name
                FROM users
                LEFT JOIN team_role ON team_role.user_id = users.id
                LEFT JOIN team ON team.id = team_role.team_id
                WHERE users.id = ' . $_SESSION['user_id'];
            $rows = $this->conn->query($qery);
            return $rows;
        }else {
            return false;
        }
    }
    public function GetListTask() {
        $qery = 'SELECT `task`.`id` AS id, 
            CONCAT(ut2.name, " ", ut2.surname ) AS parent_task, 
            `task`.`name` AS title, 
            task.priority, task.end_date, 
            `status`.`name` AS status, 
            `dashboard`.`name` AS dashboard, 
            GROUP_CONCAT(`tags`.`name` SEPARATOR ", ") AS tags 

            FROM `users` 
            JOIN users_task AS ut1 ON ut1.user_id = users.id AND ut1.role_task_id = 2
            JOIN task ON ut1.`task_id` = task.id 
            JOIN status ON `status`.`id` = `task`.`status_id` 
            JOIN dashboard ON `dashboard`.`team_id` = `task`.`dashboard_id` 
            JOIN tags_task ON `tags_task`.`task_id` = `task`.`id` 
            JOIN tags ON `tags`.`id` = `tags_task`.`tag_id` 
            LEFT JOIN `users_task` AS utask ON utask.task_id = ut1.task_id AND utask.role_task_id = 1
            LEFT JOIN users AS ut2 ON ut2.id = utask.user_id 
            WHERE ut1.`user_id` = '.$_SESSION["user_id"].';';
        $rows = $this->conn->query($qery);
        return $rows;
    }
    public function SetTask($args) {
        try {
            
        //print_r($args);
        //ВНЕСЕНИЕ ДАННЫХ В ОСНОВНУЮ ТАБЛИЦУ
        $qery = 'INSERT INTO `task`
        (`name`, `description`, `status_id`, `priority`, `dashboard_id`, `end_date`) 
        VALUES ("'.
                    $args['name']         
        .'", "' .  $args['description']  
        .'", ' .  ($args['status_id']       ? $args['status_id'] : null)
        .', ' .   ($args['priority']        ? $args['priority'] : null)
        .', ' .   ($args['dashboard_id']    ? $args['dashboard_id'] : null)
        .', ' .   ($args['end_date']        ? $args['end_date'] : null)
        .');';
        $rez = $this->conn->query($qery);
        // var_dump($rez);
        // ID задачи
        $qery = "SELECT `id` FROM `task` WHERE `name` = :name;";
        $prep = $this->conn->prepare($qery);
        $prep->execute([':name' => $args['name']]);

        $id = $prep->fetchAll();
        $id = (string)$id[0]["id"];
        // $id = $this->conn->query($qery);

        //ВНЕСЕНИЕ ДАННЫХ В СВЯЗАННЫЕ ТАБЛИЦЫ
        //$data_to_file = $args['file'];
        // ЕСЛИ ОТПРАВЛЕН
        if ($_FILES['file']['name']) {
            require_once BASE_PATH . '/classes/PhotoEditor.php';
            $images_folder = BASE_PATH . '/img/profile/';
            //Обрезка фото и загрузка на сервер
            $editor = new PhotoEditor($images_folder);
            $editor->createFoto(1000);
            $saveto = $editor->getNameFoto();
            $data_to_file['file_name'] = $saveto;
        }
        
        if (isset($args['tag_id']) && is_array($args['tag_id'])) {
            foreach ($args['tag_id'] as $key => $value) {
                #формируем запросы на подключение тегов к задаче
                $qery = 'INSERT INTO `tags_task`(`task_id`, `tag_id`) VALUES (' . $id . ', ' . $value .');';
                $rez = $this->conn->query($qery);
            }
        } 

        //$args['user_id'];
        // создатель, исполнители и наблюдатели
        $qery = 'INSERT INTO `users_task`(`user_id`, `task_id`, `role_task_id`) VALUES ('. (string)$_SESSION["user_id"] . ', ' . (string)$id . ', 1);';
        $rez = $this->conn->query($qery);
        if (is_array($args['user_id'])) {
            foreach ($args['user_id'] as $key => $value) {
                $qery = 'INSERT INTO `users_task`(`user_id`, `task_id`, `role_task_id`) VALUES ('. $value . ', ' . $id . ', 2);';
                $rez = $this->conn->query($qery);
            }
        }else {
            $qery = 'INSERT INTO `users_task`(`user_id`, `task_id`, `role_task_id`) VALUES ('. $args['user_id'] . ', ' . $id . ', 2);';
            $rez = $this->conn->query($qery);
        }
        
        if (is_array($args['nuser_id'])) {
            foreach ($args['nuser_id'] as $key => $value) {
                $qery = 'INSERT INTO `users_task`(`user_id`, `task_id`, `role_task_id`) VALUES ('. $value . ', ' . $id . ', 3);';
                $rez = $this->conn->query($qery);
            }
        }else {
            $qery = 'INSERT INTO `users_task`(`user_id`, `task_id`, `role_task_id`) VALUES ('. $args['nuser_id'] . ', ' . $id . ', 3);';
            $rez = $this->conn->query($qery);
        }
        
        // $rez = $this->conn->query($qery);//code...
        } catch (PDOException $e) {
            return false;
        }
        return true;
    }
}
?>