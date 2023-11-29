<?php

if (!function_exists('initial_name')) {
    function initial_name(string $name, string | null $separator = null)
    {
        $initial = "";
        $names = explode(' ', $name);
        $separator = !empty($separator) ? $separator : "";

        foreach ($names as $name) {
            $initial .= mb_substr($name, 0, 1, "UTF-8") . $separator;
        }

        return rtrim($initial, $separator);
    }
}

if (!function_exists('first_name')) {
    function first_name(string $name, string | null $separator = null): string
    {
        $firstName = explode($separator ?? ' ', $name)[0];
        return ucfirst($firstName);
    }
}
