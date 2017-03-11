<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Comments extends CI_Model
{
    public function getComments($id, $isAdmin) {
        if (is_numeric($id)) {
            if (!$isAdmin)
                $this->db->where('approved', true);

            return $this->db->where("post_id", $id)->order_by("id", "DESC")->get("comments")->result_array();
        }
        return null;
    }

    /**
     * @param $id
     * @return bool
     */
    public function deleteComment($id) {
        $id = $this->idToArray($id);
        if (!$id) return;

        $result = $this->getPostIds($id, true);
        if (count($result)) {
            $this->load->model("Posts");
            foreach ($result as $r)
                $this->Posts->decreaseComments($r['post_id'], $r['total']);
        }

        $this->db->where_in('id', $id);
        return $this->db->delete('comments');
    }

    /**
     * @param $id
     * @return bool
     */
    public function approveComment($id) {
        $id = $this->idToArray($id);
        if (!$id) return;

        $result = $this->getPostIds($id, false);
        if (count($result)) {
            $this->load->model("Posts");
            foreach ($result as $r)
                $this->Posts->increaseComments($r['post_id'], $r['total']);
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
     * @param $id
     * @param $author
     * @param $email
     * @param $description
     * @param $ip
     * @param int $user_id
     * @param bool $approved
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
                $this->load->model("Posts");
                $this->Posts->increaseComments($id);
            }

            if ($email !== null)
                $data['email'] = $email;

            return $this->db->insert('comments', $data);
        }
    }
}