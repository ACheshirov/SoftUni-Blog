<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="panel">
    <?php foreach ($posts as $post) : ?>
        <?php $path = site_url("post/".url_title($post['title'])."-".$post['id']); ?>
        <h3><a href="<?=$path?>"><?=$post['title']?></a></h3>
        <p><i class="fa fa-folder-open"></i> <a href="<?=site_url("category/".url_title($post['categoryName'])."-".$post['category'])?>"><?=$post['categoryName']?></a></p>
        <p><?=mb_substr(strip_tags($post['description']), 0, 250)?>...</p>
        <p><a href="<?=$path?>"><?=$this->lang->line('posts_view_more')?>...</a></p>
        <div class="small">
            <i class="fa fa-clock-o"></i> <?=dateToString($post['dateCreate'])?><br />
            <i class="fa fa-comments-o"></i> <i><?=$post['comments']?> <?=$this->lang->line('posts_comments')?></i>
        </div>
        <hr />
    <?php endforeach; ?>
    <?=(isset($pages)) ? $pages : ""?>
</section>