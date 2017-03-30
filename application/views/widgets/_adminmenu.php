<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<li role="separator" class="divider"></li>
<li class="dropdown-header"><?=$this->lang->line('menu_administrator')?></li>
<li><a href="<?=site_url("post/new")?>"><?=$this->lang->line('menu_new_post')?></a></li>
<li><a href="<?=site_url("Admin/categories")?>"><?=$this->lang->line('menu_edit_categories')?></a></li>
<li><a href="<?=site_url("Admin/comments")?>"><?=$this->lang->line('menu_unapproved_comments')?> (<?=$commentsNotApproved?>)</a></li>