<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller
{
    public function _remap() {
        if ($this->isLogged()) {
            redirect(base_url());
            return;
        }

        $redirectTo = null;
        if ($this->uri->total_segments() > 1) {
            $segs = $this->uri->segment_array();
            array_shift($segs);
            $redirectTo = implode("/", $segs);
        }

        $data = array();

        $this->load->helper('form');

        if ($this->input->post("login") !== null) {
            $this->load->model("Users_model");

            $userInfo = $this->Users_model->getUserByName($this->input->post("username"));
            if ($userInfo !== null) {
                if (password_verify($this->input->post("password"), $userInfo['password'])) {
                    $this->setLogged($userInfo['id'], $userInfo['username'], $userInfo['admin']);

                    if ($redirectTo !== null)
                        redirect($redirectTo);
                    else
                        redirect(base_url());

                } else $data['error'] = "Грешно потребителско име или парола.";
            } else
                $data['error'] = "Грешно потребителско име или парола.";
        }

        $this->show("pages/profile/login", $data);
    }
}