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
            "comments" => $this->Comments_model->getCommentsNotApproved($this->input->get($this->config->item("pagination")['query_string_segment']))
        );

        $this->load->library('pagination');

        $this->pagination->initialize(array_merge($this->config->item("pagination"), [
            'per_page' => $this->config->item("commentsPerPageAdmin"),
            'first_url' => current_url(),
            'total_rows' => $this->Comments_model->getTotalComments(),
            'full_tag_open' => '<ul class="pagination pagination-sm">'
        ]));

        $data["pages"] = $this->pagination->create_links();

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