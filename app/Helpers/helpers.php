<?php

if (! function_exists('format_number_to_money')) {
    function format_number_to_money($number)
    {
        return number_format($number, 0, ',', '.') . '₫';
    }
}
