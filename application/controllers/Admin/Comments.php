<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends MY_Controller
{
    public function __construct() {
        parent::__construct();

        $this->load->model("Comments_model");
    }

    public function index() {
        if (!$this->isAdmin()) {
            $this->show_404();
            return;
        }

        if ($this->input->post("approve") !== null) $this->approve();
        if ($this->input->post("delete") !== null) $this->delete();

        $this->load->helper("form");

        $data = array(
            "comments" => $this->Comments_model->getCommentsNotApproved()
        );

        $this->show("admin/comments", $data);
    }

    private function approve() {
        $this->Comments_model->approveComment($this->input->post("comment"));
        redirect("Admin/comments");
    }

    private function delete() {
        $this->Comments_model->deleteComment($this->input->post("comment"));
        redirect("Admin/comments");
    }
}