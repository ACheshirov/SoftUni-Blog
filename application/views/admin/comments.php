<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="panel">
    <h4><?=$this->lang->line('commentsForApprove')?></h4>

    <?php if (count($comments)) : ?>
        <?=form_open()?>
        <?php foreach ($comments as $comment) : ?>
            <div class="comment">
                <i class="fa fa-user-o"></i> <span class="author"><?=($comment['user_id']) ? '<a href="'.site_url("profile/user/".$comment['author']).'">' : ''?><?=htmlspecialchars($comment['author'])?><?=($comment['user_id']) ? '</a>' : ''?></span>
                <span class="options"><input type="checkbox" name="comment[]" value="<?=$comment['id']?>" /></span>
                <p><?=nl2br(htmlspecialchars($comment['description']));?></p>
                &nbsp;<span class="date"><i class="fa fa-clock-o"></i> <?=date('H:i d.m.Y', strtotime($comment['dateCreate']))?></span>
            </div>
        <?php endforeach; ?>
        <div>
            <button type="submit" name="approve" class="btn btn-primary"><?=$this->lang->line('buttonApproveComments')?></button>
            <button type="submit" name="delete" class="btn btn-danger"><?=$this->lang->line('buttonDeleteComments')?></button>
        </div>
        <?=form_close()?>
    <?php else : ?>
        <p><?=$this->lang->line('noCommentsForApprove')?></p>
    <?php endif; ?>
</section>