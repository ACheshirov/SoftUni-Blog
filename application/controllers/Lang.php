<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lang extends MY_Controller
{
    public function _remap($lang) {
        if (array_key_exists($lang, $this->config->item("allLanguages")))
            set_cookie("language", $lang, 60 * 60 * 24 * 30 * 12);

        if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != "")
            redirect($_SERVER['HTTP_REFERER']);
        else
            redirect(base_url());
    }
}