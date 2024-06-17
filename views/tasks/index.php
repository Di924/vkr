<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . '/www/vkr/config/config.php');

    // Users class
    require_once BASE_PATH . '/model/Tasks.php';
    require_once BASE_PATH . '/model/Status.php';
    $tasks = new Tasks();
    $status = new Status();

    // Get Input data from query string
    $search_string = filter_input(INPUT_GET, 'search_string');
    $filter_col = filter_input(INPUT_GET, 'filter_col');
    $order_by = filter_input(INPUT_GET, 'order_by');

    // Per page limit for pagination.
    $pagelimit = 20;

    // Get current page.
    $page = filter_input(INPUT_GET, 'page');
    if (!$page)
    {
        $page = 1;
    }

    // If filter types are not selected we show latest added data first
    if (!$filter_col)
    {
        $filter_col = 'id';
    }
    if (!$order_by)
    {
        $order_by = 'Desc';
    }

    //Get DB instance. i.e instance of MYSQLiDB Library
    $db = getDbInstance();
    $select = array('users_task.user_id', 'users_task.task_id', 'role_task.name', 'task.name', 'task.description', 'task.status_id', 'task.end_date', 'GROUP_CONCAT(tags.name SEPARATOR ", ")');
    $db->join('task', 'task.id = users_task.task_id', 'LEFT');
    $db->join('role_task', 'role_task.id = users_task.role_task_id', 'LEFT');
    $db->join('tags_task', 'tags_task.task_id = task.id', 'LEFT');
    $db->join('tags', 'tags.id = tags_task.tag_id', 'LEFT');
    $db->where('users_task.user_id', $_SESSION['user_id']);
    $db->groupBy('users_task.user_id, users_task.task_id');
    //Start building query according to input parameters.
    // If search string
    if ($search_string)
    {
        $db->where('name', '%' . $search_string . '%', 'like');
        $db->orwhere('content', '%' . $search_string . '%', 'like');
    }

    //If order by option selected
    if ($order_by)
    {
        $db->orderBy($filter_col, $order_by);
    }

    // Set pagination limit
    $db->pageLimit = $pagelimit;

    // Get result of the query.
    $rows = $db->arraybuilder()->paginate('task', $page, $select);
    $total_pages = $db->totalPages;

if (true) {
    
    //$qery = 'SELECT `task`.`id` AS id, 
    //CONCAT(ut2.name, " ", ut2.surname ) AS parent_task, 
    //`task`.`name` AS title, 
    //task.priority, task.end_date, 
    //`status`.`name` AS status, 
    //`dashboard`.`name` AS dashboard, 
    //GROUP_CONCAT(`tags`.`name` SEPARATOR ", ") AS tags 
    //
    //FROM `users` 
    //JOIN users_task AS ut1 ON ut1.user_id = users.id AND ut1.role_task_id = 2
    //JOIN task ON ut1.`task_id` = task.id 
    //JOIN status ON `status`.`id` = `task`.`status_id` 
    //JOIN dashboard ON `dashboard`.`team_id` = `task`.`dashboard_id` 
    //JOIN tags_task ON `tags_task`.`task_id` = `task`.`id` 
    //JOIN tags ON `tags`.`id` = `tags_task`.`tag_id` 
    //LEFT JOIN `users_task` AS utask ON utask.task_id = ut1.task_id AND utask.role_task_id = 1
    //LEFT JOIN users AS ut2 ON ut2.id = utask.user_id 
    //WHERE ut1.user_id = '.$_SESSION["user_id"].';';
    //    // $exec = queryUnprepared($qery);
    //$qqeerryy = '
    //START TRANSACTION
    //--написать транзакцию из нескольких запросов, возвращающую по id пользователя 
    //--список задач:
    //--ид, название, моя роль, создатель, исполнитель, наблюдатель,приоритет, дата окончания, статус, дашборд, теги.
    //
    //SELECT `task`.`id` AS id, 
    //CONCAT(ut2.name, " ", ut2.surname ) AS parent_task, 
    //`task`.`name` AS title, 
    //task.priority, 
    //task.end_date, 
    //`status`.`name` AS status, 
    //`dashboard`.`name` AS dashboard, 
    //GROUP_CONCAT(`tags`.`name` SEPARATOR ", ") AS tags 
    //
    //FROM `users` 
    //JOIN users_task AS ut1 ON ut1.user_id = users.id
    //JOIN task ON ut1.`task_id` = task.id 
    //JOIN status ON `status`.`id` = `task`.`status_id` 
    //LEFT JOIN dashboard ON `dashboard`.`id` = `task`.`dashboard_id` 
    //LEFT JOIN tags_task ON `tags_task`.`task_id` = `task`.`id` 
    //LEFT JOIN tags ON `tags`.`id` = `tags_task`.`tag_id` 
    //
    //ALL JOIN users_task AS ut2 ON ut1.task_id = ut1.task_id
    //LEFT JOIN users AS ut2 ON u2.id = utask.user_id 
    //WHERE `users`.user_id = 5 AND users_task.role_task_id = 2;
    //
    //COMMIT;
    //';
    //try {
    //    // подключаемся к серверу
    //    $conn = new PDO("mysql:host=localhost;dbname=register", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    //}
    //catch (PDOException $e) {
    //    echo "Connection failed: " . $e->getMessage();
    //}    
    //$rows = $conn->query($qery);
    # code...
}
    include_once(BASE_PATH . '/includes/header.php');
    include_once(BASE_PATH . '/includes/addmenu.php');
?>


<div  class="container bg-light-50">
<!-- Main container -->
<div id="page-wrapper">
    <div class="row">
        <table class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th width="10%">Список</th>
                    <th width="10%">Сроки</th>
                    <th width="10%">Календарь</th>
                    <th width="10%">Гант</th>
                    <th width="60%">
                    </th>
                </tr>
                </thead>
        </table>
        <table class="table table-striped table-condensed">
            <thead>
                <tr>
                    <th width="20%"><h4>Мои задачи  </h4></th>
                    <th class="t-second-menu" width="15%"><h4>Проект      </h4></th>
                    <th class="t-second-menu" width="15%"><h4>Скрам       </h4></th>
                    <th class="t-second-menu" width="30%">
                        <form class="form form-inline" action="">
                            <label for="input_search">Поиск</label>
                            <input type="text" class="form-control" id="input_search" name="search_string" value="<?php echo htmlspecialchars(($search_string ? $search_string : ""), ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="submit" value="Искать" class="btn btn-primary">
                        </form>
                    </th>
                    <th width="10%">
                        <div class="page-action-links">
                            <a href="#" class="btn btn-success"> Настройки</a>
                        </div>
                    </th>
                    <th width="10%">
                        <div class="page-action-links">
                            <a href="add.php?operation=create" class="btn btn-success">Добавить</a>
                        </div>
                    </th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Table -->
    <table class="table  table-hover table-condensed">
        <thead>
            <tr>
                <th width="15%">Название</th>
                <th width="10%">Приоритет</th>
                <th width="10%">Срок</th>
                <th width="5%">Статус</th>
                <th width="15%">Проект</th>
                <th width="15%">Руководитель</th>
                <th width="20%">Теги</th>
                <th width="10%"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
                
            <tr>
                <td><?php echo '<p>'.$row['title'].'</p>'; ?></td>
                <td><?php echo '<p>'.$row['priority'].'</p>'; ?></td>
                <td><?php echo '<p>'.$row['end_date'].'</p>'; ?></td>
                <td><?php echo '<p>'.$row['status'].'</p>'; ?></td>
                <td><?php echo '<p>'.$row['dashboard'].'</p>'; ?></td>
                <td><?php echo '<p>'.$row['parent_task'].'</p>'; ?></td>
                <td><?php echo '<p>'.$row['tags'].'</p>'; ?></td>
                <td>
                    <a href="task.php?task_id=<?php echo $row['id']; ?>&role=2" class="btn btn-primary"><i class="glyphicon glyphicon-circle-arrow-right"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- //Table -->
<?php include BASE_PATH.'/includes/footer.php';  ?>