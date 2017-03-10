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

    public function postComment($id, $author, $email, $description, $ip, $approved = false) {
        if (is_numeric($id)) {
            $data = array(
                'post_id' => $id,
                'author' => $author,
                'description' => $description,
                'dateCreate' => date("Y-m-d H:i:s"),
                'ip' => $ip,
                'approved' => (bool) $approved
            );

            if ($email !== null)
                $data['email'] = $email;

            $this->db->insert('comments', $data);
        }
    }
}