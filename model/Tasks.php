<?php
class Tasks
{

    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'title' => 'Название',
            'priority' => 'Приоритет',
            'end_date' => 'Срок',
            'status' => 'Статус',
            'dashboard' => 'Доска',
            'tags' => 'Тэги',
        ];
        return $ordering;
    }

    // public function setOrderingValues()
    // {
    //     $ordering = [
    //         'id' => 'ID',
    //         'name' => 'Название',
    //         'description' => 'Описание',
    //         'parent_task' => 'Корневая задача',
    //         'status_id' => 'Статус',
    //         'dashboard_id' => 'Доска',
    //         'file' => 'Файл',
    //     ];
    //     return $ordering;
    // }
}

class UTasks
{
    public function setOrderingValues()
    {
        $ordering = [
            'user_id' => 'Пользователь',
            'task_id' => 'Задача',
            'role_task' => 'Роль'
        ];
        return $ordering;
    }
}

class Dashboard
{
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'name' => 'Название',
            'team_id' => 'Группа'
        ];
        return $ordering;
    }
}

class Team
{
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'name' => 'Название',
            'parent_id' => 'Родительская группа'
        ];
        return $ordering;
    }
}
?>
