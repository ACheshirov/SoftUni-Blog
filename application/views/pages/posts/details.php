<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="panel">
    <h3><?=$post['title']?></h3>
    <p><?=nl2br($post['description'])?></p>
    <i class="fa fa-comments-o"></i> <i><?=$post['comments']?> коментара</i>
</section>

<section class="panel">
    <h4>Коментари:</h4>

    <?php
    if (isset($commentResult) && $commentResult !== null) : ?>
        <div class="alert alert-danger"><?=$commentResult?></div>
    <?php endif; ?>

    <?=form_open()?>
    <?php if (!$_isLogged) : ?>
    <div class="form-group">
        <label for="form_author" class="required">Автор</label>
        <input type="text" id="form_author" name="author" required="required" class="form-control" placeholder="Автор" value="<?=set_value("author")?>" />
    </div>

    <div class="form-group">
        <label for="form_email">E-mail адрес</label>
        <input type="email" id="form_email" name="email" class="form-control" placeholder="E-mail адрес" value="<?=set_value("email")?>" />
    </div>
    <?php endif; ?>
    <div class="form-group">
        <label for="form_description" class="required">Съобщение</label>
        <textarea id="form_description" name="description" required="required" rows="5" class="form-control" placeholder="Съобщение"><?=set_value("description")?></textarea>
    </div>
    <div><button type="submit" id="form_save" name="post" class="btn btn-primary">Публикувай коментар</button></div>
    <?=form_close()?>
    <hr />
    <?php foreach ($comments as $comment) : ?>
    <div class="comment">
        <i class="fa fa-user-o"></i> <span class="author"><?=htmlspecialchars($comment['author'])?></span>
        <span class="options"><?=(!$comment['approved'] && $_isAdmin) ? '[<a href="?approveComment='.$comment['id'].'&token='.$_token.'">Одобри</a>] ' : ''?><?=($_isAdmin) ? '[<a href="?delComment='.$comment['id'].'&token='.$_token.'" onclick="return confirm(\'Сигурни ли сте?\')">Изтрий</a>]' : ''?></span>
        <p><?=nl2br(htmlspecialchars($comment['description']));?></p>
        &nbsp;<span class="date"><i class="fa fa-clock-o"></i> <?=date('H:i d.m.Y', strtotime($comment['dateCreate']))?></span>
    </div>
    <?php endforeach; ?>
</section>
