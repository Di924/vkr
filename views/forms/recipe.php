<fieldset>
    <div class="form-group">
        <label for="name">Заголовок</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['recipes']['name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Title" class="form-control" id = "name" >
    </div> 

    <div class="form-group">
        <label for="ingredients">Ингридиенты</label>
        <textarea name="ingredients" class="form-control" id="ingredients"><?php echo htmlspecialchars(($GLOBALS['edit']) ? $GLOBALS['recipes']['ingredients'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div> 

    <div class="form-group">
        <label for="note">Заметка</label>
        <textarea name="note" placeholder="note" class="form-control" id="note"><?php echo htmlspecialchars(($GLOBALS['edit']) ? $GLOBALS['recipes']['note'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div> 

    <div class="form-group">
        <label for="image">Фотография</label>
        <input type="text" name="image" value="<?php echo htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['recipes']['image'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="image" class="form-control" id="image">
    </div> 
    
    <div class="form-group">
        <label for="preparation">Описание</label>
        <textarea name="preparation" class="form-control" id="preparation"><?php echo htmlspecialchars(($GLOBALS['edit']) ? $GLOBALS['recipes']['preparation'] : '', ENT_QUOTES, 'UTF-8'); ?></textarea>
    </div> 

    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Сохранить</button>
    </div>            
</fieldset>

<script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create( document.querySelector( '#ingredients' ) )
        .catch( error => {
            console.error( error );
        } );
    ClassicEditor
    .create( document.querySelector( '#preparation' ) )
    .catch( error => {
        console.error( error );
    } );
</script>
