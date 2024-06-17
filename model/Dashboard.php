<?php
class Dashboard
{
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'name' => 'Название',
            'team_id' => 'Команда'
        ];

        return $ordering;
    }
}
?>