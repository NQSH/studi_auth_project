<?php

function e(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function cleanInput(string $input): string
{
    return trim(strip_tags($input));
}
