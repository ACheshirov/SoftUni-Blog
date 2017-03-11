<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="panel">
    <h3>Регистрация</h3>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?=$error?></div>
    <?php endif; ?>

    <?=form_open()?>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-user"></i></div>
            <input type="text" id="form_username" name="username" required="required" class="form-control" placeholder="Потребителско име" value="<?=set_value("username")?>" />
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-lock"></i></div>
            <input type="password" id="form_password" name="password" required="required" class="form-control" placeholder="Парола" />
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-lock"></i></div>
            <input type="password" id="form_password2" name="password2" required="required" class="form-control" placeholder="Потвърди паролата" />
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
            <input type="email" id="form_email" name="email" required="required" class="form-control" placeholder="E-mail адрес" value="<?=set_value("email")?>" />
        </div>
    </div>

    <div><button type="submit" name="register" class="btn btn-primary">Регистрация</button></div>
    <?=form_close()?>
</section>
