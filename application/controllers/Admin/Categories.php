<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller
{
    public function __construct() {
        parent::__construct();
        $this->loginRequired();

        $this->load->model("Categories_model");
        $this->setJs("categories");
    }

    public function index() {
        $data = array();

        $data['categories'] = $this->Categories_model->getCategories();

        $this->show("admin/categories", $data);
    }

    public function add() {
        echo $this->Categories_model->addCategory($this->input->post("name"));
    }

    public function edit() {
        $this->Categories_model->changeName($this->input->post("id"), $this->input->post("name"));
    }

    public function delete() {
        $this->Categories_model->deleteCategory($this->input->post("id"));
    }
}