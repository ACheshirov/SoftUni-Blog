<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<li role="separator" class="divider"></li>
<li class="dropdown-header">Администратор</li>
<li><a href="<?=site_url("post/new")?>">Нов пост</a></li>
<li><a href="<?=site_url("categories")?>">Реактиране на категориите</a></li>
<li><a href="<?=site_url("comments")?>">Неодобрени коментари (<?=$commentsNotApproved?>)</a></li>