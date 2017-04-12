<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class _tags extends CI_Model
{
    private function array_icount_values($array) {
        $ret_array = array();
        foreach($array as $value) {
            foreach($ret_array as $key2 => $value2) {
                if(mb_strtolower($key2) == mb_strtolower($value)) {
                    $ret_array[$key2]++;
                    continue 2;
                }
            }
            $ret_array[$value] = 1;
        }
        return $ret_array;
    }

    public function getData() {
        $tags = $this->db->select('tags')->get("posts")->result_array();

        $allTags = array();

        foreach ($tags as $t) {
            $t = array_filter(explode(",", $t['tags']));
                $allTags = array_merge($allTags, $t);
        }

        $outArray = $this->array_icount_values($allTags);

        arsort($outArray);
        $outArray = array_slice($outArray, 0, $this->config->item('tagsCount'));

        ksort($outArray);

        return array('tags' => $outArray);
    }
}