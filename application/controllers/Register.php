<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends MY_Controller
{
    public function index() {
        if ($this->isLogged()) {
            redirect(base_url());
            return;
        }

        $data = array();

        $this->load->helper('form');

        if ($this->input->post("register") !== null) {
            $this->load->model("users");

            $this->load->library('form_validation');

            $this->form_validation->set_rules(
                'username', 'Потребителско име',
                'trim|required|regex_match[/^[a-z0-9][a-z0-9\_\.]{1,28}[a-z0-9]$/i]|is_unique[users.username]',
                array(
                    'required' => 'Не сте въвели потребителско име.',
                    'regex_match' => 'Потребителското Ви име може да съдържа латински букви, числа, долни черти и точки. Не може да започва или завършва с долна черта или точка.',
                    'is_unique' => 'Потребителското име, което сте избрали вече е регистрирано.'
                )
            );
            $this->form_validation->set_rules('email', 'E-mail адрес', 'trim|required|valid_email|is_unique[users.email]', array(
                'required' => 'Не сте въвели E-mail адрес.',
                'valid_email' => 'Не сте въвели валиден E-mail адрес.',
                'is_unique' => 'E-mail адресът, който сте избрали вече е регистрирано.'
            ));

            $this->form_validation->set_rules('password', 'Парола', 'required|min_length[6]', array(
                'required' => 'Не сте въвели парола.',
                'min_length' => 'Паролата Ви трябва да съдържа поне 6 символа.'
            ));

            $this->form_validation->set_rules('password2', 'Потвърдителна парола', 'required|matches[password]', array(
                'required' => 'Не сте въвели потвърдителната парола.',
                'matches' => 'Двете пароли не съвпадат.'
            ));

            if ($this->form_validation->run() !== FALSE) {
                $this->users->registerUser($this->input->post("username"), $this->input->post("password"), $this->input->post("email"));
            } else {
                $data['error'] = current($this->form_validation->error_array());
            }
        }

        $this->show("pages/profile/register", $data);
    }
}