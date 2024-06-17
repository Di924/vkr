<fieldset>
    <div class="form-group">
        <label for="image">Файл <?php echo $GLOBALS['edit'] ? '(выберите чтобы отредактировать)' : '' ?></label>
        <input
            type="file"
            name="image"
            class="form-control"
            <?php echo $GLOBALS['edit'] ?'':'required="required"' ?>
            accept="image/*"
            id="image"
        />
    </div>
    <?php if( $GLOBALS['edit']){
        #$image_url = объявляется в php, к-й вызывает форму
        echo '
        <div class="form-group">
            <label for="image">Ссылка на файл <i>' . $GLOBALS['image_url'].'</i></label>
        </div>
        <img style="width:100%; max-width: 500px;object-fit: cover;margin: 10px;" src="'.$GLOBALS['img_url'].'">';
    }?>
    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning">Сохранить</button>
    </div>
</fieldset>
