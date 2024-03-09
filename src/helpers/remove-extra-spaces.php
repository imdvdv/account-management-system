<?php

// The function replaces multiple spaces in a string with one
function removeExtraSpaces (string $str): string {
    return preg_replace("/\s+/", " ", $str);
}