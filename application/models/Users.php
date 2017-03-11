<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model
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
     * @return boolean
     */
    public function registerUser($username, $password, $email) {
        $data = array(
            "username" => $username,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "email" => $email
        );
        return $this->db->insert('users', $data);
    }
}