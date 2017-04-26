<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="panel" id="content" data-post-id="<?=$post['id']?>">
    <?=($_isAdmin) ? '<span id="editPost"><a href="javascript:void(null)"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a></span>' : ''?>
    <h3><?=$post['title']?></h3>

    <div class="hidden" id="categoriesAll"><?=implode("\t\t", array_map(function($cat) {
        return $cat['id']."\t".$cat['name'];
    }, $categories)); ?></div>

    <p id="category"><i class="fa fa-folder-open"></i> <a href="<?=site_url("category/".$post['categoryName'])."-".$post['category']?>"><?=$post['categoryName']?></a></p>

    <div id="description">
        <?=$post['description']?>
    </div>

    <div class="small" id="tags">
        <i class="fa fa-tags"></i> <?=implode(", ", array_map(function($v) {
            return '<a href="'.site_url('tag/'.$v).'">'.$v.'</a>';
        }, array_filter(explode(",", $post['tags']))))?>
    </div>

    <div class="small">
        <i class="fa fa-clock-o"></i> <?=dateToString($post['dateCreate'])?><br />
        <i class="fa fa-comments-o"></i> <i><?=$post['comments']?> <?=$this->lang->line('posts_comments')?></i>
    </div>
</section>

<section class="panel">
    <h4>Коментари:</h4>

    <?php if (isset($commentResult) && $commentResult !== null) : ?>
        <div class="alert alert-danger"><?=$commentResult?></div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('newComment') !== null) : ?>
        <div class="alert alert-success"><?=$this->session->flashdata('newComment')?></div>
    <?php endif; ?>

    <?=form_open()?>
    <?php if (!$_isLogged) : ?>
    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-user"></i></div>
            <input type="text" id="form_author" name="author" required="required" class="form-control" placeholder="Автор" value="<?=set_value("author")?>" />
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
            <input type="email" id="form_email" name="email" class="form-control" placeholder="E-mail адрес" value="<?=set_value("email")?>" />
        </div>
    </div>
    <?php endif; ?>
    <div class="form-group">
        <textarea id="form_description" name="description" required="required" rows="5" class="form-control" placeholder="Съобщение"><?=set_value("description")?></textarea>
    </div>
    <div><button type="submit" id="form_save" name="post" class="btn btn-primary">Публикувай коментар</button></div>
    <?=form_close()?>
    <hr />
    <?php foreach ($comments as $comment) : ?>
    <div class="comment well">
        <i class="fa fa-user-o"></i> <span class="author"><?=($comment['user_id']) ? '<a href="'.site_url("profile/user/".$comment['author']).'">' : ''?><?=htmlspecialchars($comment['author'])?><?=($comment['user_id']) ? '</a>' : ''?></span>
        <span class="options"><?=(!$comment['approved'] && $_isAdmin) ? '[<a href="?approveComment='.$comment['id'].'&token='.$_token.'">Одобри</a>] ' : ''?><?=($_isAdmin) ? '[<a href="?delComment='.$comment['id'].'&token='.$_token.'" onclick="return confirm(\'Сигурни ли сте?\')">Изтрий</a>]' : ''?></span>
        <p><?=nl2br(htmlspecialchars($comment['description']));?></p>
        &nbsp;<span class="date"><i class="fa fa-clock-o"></i> <?=dateToString($comment['dateCreate'])?></span>
    </div>
    <?php endforeach; ?>
    <?=(isset($pages)) ? $pages : ""?>
</section>
