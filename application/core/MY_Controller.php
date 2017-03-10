<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    public function show($view, $data = null, $loadLayout = null) {
        if ($loadLayout === null) $loadLayout = "baseLayout";
        $this->load->view($loadLayout, array("contentBody" => $this->load->view($view, $data, true)));
    }

    public function setLogged($idUser, $username, $isAdmin) {
        $this->session->set_userdata(array(
            "id_user" => (int)$idUser,
            "username" => $username,
            "isAdmin" => (bool)$isAdmin
        ));
    }

    public function setLogout() {
        $this->session->unset_userdata(array("id_user", "username", "isAdmin"));
    }

    public function isLogged() {
        if ($this->session->userdata('id_user') !== null) {
            return $this->session->userdata('id_user');
        }

        return false;
    }

    public function isAdmin() {
        return ($this->session->userdata('id_user') !== null && $this->session->userdata('isAdmin') == true);
    }

    public function show_404() {
        $this->show("error_404");
    }
}