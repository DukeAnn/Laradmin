<?php

if ( ! function_exists('laravel_version')) {
    /**
     * Get laravel version or check if the same version
     *
     * @param  string|null $version
     *
     * @return string
     */
    function laravel_version($version = null) {
        $app = app();
        $appVersion = $app::VERSION;
        if (is_null($version)) {
            return $appVersion;
        }
        return substr($appVersion, 0, strlen($version)) === $version;
    }
}

if ( ! function_exists('request')) {
    /**
     * Get an instance of the current request or an input item from the request.
     *
     * @param  string  $key
     * @param  mixed   $default
     *
     * @return \Illuminate\Http\Request|string|array
     */
    function request($key = null, $default = null)
    {
        /** @var Illuminate\Http\Request $request */
        $request = app('request');
        if (is_null($key)) {
            return $request;
        }

        return $request->input($key, $default);
    }
}

if ( ! function_exists('route_is')) {
    /**
     * Check if route(s) is the current route.
     *
     * @param  array|string  $routes
     *
     * @return bool
     */
    function route_is($routes)
    {
        if ( ! is_array($routes)) {
            $routes = [$routes];
        }

        /** @var Illuminate\Routing\Router $router */
        $router = app('router');

        return call_user_func_array([$router, 'is'], $routes);
    }
}

if ( ! function_exists('str_studly')) {
    /**
     * Convert a value to studly caps case.
     *
     * @param  string  $value
     *
     * @return string
     */
    function str_studly($value)
    {
        return Illuminate\Support\Str::studly($value);
    }
}
