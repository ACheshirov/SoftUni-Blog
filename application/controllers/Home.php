<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller
{
    public function __construct() {
        parent::__construct();

        $this->load->model("Posts_model");
    }

    public function index() {
        $this->loadPosts();
	}

    public function category($category) {
        $exCategory = explode("-", $category);
        $idCategory = end($exCategory);

        if (!is_numeric($idCategory)) {
            $this->show_404();
            return;
        }

        $this->loadPosts(["posts" => $this->Posts_model->getPostsByCategory($idCategory, $this->input->get($this->config->item("pagination")['query_string_segment']))]);
    }

    private function loadPosts($data = []) {
        if (!isset($data['posts']))
            $data['posts'] = $this->Posts_model->getPosts($this->input->get($this->config->item("pagination")['query_string_segment']));

        $this->load->library('pagination');

        $this->pagination->initialize(array_merge($this->config->item("pagination"), [
            'per_page' => $this->config->item("postsPerPage"),
            'first_url' => current_url(),
            'total_rows' => $this->Posts_model->getTotalRows()
        ]));

        $data["pages"] = $this->pagination->create_links();

        $this->show("pages/home", $data);
    }
}
