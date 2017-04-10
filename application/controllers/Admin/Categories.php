<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller
{
    public function __construct() {
        parent::__construct();

        $this->load->model("Categories_model");
        $this->setJs("categories");
    }

    public function index() {
        if (!$this->isAdmin()) {
            $this->show_404();
            return;
        }

        $data = array();

        $data['categories'] = $this->Categories_model->getCategories();

        $this->show("admin/categories", $data);
    }

    public function add() {
        if ($this->isAdmin())
            echo $this->Categories_model->addCategory($this->input->post("name"));
    }

    public function edit() {
        if ($this->isAdmin())
            $this->Categories_model->changeName($this->input->post("id"), $this->input->post("name"));
    }

    public function delete() {
        if ($this->isAdmin())
            $this->Categories_model->deleteCategory($this->input->post("id"));
    }
}