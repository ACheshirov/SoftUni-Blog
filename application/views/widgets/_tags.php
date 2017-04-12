<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$fontMin = 14;
$fontMax = 20;

if (count($tags)) {
    $numMin = min($tags);
    $numMax = max($tags);

    $r = $numMax - $numMin;
    foreach ($tags as $t => $v) {
        $fontSize = $fontMin + @round(($fontMax - $fontMin) * (($v - $numMin) / $r));
        echo '<a href="'.site_url('tag/'.$t).'" style="font-size: '.$fontSize.'px">'.$t.'</a> ';
    }
}