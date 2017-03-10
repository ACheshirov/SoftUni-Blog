<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<ul>
    <?php foreach ($categories as $cat) : ?>
    <li><a href="<?=site_url("category/".url_title($cat['name'])."-".$cat['id'])?>"><?=$cat['name']?></a></li>
    <?php endforeach; ?>
</ul>