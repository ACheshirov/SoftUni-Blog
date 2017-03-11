<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller
{
    public function __construct() {
        parent::__construct();

        $this->load->model("Users_model");
    }

    public function index() {
        $userId = $this->isLogged();
        if (!$userId) {
            redirect("login");
            return;
        }

        $this->displayUserInfo($this->Users_model->getUserById($userId), true);
    }

    public function edit() {
        $userId = $this->isLogged();
        if (!$userId) {
            redirect("login");
            return;
        }
    }

    public function user($username) {
        $userInfo = $this->Users_model->getUserByName($username);
        if ($userInfo !== null)
            $this->displayUserInfo($this->Users_model->getUserByName($username));
        else
            $this->show_404();
    }

    private function displayUserInfo($userInfo, $showEditButton = false) {
        $userInfo['showEditButton'] = $showEditButton;

        $this->show("pages/profile/preview", $userInfo);
    }
}