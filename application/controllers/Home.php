<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {
	public function index()
	{
        $this->load->model("Posts");

        $data = array(
            "posts" => $this->Posts->getPosts()
        );

		$this->show("home", $data);
	}
}
