<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _categories extends CI_Model
{
    public function getData() {
        $this->load->model("Categories_model");

        return array("categories" => $this->Categories_model->getCategories());
    }
}