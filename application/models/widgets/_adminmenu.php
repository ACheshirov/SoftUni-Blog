<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _adminmenu extends CI_Model
{
    public function getData() {
        $this->load->model("Comments_model");

        $data = array(
            'commentsNotApproved' => $this->Comments_model->countNotApproved()
        );

        return $data;
    }
}