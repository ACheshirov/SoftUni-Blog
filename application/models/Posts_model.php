<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Posts_model extends CI_Model
{
    private $allRows = 0;

    private $postPerPage;
    public function __construct() {
        $this->postPerPage = $this->config->item("postsPerPage");
    }

    private function _tagsFix($tags) {
        return preg_replace('/[\,]{2,}/', ',', ",".trim(preg_replace('/\s*,\s*/', ',', $tags)).",");
    }

    public function newPost($title, $category, $description, $tags) {
        $title = trim($title);
        $description = trim($description);

        if (!mb_strlen($title)) return false;
        if (!mb_strlen($description)) return false;

        $this->load->model("Categories_model");
        if (!$this->Categories_model->isCategoryExists($category)) return false;

        $tags = $this->_tagsFix($tags);

        $inserted = $this->db->insert("posts", array(
            'title' => $title,
            'category' => $category,
            'description' => nl2br($description),
            'tags' => $tags,
            'dateCreate' => date("Y-m-d H:i:s")
        ));

        if (!$inserted) return false;

        return $this->db->insert_id();
    }

    public function editPost($id, $title, $description, $category, $tags) {
        $this->db->set("title", $title);
        $this->db->set("description", $description);
        $this->db->set("category", (int) $category);
        $this->db->set("tags", $this->_tagsFix($tags));

        $this->db->where("id", $id);

        return $this->db->update("posts");
    }

    public function getPosts($offset = null, $count = null) {
        $this->allRows = $this->db->count_all_results("posts", false);

        if ($count === null) $count = $this->postPerPage;
        if ($offset !== null && is_numeric($offset)) $this->db->offset($offset);

        $this->db->join("categories", "posts.category = categories.id");
        $this->db->select("posts.*, categories.name as categoryName");

        return $this->db->limit($count)->order_by("posts.id", "DESC")->get()->result_array();
    }

    public function getPostsByCategory($category, $offset = null, $count = null) {
        $this->db->where('category', (int)$category);

        return $this->getPosts($offset, $count);
    }

    public function getPostsBySearch($search, $offset = null, $count = null) {
        $words = array_unique(array_filter(array_map(function($v) {
            return $this->db->escape_str(trim(mb_strtolower($v)));
        }, explode(" ", $search)), function($v) {
            return (mb_strlen($v) >= 3);
        }));

        if (count($words)) {
            $this->db->group_start();

            foreach ($words as $word)
                $this->db->or_like('`title`', $word, 'both', false);

            $this->db->group_end();


            $this->db->or_group_start();

            foreach ($words as $word)
                $this->db->or_like('`tags`', $word, 'both', false);

            $this->db->group_end();

            $this->db->order_by("((CHAR_LENGTH(`title`) - CHAR_LENGTH(REPLACE(LOWER(`title`), '".implode("', ''))) + (CHAR_LENGTH(`title`) - CHAR_LENGTH(REPLACE(LOWER(`title`), '", $words)."', '')))) DESC");
        }

        return $this->getPosts($offset, $count);
    }

    public function getPostsByTag($tag, $offset = null, $count = null) {
        $this->db->like("tags", ','.urldecode($tag).',');

        return $this->getPosts($offset, $count);
    }

    public function getPost($id) {
        if (is_numeric($id)) {
            $this->db->where("posts.id", $id);
            $this->db->select("posts.*, categories.name as categoryName");
            $this->db->join("categories", "posts.category = categories.id");
            return $this->db->get("posts")->row_array();
        }

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