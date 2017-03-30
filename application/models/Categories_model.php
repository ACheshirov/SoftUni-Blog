<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends CI_Model
{
    public function addCategory($name) {
        $name = trim($name);
        if (mb_strlen(($name)) === 0) return false;

        $this->db->insert("categories", ['name' => $name]);
        return $this->db->insert_id();
    }

    public function isCategoryExists($id) {
        return (bool) $this->db->where('id', $id)->count_all_results("categories");
    }

    public function getCategories() {
        return $this->db->order_by("id", "ASC")->get("categories")->result_array();
    }

    public function changeName($id, $newName) {
        $newName = trim($newName);
        if (mb_strlen(($newName)) === 0) return false;

        return $this->db->set("name", $newName)->where("id", $id)->update("categories");
    }

    public function deleteCategory($id) {
        return $this->db->where("id", $id)->delete("categories");
    }
}