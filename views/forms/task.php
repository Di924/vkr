<fieldset> 
    <div class="form-group">
        <label for="name">Название задачи</label>
        <textarea name="name" id="name" placeholder="Название задачи" class="form-control" required="required"></textarea>
    </div> 
    <div class="form-group">
        <label for="description">Описание задачи</label>
        <textarea name="description" id="description" placeholder="note" class="form-control" required="required"></textarea>
    </div> 

    <div class="form-group">
        <label for="status_id">Статус</label>
        <input type="text" name="status_id" class="form-control" id="status_id" required="required">
    </div> 

    <div class="form-group">
        <label for="priority">Приоритет</label>
        <input type="number" plaseholder="0-100" name="priority" class="form-control" id="priority" required="required">
    </div> 

<div class="form-group">
    <label for="end_date">Выполнить до</label>
    <input type="date" name="end_date" class="form-control" id="end_date" required="required">
</div> 

<div class="form-group">
    <label for="dashboard_id">Проект</label>
    <input type="text" name="dashboard_id" class="form-control" id="dashboard_id" required="required">
</div> 

<div class="form-group">
    <label for="user_id">Исполнитель</label>
    <input type="text" name="user_id" class="form-control" id="user_id" required="required">
</div> 
<div class="form-group">
    <label for="nuser_id">Наблюдатель</label>
    <input type="text" name="nuser_id" class="form-control" id="nuser_id" required="required">
</div> 
<div class="form-group">
    <label for="tag_id">Теги</label><!-- только строчные буквы -->
    <textarea name="tag_id" class="form-control" id="tag_id"></textarea>
</div> 
    <div class="form-group">
        <label for="file">Файл <?php echo $GLOBALS['edit'] ? '(выберите чтобы отредактировать)' : '' ?></label>
        <input
            type="file"
            name="file"
            class="form-control"
            accept="image/*"
            id="file"
        />
    </div>
     
    <div class="form-group">
        <label for="preparation">Родительская задача</label>
        <textarea name="parent_task" class="form-control" id="preparation"></textarea>
    </div> 

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Сохранить</button>
    </div>            
</fieldset> 

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#name' ) )
        .catch( error => {
            console.error( error );
        } );
    ClassicEditor
    .create( document.querySelector( '#description' ) )
    .catch( error => {
        console.error( error );
    } );
</script>
