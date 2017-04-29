<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model
{
    /**
     * @param $id
     * @return array
     * @return null
     */
    public function getUserById($id) {
        if (is_numeric($id))
            return $this->db->where("id", $id)->get("users")->row_array();

        return null;
    }

    /**
     * @param $username
     * @return array
     */
    public function getUserByName($username) {
        return $this->db->where("username", $username)->get("users")->row_array();
    }

    /**
     * @param $username
     * @param $password
     * @param $email
     * @return int
     */
    public function registerUser($username, $password, $email) {
        $data = array(
            "username" => $username,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "email" => $email
        );

        $this->db->insert('users', $data);

        return $this->db->insert_id();
    }

    /**
     * @param $user
     * @param int $increasedWith
     */
    public function increaseComment($user, $increasedWith = 1) {
        $this->db->set('comments', 'comments+'.((int) $increasedWith), FALSE);
        if (gettype($user) == "integer")
            $this->db->where('id', $user);
        else
            $this->db->where('username', $user);

        $this->db->update('users');
    }

    /**
     * @param $user
     * @param int $decreasedWith
     */
    public function decreaseComment($user, $decreasedWith = 1) {
        $this->db->set('comments', 'comments-'.((int) $decreasedWith), FALSE);
        if (gettype($user) == "integer")
            $this->db->where('id', $user);
        else
            $this->db->where('username', $user);

        $this->db->update('users');
    }
}