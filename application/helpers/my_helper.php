<?php
function dateToString($date)
{
    $today = new DateTime();
    $date = new DateTime($date);

    $days = ["днес", "вчера"];

    $daysDiff = $date->diff($today)->days;
    $str = [];
    if (array_key_exists($daysDiff, $days)) {
        $str[] = $days[$daysDiff];
        $str[] = $date->format("H:i") . " часа";
    } else {
        $str[] = "преди " . $daysDiff . " дена";
    }

    return implode(", ", $str);
}