<?php


if (!function_exists('is_active_route')) {
    function is_active_route(string $routePattern, bool $mathOnly = false): bool
    {
        $path = current_url(true)->getPath();
        if ($mathOnly) return $path == $routePattern ? true : false;

        return strpos($path, $routePattern) === 0 ? true : false;
    }
}

if (!function_exists('is_active_class')) {
    function is_active_class(string $routePattern, bool $mathOnly = false): string
    {
        $isActive = is_active_route($routePattern, $mathOnly);
        return $isActive ? "active" : "";
    }
}
