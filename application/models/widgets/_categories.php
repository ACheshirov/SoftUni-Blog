<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _categories extends CI_Model
{
    public function getData() {
        $this->load->model("Categories");

        return array("categories" => $this->Categories->getCategories());
    }
}