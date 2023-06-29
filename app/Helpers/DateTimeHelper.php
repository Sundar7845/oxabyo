<?php
if (!function_exists('format_messaging_date')) {
    function format_messaging_date($timestamp)
    {
        $date = date('F j, Y, g:i a', strtotime($timestamp));
        $today = new DateTime("today");
        $match_date = DateTime::createFromFormat("Y-m-d H:i:s", $timestamp);
        $match_date->setTime(0, 0, 0);
        $diff = $today->diff($match_date);
        $diffDays = (int)$diff->format("%R%a");
        switch ($diffDays) {
            case 0:
                $date = date('g:i a', strtotime($timestamp));
                break;
            case -1:
                $date = 'Yesterday ' . date('g:i a', strtotime($timestamp));
                break;
        }
        return $date;
    }
}
