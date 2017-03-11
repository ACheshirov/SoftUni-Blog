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
                <li<?=(in_array($currPage, array('home', 'category', 'tag'))) ? ' class="active"' : ''?>><a href="<?=site_url("")?>">Начало</a></li>
                <li<?=($currPage == "portfolio") ? ' class="active"' : ''?>><a href="<?=site_url("portfolio")?>">Портфолио</a></li>
                <li<?=($currPage == "about_me") ? ' class="active"' : ''?>><a href="<?=site_url("about_me")?>">За мен</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if ($_isLogged) : ?>
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?=$_username?> <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="<?=site_url("profile")?>">Твоят профил</a></li>
                            <li><a href="<?=site_url("logout")?>">Изход от акаунта</a></li>
                            <?php if ($_isAdmin) { $this->loadWidget("_adminmenu"); } ?>
                        </ul>
                    </li>
                <?php else : ?>
                    <li><a href="<?=site_url("login")?>">Вход</a></li>
                    <li><a href="<?=site_url("register")?>">Регистрация</a></li>
                <?php endif ?>

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
                <h4>Категории:</h4>
                <hr />
                <?php $this->loadWidget("_categories"); ?>
            </aside>
        </div>
    </div>
</div>


<footer class="footer">
    <p>This blog system is created by <a href="https://github.com/ACheshirov/" target="_blank">HunteR</a>.</p>
</footer>

<script type="text/javascript" src="<?=base_url("assets/js/jquery-3.1.1.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/bootstrap.min.js")?>"></script>

</body>
</html>