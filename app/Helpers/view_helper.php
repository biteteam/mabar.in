<?php

if (!function_exists('views')) {
    function views(string $name, array $data = [], array $options = []): string
    {
        return view($name, $data, $options);
    }
}
