<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts extends CI_Model
{
    public function getPosts($count = null) {
        if ($count === null) $count = 5;

        return $this->db->limit($count)->get("posts")->result_array();
    }

    public function getPost($id) {
        if (is_numeric($id))
            return $this->db->where("id", $id)->get("posts")->row_array();

        return null;
    }

    public function increaseComments($id, $count = 1) {
        return $this->db->set("comments", "comments + " . ((int) $count), false)->where("id", $id)->update("posts");
    }

    public function decreaseComments($id, $count = 1) {
        return $this->db->set("comments", "comments - " . ((int) $count), false)->where("id", $id)->update("posts");
    }
}