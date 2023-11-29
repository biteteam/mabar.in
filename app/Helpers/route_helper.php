<?php


if (!function_exists('is_active_route')) {
    function is_active_route($routePattern)
    {
        $path = current_url(true)->getPath();

        return strpos($path, $routePattern) === 0 ? true : false;
    }
}

if (!function_exists('is_active_class')) {
    function is_active_class($routePattern)
    {
        $isActive = is_active_route($routePattern);
        return $isActive ? "active" : "";
    }
}
