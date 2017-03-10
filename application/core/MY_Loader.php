<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader
{
    public function loadWidget($widget) {
        $data = null;

        $filePath = "application/models/widgets/" . $widget . ".php";
        if (file_exists($filePath)) {
            $ci = &get_instance();
            $ci->load->model("widgets/" . $widget);
            $data = $ci->$widget->getData();
        }

        $ci->load->view("widgets/" . $widget, $data);
    }
}