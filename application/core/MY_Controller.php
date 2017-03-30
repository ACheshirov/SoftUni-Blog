<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
    private $token = null;
    private $jsLoad = null;

    public function __construct() {
        parent::__construct();

        $this->token = $this->session->userdata("token");
        if ($this->token === null)
            $this->generateToken();
    }

    public function setJs($jsName) {
        $this->jsLoad = $jsName;
    }

    public function show($view, $data = array(), $loadLayout = null) {
        $languageLoad = get_cookie("language");
        if ($languageLoad === null || !array_key_exists($languageLoad, $this->config->item("allLanguages")))
            $languageLoad = $this->config->item("defaultLanguage");

        $this->lang->load('app', $languageLoad);

        if ($loadLayout === null) $loadLayout = $this->config->item("defaultLayout");

        $data = array_merge($data, array(
            "_isLogged" => $this->isLogged(),
            "_isAdmin" => $this->isAdmin(),
            "_username" => $this->session->userdata("username"),
            "_token" => $this->token
        ));

        if ($this->jsLoad !== null) $data['jsLoad'] = $this->jsLoad;

        $this->load->view("layouts/".$loadLayout, array_merge($data, array("contentBody" => $this->load->view($view, $data, true))));
    }

    public function isTokenValid($token) {
        if ($this->token == $token) {
            $this->generateToken();
            return true;
        }

        return false;
    }

    private function generateToken() {
        $this->token = substr(str_shuffle("1234567890qwertyuiopasdfghjklzxcvbnm"), 0, 10);
        $this->session->set_userdata("token", $this->token);
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

        return 0;
    }

    public function loginRequired($whiteListed = array()) {
        if (in_array($this->router->fetch_method(), $whiteListed)) return;

        if (!$this->isLogged()) {
            redirect("login/".uri_string());
            exit();
        }
    }

    public function isAdmin() {
        return ($this->session->userdata('id_user') !== null && $this->session->userdata('isAdmin') == true);
    }

    public function show_404() {
        $this->show("error_404");
    }
}