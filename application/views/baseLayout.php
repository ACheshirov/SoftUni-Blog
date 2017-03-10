<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title></title>

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
            <a class="navbar-brand" href="{{ path('homepage') }}">Блогът на HunteR</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="{{ path('homepage') }}">Начало</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else here</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Nav header</li>
                        <li><a href="#">Separated link</a></li>
                        <li><a href="#">One more separated link</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="../navbar/">Default</a></li>
                <li class="active"><a href="./">Static top <span class="sr-only">(current)</span></a></li>
                <li><a href="../navbar-fixed-top/">Fixed top</a></li>
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