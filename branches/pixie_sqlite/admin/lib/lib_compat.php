<?php

function stripos($haystack, $needle, $offset = null)
{
    if (!is_scalar($haystack)) {
        user_error('stripos() expects parameter 1 to be string, ' .
            gettype($haystack) . ' given', E_USER_WARNING);
        return false;
    }

    if (!is_scalar($needle)) {
        user_error('stripos() needle is not a string or an integer.', E_USER_WARNING);
        return false;
    }

    if (!is_int($offset) && !is_bool($offset) && !is_null($offset)) {
        user_error('stripos() expects parameter 3 to be long, ' .
            gettype($offset) . ' given', E_USER_WARNING);
        return false;
    }

    // Manipulate the string if there is an offset
    $fix = 0;
    if (!is_null($offset)) {
        if ($offset > 0) {
            $haystack = substr($haystack, $offset, strlen($haystack) - $offset);
            $fix = $offset;
        }
    }

    $segments = explode(strtolower($needle), strtolower($haystack), 2);

    // Check there was a match
    if (count($segments) === 1) {
        return false;
    }

    $position = strlen($segments[0]) + $fix;
    return $position;
}

