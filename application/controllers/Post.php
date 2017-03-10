<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends MY_Controller
{
    public function _remap($post) {
        $isPostExists = true;

        if ($post == "index")
            $isPostExists = false;

        $this->load->model("Posts");

        if ($post == "new") {
            $this->show("pages/posts/new");
            return;
        }

        $exPost = explode("-", $post);
        $idPost = end($exPost);

        if (is_numeric($idPost)) {
            $postInfo = $this->Posts->getPost($idPost);
            if (!isset($postInfo)) {
                $isPostExists = false;
            }
        } else $isPostExists = false;

        if (!$isPostExists) {
            $this->show_404();
            return;
        }

        $this->load->helper('form');
        $this->load->model('Comments');

        $data = array(
            'post' => $postInfo
        );

        if ($this->input->post("post") !== null) {
            $this->load->library('form_validation');

            $userId = $this->isLogged();
            $username = $this->input->post("author");
            $email = $this->input->post("email");

            $approved = false;

            if (!$userId) {
                $this->form_validation->set_rules(
                    'author', 'Автор',
                    'trim|required|min_length[3]|max_length[30]',
                    array(
                        'required' => 'Не сте оказали кой е автора.',
                        'min_length' => 'Името ви трябва да съдържа минимум 3 символа.',
                        'max_length' => 'Името ви трябва да съдържа максимум 30 символа.',
                    )
                );
                $this->form_validation->set_rules('email', 'E-mail адрес', 'trim|valid_email', array(
                    'valid_email' => 'Не сте въвели валиден E-mail адрес.'
                ));
            } else {
                $this->load->model("Users");
                $userInfo = $this->Users->getUserById($userId);

                if ($userInfo['trusted'] || $userInfo['admin'])
                    $approved = true;

                $username = $userInfo['username'];
                $email = $userInfo['email'];
            }

            $this->form_validation->set_rules('description', 'Съобщение', 'trim|required|min_length[5]|max_length[500]', array(
                'required' => 'Не сте написали съобщение.',
                'min_length' => 'Съобщението Ви трябва да съдържа минимум 5 символа.',
                'max_length' => 'Съобщението Ви трябва да съдържа максимум 500 символа.',
            ));

            if ($this->form_validation->run() !== FALSE) {
                $this->Comments->postComment($idPost, $username, $email, $this->input->post("description"), $this->input->ip_address(), $userId, $approved);
                redirect(uri_string());
                return;
            } else
                $data['commentResult'] = current($this->form_validation->error_array());
        }

        $this->approve_delete_comments();

        $data['comments'] = $this->Comments->getComments($idPost, $this->isAdmin());

        $this->show("pages/posts/details", $data);
    }

    public function approve_delete_comments() {
        if (($this->input->get("delComment") !== null || $this->input->get("approveComment") !== null) && $this->isAdmin() && $this->isTokenValid($this->input->get("token"))) {
            if ($this->input->get("delComment") !== null)
                $this->Comments->deleteComment($this->input->get("delComment"));

            if ($this->input->get("approveComment") !== null)
                $this->Comments->approveComment($this->input->get("approveComment"));
        }
    }
}