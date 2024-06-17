<?php
//$login = filter_var(trim($_POST['login']), FILTER_SANITIZE_EMAIL);
$db = getDbInstance();
$qery = "SELECT `task`.`id` AS id, `task`.`name` AS title, task.priority, task.end_date, `status`.`name` AS status, `dashboard`.`name` AS dashboard, GROUP_CONCAT(`tags`.`name` SEPARATOR ', ')  AS tags
        FROM `users_task` 
            JOIN task ON `users_task`.`task_id` = task.id
            JOIN status ON `status`.`id` = `task`.`status_id`
            JOIN dashboard ON `dashboard`.`team_id` = `task`.`dashboard_id`
            JOIN tags_task ON `tags_task`.`task_id` = `task`.`id`
            JOIN tags ON `tags`.`id` = `tags_task`.`tag_id`
        WHERE `user_id` = ".$_SESSION['user_id'].";";



$q = 'SELECT `task`.`id` AS id, 
CONCAT(ut2.name, " ", ut2.surname ) AS parent_task, 
`task`.`name` AS title, 
task.priority, task.end_date, 
`status`.`name` AS status, 
`dashboard`.`name` AS dashboard, 
GROUP_CONCAT(`tags`.`name` SEPARATOR ", ") AS tags 

FROM `users` 
JOIN users_task AS ut1 ON ut1.user_id = users.id AND ut1.role_task_id = 1
JOIN task ON ut1.`task_id` = task.id 
JOIN status ON `status`.`id` = `task`.`status_id` 
JOIN dashboard ON `dashboard`.`team_id` = `task`.`dashboard_id` 
JOIN tags_task ON `tags_task`.`task_id` = `task`.`id` 
JOIN tags ON `tags`.`id` = `tags_task`.`tag_id` 
LEFT JOIN `users_task` AS utask ON utask.task_id = ut1.task_id AND utask.role_task_id = 2
LEFT JOIN users AS ut2 ON ut2.id = utask.user_id 
WHERE ut1.`user_id` = 5;';
?>


<select name="filter_col" class="form-control">
                <?php
                    foreach ($status->setOrderingValues() as $opt_value => $opt_name):
                        ($row['status'] === $opt_name) ? $selected = 'selected' : $selected = '';
                        echo ' <option value="'.$opt_value.'" '.$selected.'>'.$opt_name.'</option>';
                    endforeach;
                ?>
                </select>


                <tr>
                <td><?php echo '<p>Название</p>'; ?></td>
                <td><?php echo '<p>Описание</p>'; ?></td>
                <td><?php echo '<p>Родительская задача</p>'; ?></td>
                <td><?php echo '<p>Статус</p>'; ?></td>
                <td><?php echo '<p>Приоритет</p>'; ?></td>
                <td><?php echo '<p>Прикрепленные файлы</p>'; ?></td>
                <td><?php echo '<p>Выполнить до</p>'; ?></td>
                <td><?php echo '<p>Тэги</p>'; ?></td>
                <td>
                    <a href="task.php?task_id=<?php echo $row['id']; ?>&role=2" class="btn btn-primary"><i class="glyphicon glyphicon-circle-arrow-right"></i></a>
                </td>
            </tr>
            <tr>
                <td><?php echo '<p>'.$row['title'].'</p>'; ?></td>
                <td><?php echo '<p>'.$row['description'].'</p>'; ?></td>
                <td><?php echo '<p>'.$row['parent_task'].'</p>'; ?></td>

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
                <td><?php echo '<p>'.$row['priority'].'</p>'; ?></td>
                <td><?php echo '<p>'.$row['file'].'</p>'; ?></td>
                <td><?php echo '<p>'.$row['end_date'].'</p>'; ?></td>
                <td><?php echo '<p>'.$row['dashboard'].'</p>'; ?></td>
                <td><?php echo '<p>'.$row['tags'].'</p>'; ?></td>
            </tr>