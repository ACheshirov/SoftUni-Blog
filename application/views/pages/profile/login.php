<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="panel">
    <h3>Вход</h3>

    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?=$error?></div>
    <?php endif; ?>

    <?=form_open()?>
    <div class="form-group">
        <label for="form_username" class="required">Потребителско име</label>
        <input type="text" id="form_username" name="username" required="required" class="form-control" placeholder="Потребителско име" value="<?=set_value("username")?>" />
    </div>

    <div class="form-group">
        <label for="form_password">Парола</label>
        <input type="password" id="form_password" name="password" required="required" class="form-control" placeholder="Парола" />
    </div>

    <div><button type="submit" name="login" class="btn btn-primary">Влез</button></div>
    <?=form_close()?>
</section>
