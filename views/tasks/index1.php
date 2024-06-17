<?php
    session_start();
    require_once($_SERVER['DOCUMENT_ROOT'] . '/www/vkr/config/config.php');

    // Users class
    require_once BASE_PATH . '/model/News.php';
    $news = new News();

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
    $select = array('id', 'name', 'slug', 'content', 'image', 'created_at');
//$select = array('task.id', 'task.name AS title', 'task.priority', 'task.end_date', 'status.name');
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
    $rows = $db->arraybuilder()->paginate('news', $page, $select);
    $total_pages = $db->totalPages;

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
                <th width="25%">Название</th>
                <th width="15%">Приоритет</th>
                <th width="15%">Срок</th>
                <th width="15%">Постановщик</th>
                <th width="15%">Проект</th>
                <th width="15%">Теги</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
                
            <tr>
                <td><?php echo '<p>'.$row['name'].'</p><p>'.$row['content'].'</p>'; ?></td>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['id']; ?></td>
                <td>
                    <?php 
                    if ($row['image']) {
                        $image_url = '../img/news/'.$row['image'];
                        echo '<img style="width:100%; object-fit: cover;" class="rounded" src="'. $image_url .'">';
                    }else {
                        echo 'отсутствует';
                    }
                    ?>
                    
                </td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
                <td>
                    <a href="edit.php?news_id=<?php echo $row['id']; ?>&operation=edit&news_foto=<?php echo $row['image']; ?>" class="btn btn-primary"><i class="glyphicon glyphicon-edit"></i></a>
                    <a href="delete.php?del_id=<?php echo $row['id']; ?>&news_name=<?php echo $row['name']; ?>" class="btn btn-danger delete_btn"><i class="glyphicon glyphicon-trash"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <!-- //Table -->

    <!-- Pagination -->
    <div class="text-center">
        <?php
        if (!empty($_GET)) {
            // We must unset $_GET[page] if previously built by http_build_query function
            unset($_GET['page']);
            // To keep the query sting parameters intact while navigating to next/prev page,
            $http_query = "?" . http_build_query($_GET);
        } else {
            $http_query = "?";
        }
        // Show pagination links
        if ($total_pages > 1) {
            echo '<ul class="pagination text-center">';
            for ($i = 1; $i <= $total_pages; $i++) {
                ($page == $i) ? $li_class = ' class="active"' : $li_class = '';
                echo '<li' . $li_class . '><a href="index.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul>';
        }
        ?>
    </div>
    <!-- //Pagination -->
</div>
<!-- //Main container -->
</div>
<?php include BASE_PATH.'/includes/footer.php'; ?>
   