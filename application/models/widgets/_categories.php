<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _categories extends CI_Model
{
    public function getData() {
        return array("categories" => $this->db->order_by("id", "ASC")->get("categories")->result_array());
    }
}