<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Error_404 extends MY_Controller
{
    public function index() {
        $this->show("error_404");
    }
}