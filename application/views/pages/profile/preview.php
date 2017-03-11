<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="panel">
    <h3>Профил на <?=$username?></h3>

    <div class="row">
        <div class="col-xs-3">Ранк:</div>
        <div class="col-xs-9"><?=$admin ? 'Администратор' : 'Потребител'?></div>
    </div>

    <div class="row">
        <div class="col-xs-3">Коментари:</div>
        <div class="col-xs-9"><?=$comments?></div>
    </div>

    <?php if ($showEditButton || $_isAdmin) : ?>
        <div class="row">
            <div class="col-xs-3">E-mail:</div>
            <div class="col-xs-9"><?=$email?></div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <a href="<?=site_url("profile/edit")?>" class="btn btn-default">Редактирай профила</a>
            </div>
        </div>
    <?php endif; ?>
</section>
