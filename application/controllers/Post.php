<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends MY_Controller
{
    public function _remap($post) {
        $isPostExists = true;

        if ($post == "index")
            $isPostExists = false;

        $exPost = explode("-", $post);
        $idPost = end($exPost);

        if (is_numeric($idPost)) {
            $this->load->model("Posts");

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
            $this->form_validation->set_rules('description', 'Съобщение', 'trim|required|min_length[5]|max_length[500]', array(
                'required' => 'Не сте написали съобщение.',
                'min_length' => 'Съобщението Ви трябва да съдържа минимум 5 символа.',
                'max_length' => 'Съобщението Ви трябва да съдържа максимум 500 символа.',
            ));

            if ($this->form_validation->run() !== FALSE) {
                $this->Comments->postComment($idPost, $this->input->post("author"), $this->input->post("email"), $this->input->post("description"), $this->input->ip_address());
                redirect(uri_string());
                return;
            } else
                $data['commentResult'] = current($this->form_validation->error_array());
        }

        $this->deleteComment($this->input->get("delComment"));

        $data['isAdmin'] = $this->isAdmin();
        $data['isLogged'] = $this->isLogged();

        $data['comments'] = $this->Comments->getComments($idPost, $this->isAdmin());

        $this->show("post", $data);
    }

    public function deleteComment($delComment) {
        if ($delComment !== null && $this->isAdmin()) {

        }
    }
}