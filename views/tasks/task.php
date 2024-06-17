<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . '/www/vkr/config/config.php');

    // Users class
    require_once BASE_PATH . '/model/Tasks.php';
    require_once BASE_PATH . '/model/Status.php';
    $tasks = new Tasks();
    $status = new Status();

    // Get Input data from query string
    $task_id = filter_input(INPUT_GET, 'task_id');
    $role = filter_input(INPUT_GET, 'role');


$qery = 'SELECT task.`id`, task.`name` AS title, task.`description`, task.`parent_task`, 
status.name AS status, 
task.`priority`, 
dashboard.name AS dashboard, 
task.`file` AS answer_file, task.`end_date`,
GROUP_CONCAT(`tags`.`name` SEPARATOR ", ") AS tags,
GROUP_CONCAT(`user_files`.`filename` SEPARATOR ", ") AS file  
FROM `task` 
JOIN status on status.id = task.status_id
JOIN dashboard ON dashboard.id = task.dashboard_id
LEFT JOIN tags_task ON tags_task.task_id = task.id
LEFT JOIN tags ON tags.id = tags_task.tag_id
LEFT JOIN user_files ON user_files.task_id = task.id
WHERE `task`.`id` = '.$task_id.';';


    try {
        // подключаемся к серверу
        $conn = new PDO("mysql:host=localhost;dbname=register", "root", "", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
    }
    catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }    
    $rows = $conn->query($qery);

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
                    <th width="15%"><h4>Проект      </h4></th>
                    <th width="15%"><h4>Скрам       </h4></th>
                    <th width="30%">
                        
                    </th>
                    <th width="10%">
                        
                    </th>
                    <th width="10%">
                        <div class="page-action-links">
                            <a href="add.php?operation=create" class="btn btn-success">Начать работу</a>
                        </div>
                    </th>
                </tr>
            </thead>
        </table>
    </div>

    <!-- Table -->
    <table class="table  table-condensed">
        <thead>
            <tr>
                <th width="15%"></th>
                <th width="85%"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
                
            <tr>
                <td><?php echo '<p>Название</p>'; ?></td>
                <td><?php echo '<p>'.$row['title'].'</p>'; ?></td>
            </tr>
            <tr>
                <td><?php echo '<p>Описание</p>'; ?></td>
                <td><?php echo '<p>'.$row['description'].'</p>'; ?></td>
            </tr>
            <tr>
                <td><?php echo '<p>Родительская задача</p>'; ?></td>
                <td><?php echo '<p>'.$row['parent_task'].'</p>'; ?></td>
            </tr>
            <tr>
                <td><?php echo '<p>Статус</p>'; ?></td>
                <td>
                    <select name="filter_col" class="form-control">
                    <?php
                        foreach ($status->setOrderingValues() as $opt_value => $opt_name):
                            ($row['status'] === $opt_name) ? $selected = 'selected' : $selected = '';
                            echo ' <option value="'.$opt_value.'" '.$selected.'>'.$opt_name.'</option>';
                        endforeach;
                    ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td><?php echo '<p>Приоритет</p>'; ?></td>
                <td><?php echo '<p>'.$row['priority'].'</p>'; ?></td>
            </tr>
            <tr>
                <td><?php echo '<p>Выполнить до</p>'; ?></td>
                <td><?php echo '<p>'.$row['end_date'].'</p>'; ?></td>
            </tr>
            <tr>
                <td><?php echo '<p>Проект</p>'; ?></td>
                <td><?php echo '<p>'.$row['dashboard'].'</p>'; ?></td>
            </tr>
            <tr>
                <td><?php echo '<p>Тэги</p>'; ?></td>
                <td><?php echo '<p>'.$row['tags'].'</p>'; ?></td>
            </tr>
            <tr>
                <td><?php echo '<p>Прикрепленные файлы</p>'; ?></td>
                <td><?php echo '<p>'.$row['file'].'</p>'; ?></td>
            </tr>
            <tr>
                <td><?php echo '<p>Отчет</p>'; ?></td>
                <td><?php echo '<p>'.$row['answer_file'].'</p>'; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- //Table -->
<?php include BASE_PATH.'/includes/footer.php';  ?>