<?php
class Status
{
    public function setOrderingValues()
    {
        $ordering = [
            '1' => 'Создана',
            '2' => 'Назначена',
            '3' => 'В работе',
            '4' => 'В ожидании',
            '5' => 'На тестировании',
            '6' => 'На согласовании',
            '7' => 'Выполнена',
            '8' => 'Закрыта'
        ];
        return $ordering;
    }
}