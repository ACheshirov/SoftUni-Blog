<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['defaultLayout'] = "baseLayout";

$config['defaultLanguage'] = "bulgaria";
$config['allLanguages'] = array('bulgaria' => 'Български', 'english' => 'English');

$config['tagsCount'] = 15;

$config['postsPerPage'] = 5;
$config['commentsPerPage'] = 15;
$config['commentsPerPageAdmin'] = 50;

$config['pagination'] = [
    'page_query_string' => true,
    'query_string_segment' => 'page',
    'reuse_query_string' => true,

    'full_tag_open' => '<ul class="pagination">',
    'full_tag_close' => '</ul>',

    'first_tag_open' => '<li>',
    'first_tag_close' => '</li>',

    'last_tag_open' => '<li>',
    'last_tag_close' => '</li>',

    'next_link' => '&raquo;',
    'next_tag_open' => '<li>',
    'next_tag_close' => '</li>',

    'prev_link' => '&laquo;',
    'prev_tag_open' => '<li>',
    'prev_tag_close' => '</li>',

    'cur_tag_open' => '<li class="active"><span>',
    'cur_tag_close' => '<span class="sr-only">(current)</span></li>',

    'num_tag_open' => '<li>',
    'num_tag_close' => '</li>'
];