<?php

if (!function_exists('formatNumber')) {
    function formatNumber($number)
    {
        if ($number >= 1_000_000_000) {
            return number_format($number / 1_000_000_000, 1) . 'B';
        } elseif ($number >= 1_000_000) {
            return number_format($number / 1_000_000, 1) . 'M';
        } elseif ($number >= 1_000) {
            return number_format($number / 1_000, 0) . 'K';
        } else {
            return $number;
        }
    }
}
