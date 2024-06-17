<fieldset>
    <div class="form-group">
        <label for="name">Фамилия</label>
          <input type="text" name="surname" value="<?php echo htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['users']['surname'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Фамилия" class="form-control" id = "surname" >
    </div> 
    <div class="form-group">
        <label for="name">Имя*</label>
          <input type="text" name="name" value="<?php echo htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['users']['name'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Имя" class="form-control" id = "name" >
    </div> 
    <div class="form-group">
        <label for="name">Отчество</label>
          <input type="text" name="patronymic" value="<?php echo htmlspecialchars($GLOBALS['edit'] ? $GLOBALS['users']['patronymic'] : '', ENT_QUOTES, 'UTF-8'); ?>" placeholder="Отчество" class="form-control" id = "patronymic" >
    </div>
    <div class="form-group">
        <label>Статус</label>
           <?php
            include_once(BASE_PATH . '/model/Roles.php');
            $roles = new Roles(); ?>
            <select name="user_role" class="form-control selectpicker" required>
                <?php
                foreach ($roles->setOrderingValues() as $opt_value => $opt_name ) {
                    if ($GLOBALS['edit'] && $opt_value == $GLOBALS['users']['user_role']) {
                        $sel = "selected";
                    } else {
                        $sel = "";
                    }
                    echo '<option value="'.$opt_value.'"' . $sel . '>' . $opt_name . '</option>';
                }
                ?>
            </select>
    </div> 
    <?php 
        if ($GLOBALS['add']) {
            echo ' 
            <div class="form-group">
                <label for="name">Логин*</label>
                  <input type="text" name="login" value="" placeholder="Логин" class="form-control" id = "login" >
            </div> ';
        }
    ?> 
    <div class="form-group">
        <label for="pass">Пароль*</label>
        <input type="text" name="pass" value="" placeholder="Пароль"  class="form-control" id="pass">
    </div> 
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
    <div class="form-group text-center">
        <label></label>
        <button type="submit" class="btn btn-warning" >Сохранить</button>
    </div>            
</fieldset>
