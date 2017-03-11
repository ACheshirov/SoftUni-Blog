<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model
{
    private $postPerPage = 5;

    public function newPost($title, $category, $description, $tags) {
        $title = trim($title);
        $description = trim($description);

        if (!count($title)) return false;
        if (!count($description)) return false;

        $this->load->model("Categories_model");
        if (!$this->Categories_model->isCategoryExists($category)) return false;

        $inserted = $this->db->insert("posts", array(
            'title' => $title,
            'category' => $category,
            'description' => $description
        ));

        if (!$inserted) return false;

        return $this->db->insert_id();
    }

    public function getPosts($count = null) {
        if ($count === null) $count = $this->postPerPage;

        return $this->db->limit($count)->order_by("id", "DESC")->get("posts")->result_array();
    }

    public function getPostsByCategory($category, $count = null) {
        if ($count === null) $count = $this->postPerPage;

        return $this->db->limit($count)->where('category', (int)$category)->order_by("id", "DESC")->get("posts")->result_array();
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