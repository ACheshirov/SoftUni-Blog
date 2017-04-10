<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories_model extends CI_Model
{
    /**
     * @param string $name
     * @return mixed
     */
    public function addCategory($name) {
        $name = trim($name);
        if (mb_strlen(($name)) === 0) return false;

        $this->db->insert("categories", ['name' => $name]);
        return $this->db->insert_id();
    }

    /**
     * @param int $id
     * @return bool
     */
    public function isCategoryExists($id) {
        return (bool) $this->db->where('id', $id)->count_all_results("categories");
    }

    /**
     * @return array
     */
    public function getCategories() {
        return $this->db->order_by("id", "ASC")->get("categories")->result_array();
    }

    /**
     * @param int $id
     * @param string $newName
     * @return bool
     */
    public function changeName($id, $newName) {
        $newName = trim($newName);
        if (mb_strlen(($newName)) === 0) return false;

        return $this->db->set("name", $newName)->where("id", $id)->update("categories");
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function deleteCategory($id) {
        return $this->db->where("id", $id)->delete("categories");
    }
}