<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments_model extends CI_Model
{
    private $allRows = 0;

    /**
     * @param int $id
     * @param bool $isAdmin
     * @param int $offset
     * @param int $count
     * @return array
     */
    public function getComments($id, $isAdmin, $offset = null, $count = null) {
        if (is_numeric($id)) {
            if (!$isAdmin)
                $this->db->where('approved', true);

            $this->db->where("post_id", $id);

            $this->allRows = $this->db->count_all_results("comments", false);

            if ($offset !== null && is_numeric($offset)) $this->db->offset($offset);
            if ($count === null) $count = $this->config->item("commentsPerPage");

            return $this->db->order_by("id", "DESC")->limit($count)->get()->result_array();
        }
        return null;
    }

    /**
     * @param int $offset
     * @param int $count
     * @return array
     */
    public function getCommentsNotApproved($offset = null, $count = null) {
        $this->db->where("approved", false);

        $this->allRows = $this->db->count_all_results("comments", false);

        if ($offset !== null && is_numeric($offset)) $this->db->offset($offset);
        if ($count === null) $count = $this->config->item("commentsPerPageAdmin");

        return $this->db->order_by("id", "ASC")->limit($count)->get()->result_array();
    }

    /**
     * @return int
     */
    public function getTotalComments() {
        return $this->allRows;
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteComment($id) {
        $id = $this->idToArray($id);
        if (!$id) return;

        $result = $this->getPostIds($id, true);
        if (count($result)) {
            $this->load->model("Posts_model");
            foreach ($result as $r)
                $this->Posts_model->decreaseComments($r['post_id'], $r['total']);
        }

        $this->db->where_in('id', $id);
        return $this->db->delete('comments');
    }

    /**
     * @param int $id
     * @return bool
     */
    public function approveComment($id) {
        $id = $this->idToArray($id);
        if (!$id) return;

        $result = $this->getPostIds($id, false);
        if (count($result)) {
            $this->load->model("Posts_model");
            foreach ($result as $r)
                $this->Posts_model->increaseComments($r['post_id'], $r['total']);
        }

        $this->db->set("approved", 1);
        $this->db->where_in('id', $id);
        return $this->db->update('comments');
    }

    private function idToArray($id) {
        if (is_array($id)) {
            $id = array_filter($id, function ($v) {
                return is_numeric($v);
            });
            if (!count($id)) return false;
        }
        elseif (is_numeric($id))
            $id = array($id);
        else return false;

        return $id;
    }

    private function getPostIds($commentIds, bool $approved) {
        $this->db->select('post_id, COUNT(post_id) as total');
        $this->db->group_by('post_id');
        $this->db->where('approved', $approved);
        $this->db->where_in('id', $commentIds);
        return $this->db->get('comments')->result_array();
    }

    /**
     * @param int $id
     * @param int $author
     * @param string $email
     * @param string $description
     * @param string $ip
     * @param int $user_id
     * @param bool $approved
     *
     * @return bool
     */
    public function postComment($id, $author, $email, $description, $ip, $user_id = 0, $approved = false) {
        if (is_numeric($id)) {
            $data = array(
                'post_id' => $id,
                'user_id' => $user_id,
                'author' => $author,
                'description' => $description,
                'dateCreate' => date("Y-m-d H:i:s"),
                'ip' => $ip,
                'approved' => (bool) $approved
            );

            if ($approved) {
                $this->load->model("Posts_model");
                $this->Posts_model->increaseComments($id);
            }

            if ($email !== null)
                $data['email'] = $email;

            return $this->db->insert('comments', $data);
        }
    }

    /**
     * @return int
     */
    public function countNotApproved() {
        return $this->db->where("approved", false)->count_all_results("comments");
    }
}