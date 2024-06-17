<?php
class Users
{
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'login' => 'Логин',
            'pass' => 'Пароль',
            'name' => 'Имя',
            'surname' => 'Фамилия',
            'patronymic' => 'Отчество',
            'photo' => 'Фотография',
            'user_role' => 'Роль',
            'created_at' => 'Дата регистрации'
        ];

        return $ordering;
    }
}
?>