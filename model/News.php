<?php
class News
{
    public function setOrderingValues()
    {
        $ordering = [
            'id' => 'ID',
            'name' => 'Название',
            'slug' => 'Slug',
            'content' => 'Контент',
            'image' => 'Фотография',
            'created_at' => 'Дата создания'
        ];

        return $ordering;
    }
}
?>
