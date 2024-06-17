<fieldset>
    <div class="form-group">
        <label for="name">Заголовок</label>
        <textarea name="name" class="form-control" id="name"><?php echo htmlspecialchars(($GLOBALS['edit']) ? $GLOBALS['contacts']['name'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div> 

    <div class="form-group">
        <label for="text">Текст</label>
        <textarea name="text" class="form-control" id="text"><?php echo htmlspecialchars(($GLOBALS['edit']) ? $GLOBALS['contacts']['text'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div> 

    <div class="form-group">
        <label for="image">Фотография</label>
          <input type="text" name="image" value="<?php echo htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['contacts']['image'] : '', ENT_QUOTES, 'UTF-8'); ?>" class="form-control" id="image" >
    </div> 

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Сохранить <span class="glyphicon glyphicon-send"></span></button>
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
        .create( document.querySelector( '#text' ) )
        .catch( error => {
            console.error( error );
        } );
</script>