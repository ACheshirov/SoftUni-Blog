<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<section class="panel">
    <?php foreach ($posts as $post) : ?>
        <?php $path = site_url("post/".url_title($post['title'])."-".$post['id']); ?>
        <h3><a href="<?=$path?>"><?=$post['title']?></a></h3>
        <p><?=mb_substr($post['description'], 0, 250)?></p>
        <p><a href="<?=$path?>">Виж още...</a></p>
        <i class="fa fa-comments-o"></i> <i><?=$post['comments']?> коментара</i>
        <hr />
    <?php endforeach; ?>
</section>