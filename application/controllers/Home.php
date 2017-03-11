<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
    public function __construct() {
        parent::__construct();

        $this->load->model("Posts");
    }

    public function index()
	{
        $data = array(
            "posts" => $this->Posts->getPosts()
        );

		$this->show("pages/home", $data);
	}

    public function category($category) {
        $exCategory = explode("-", $category);
        $idCategory = end($exCategory);

        if (!is_numeric($idCategory)) {
            $this->show_404();
            return;
        }

        $data = array(
            "posts" => $this->Posts->getPostsByCategory($idCategory)
        );

        $this->show("pages/home", $data);
    }
}
