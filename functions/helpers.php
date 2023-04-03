<?php
if (! function_exists('f')) {
    /**
     * Filters data by using htmlspecialchars()
     *
     */
    function f($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}