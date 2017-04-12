<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model
{
    private $allRows = 0;

    private $postPerPage;
    public function __construct() {
        $this->postPerPage = $this->config->item("postsPerPage");
    }

    public function newPost($title, $category, $description, $tags) {
        $title = trim($title);
        $description = trim($description);

        if (!mb_strlen($title)) return false;
        if (!mb_strlen($description)) return false;

        $this->load->model("Categories_model");
        if (!$this->Categories_model->isCategoryExists($category)) return false;

        $tags = preg_replace('[\,]{2,}', ',', ",".trim(preg_replace('/\s*,\s*/', ',', $tags)).",");

        $inserted = $this->db->insert("posts", array(
            'title' => $title,
            'category' => $category,
            'description' => nl2br($description),
            'tags' => $tags
        ));

        if (!$inserted) return false;

        return $this->db->insert_id();
    }

    public function editPost($id, $title, $description) {
        $this->db->set("title", $title);
        $this->db->set("description", $description);

        $this->db->where("id", $id);
        return $this->db->update("posts");
    }

    public function getPosts($offset = null, $count = null) {
        $this->allRows = $this->db->count_all_results("posts", false);

        if ($count === null) $count = $this->postPerPage;
        if ($offset !== null && is_numeric($offset)) $this->db->offset($offset);

        return $this->db->limit($count)->order_by("id", "DESC")->get()->result_array();
    }

    public function getPostsByCategory($category, $offset = null, $count = null) {
        $this->db->where('category', (int)$category);

        return $this->getPosts($offset, $count);
    }

    public function getPostsByTag($tag, $offset = null, $count = null) {
        $this->db->like("tags", urldecode($tag));

        return $this->getPosts($offset, $count);
    }

    public function getPost($id) {
        if (is_numeric($id))
            return $this->db->where("id", $id)->get("posts")->row_array();

        return null;
    }

    public function getTotalRows() {
        return $this->allRows;
    }

    public function increaseComments($id, $count = 1) {
        return $this->db->set("comments", "comments + " . ((int) $count), false)->where("id", $id)->update("posts");
    }

    public function decreaseComments($id, $count = 1) {
        return $this->db->set("comments", "comments - " . ((int) $count), false)->where("id", $id)->update("posts");
    }
}