<?php

/**
 * Determines whether or not end string exists in the string.
 * 
 * @param  string $string
 * @param  string $end_string
 * 
 * @return bool
 */
function endsWith(string $string, string $end_string): bool
{
    $len = strlen($end_string);

    if ($len == 0) {
        return false;
    }

    return (substr($string, -$len) === $end_string);
}