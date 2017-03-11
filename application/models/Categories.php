<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends CI_Model
{
    public function isCategoryExists($id) {
        return (bool) $this->db->where('id', $id)->count_all_results("categories");
    }

    public function getCategories() {
        return $this->db->order_by("id", "ASC")->get("categories")->result_array();
    }
}