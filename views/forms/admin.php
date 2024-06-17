<fieldset>
    <!-- Form Name -->
    <legend>Add new admin user</legend>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label">User name</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                <input  type="text" name="user_name" autocomplete="off" placeholder="user name" class="form-control" value="<?php echo ($GLOBALS['edit']) ? $GLOBALS['admin_account']['user_name'] : ''; ?>" autocomplete="off">
            </div>
        </div>
    </div>
    <!-- Text input-->
    <div class="form-group">
        <label class="col-md-4 control-label" >Password</label>
        <div class="col-md-4 inputGroupContainer">
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" name="password" autocomplete="off" placeholder="Password " class="form-control" autocomplete="off">
            </div>
        </div>
    </div>
    <!-- radio checks -->
    <div class="form-group">
        <label class="col-md-4 control-label">User type</label>
        <div class="col-md-4">
            <div class="radio">
                <label>
                    <?php //echo $GLOBALS['admin_account']['admin_type'] ?>
                    <input type="radio" name="admin_type" value="super" <?php echo ($GLOBALS['edit'] && $GLOBALS['admin_account']['admin_type'] =='super') ? "checked": "" ; ?>/> Super admin
                </label>
            </div>
            <div class="radio">
                <label>
                    <input type="radio" name="admin_type" value="admin" <?php echo ($GLOBALS['edit'] && $GLOBALS['admin_account']['admin_type'] =='admin') ? "checked": "" ; ?>/> Admin
                </label>
            </div>
        </div>
    </div>
    <!-- Button -->
    <div class="form-group">
        <label class="col-md-4 control-label"></label>
        <div class="col-md-4">
            <button type="submit" class="btn btn-warning" >Сохранить</span></button>
        </div>
    </div>
</fieldset>