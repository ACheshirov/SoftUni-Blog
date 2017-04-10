<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends MY_Controller
{
    public function _remap($post) {
        $this->setJs("post");

        $isPostExists = true;

        if ($post == "index")
            $isPostExists = false;

        $exPost = explode("-", $post);
        $idPost = end($exPost);

        $this->load->model("Posts_model");

        if (is_numeric($idPost)) {
            $postInfo = $this->Posts_model->getPost($idPost);
            if (!isset($postInfo)) {
                $isPostExists = false;
            }
        } else $isPostExists = false;

        if (!$isPostExists) {
            $this->show_404();
            return;
        }


        $this->load->model('Comments_model');
        $this->load->helper('form');

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
                    'trim|required|min_length[3]|max_length[30]|is_unique[users.username]',
                    array(
                        'required' => 'Не сте оказали кой е автора.',
                        'min_length' => 'Името ви трябва да съдържа минимум 3 символа.',
                        'max_length' => 'Името ви трябва да съдържа максимум 30 символа.',
                        'is_unique' => 'Това име се използва от регистриран потребител.'
                    )
                );
                $this->form_validation->set_rules('email', 'E-mail адрес', 'trim|valid_email', array(
                    'valid_email' => 'Не сте въвели валиден E-mail адрес.'
                ));
            } else {
                $this->load->model("Users_model");
                $userInfo = $this->Users_model->getUserById($userId);

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
                $this->Comments_model->postComment($idPost, $username, $email, $this->input->post("description"), $this->input->ip_address(), $userId, $approved);

                if (!$approved)
                    $this->session->set_flashdata("newComment", "Вашият коментар ще се покаже след като бъде одобрен от администратор.");

                redirect(uri_string());
                return;
            } else
                $data['commentResult'] = current($this->form_validation->error_array());
        }

        $this->approve_delete_comments();

        $data['comments'] = $this->Comments_model->getComments($idPost, $this->isAdmin(), $this->input->get($this->config->item("pagination")['query_string_segment']));

        $this->load->library('pagination');

        $this->pagination->initialize(array_merge($this->config->item("pagination"), [
            'first_url' => current_url(),
            'total_rows' => $this->Comments_model->getTotalComments(),
            'per_page' => $this->config->item('commentsPerPage'),
            'full_tag_open' => '<ul class="pagination pagination-sm">'
        ]));

        $data["pages"] = $this->pagination->create_links();

        $this->show("pages/posts/details", $data);
    }

    private function approve_delete_comments() {
        if (($this->input->get("delComment") !== null || $this->input->get("approveComment") !== null) && $this->isAdmin() && $this->isTokenValid($this->input->get("token"))) {
            if ($this->input->get("delComment") !== null)
                $this->Comments_model->deleteComment($this->input->get("delComment"));

            if ($this->input->get("approveComment") !== null)
                $this->Comments_model->approveComment($this->input->get("approveComment"));
        }
    }
}