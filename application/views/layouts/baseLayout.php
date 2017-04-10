<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$currPage = $this->uri->segment(1, "home");
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="<?=base_url("assets/css/bootstrap.min.css")?>" type="text/css" />
    <link rel="stylesheet" href="<?=base_url("assets/css/font-awesome.min.css")?>" type="text/css" />
    <link rel="stylesheet" href="<?=base_url("assets/css/app.css")?>" type="text/css" />
    <link rel="stylesheet" href="<?=base_url("assets/summernote/summernote.css")?>" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=site_url("")?>">Блогът на HunteR</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li<?=(in_array($currPage, array('home', 'category', 'tag'))) ? ' class="active"' : ''?>><a href="<?=site_url("")?>"><?=$this->lang->line('menu_home')?></a></li>
                <li<?=($currPage == "portfolio") ? ' class="active"' : ''?>><a href="<?=site_url("portfolio")?>"><?=$this->lang->line('menu_portfolio')?></a></li>
                <li<?=($currPage == "about_me") ? ' class="active"' : ''?>><a href="<?=site_url("about_me")?>"><?=$this->lang->line('menu_about_me')?></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if ($_isLogged) : ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$_username?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=site_url("profile")?>"><?=$this->lang->line('menu_profile')?></a></li>
                            <li><a href="<?=site_url("logout")?>"><?=$this->lang->line('menu_logout')?></a></li>
                            <?php if ($_isAdmin) { $this->loadWidget("_adminmenu"); } ?>
                        </ul>
                    </li>
                <?php else : ?>
                    <li<?=($currPage == "login") ? ' class="active"' : ''?>><a href="<?=site_url("login")?>"><?=$this->lang->line('menu_login')?></a></li>
                    <li<?=($currPage == "register") ? ' class="active"' : ''?>><a href="<?=site_url("register")?>"><?=$this->lang->line('menu_register')?></a></li>
                <?php endif ?>

                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Language <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <?php foreach ($this->config->item("allLanguages") as $langLink => $langText) : ?>
                            <li><a href="<?=site_url("lang/" . $langLink)?>"><?=$langText?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>


<div class="container">
    <div class="row">
        <div class="col-md-9">
            <?=$contentBody?>
        </div>

        <div class="col-md-3">
            <aside class="panel">
                <h4><?=$this->lang->line('panel_categories')?>:</h4>
                <hr />
                <?php $this->loadWidget("_categories"); ?>
            </aside>
        </div>
    </div>
</div>


<footer class="footer">
    <p>This blog system is created by <a href="https://acheshirov.info" target="_blank">Aleksandar Cheshirov</a>.</p>
</footer>

<script type="text/javascript" src="<?=base_url("assets/js/jquery-3.1.1.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/bootstrap.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/summernote/summernote.min.js")?>"></script>
<?php if (isset($jsLoad)) : ?>
    <script type="text/javascript">
        var baseUrl = "<?=site_url()?>/";
        var lang = <?=json_encode($this->lang->language['js'])?>;
        var csfrData = {
            '<?=$this->security->get_csrf_token_name()?>' : '<?=$this->security->get_csrf_hash()?>'
        };
    </script>
    <script type="text/javascript" src="<?=base_url("assets/js/functions.js")?>"></script>
    <script type="text/javascript" src="<?=base_url("assets/js/pages/".$jsLoad.".js")?>"></script>
<?php endif; ?>

</body>
</html>