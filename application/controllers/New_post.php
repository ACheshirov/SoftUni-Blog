<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class New_post extends MY_Controller
{
    public function index() {
        if (!$this->isAdmin()) {
            $this->show_404();
            return;
        }

        $this->load->model("Categories");
        $this->load->model("Posts");
        $this->load->helper("form");

        $data = array(
            'categories' => $this->Categories->getCategories()
        );

        if ($this->input->post("post") !== null) {
            $newPost = $this->Posts->newPost($this->input->post("title"), $this->input->post("category"), $this->input->post("description"), $this->input->post("tags"));
            if ($newPost) {
                redirect("post/".url_title($this->input->post("title"))."-".$newPost);
            } else
                $data['error'] = "Не сте попълнили коректно всички полета.";
        }

        $this->show("pages/posts/new", $data);
    }
}