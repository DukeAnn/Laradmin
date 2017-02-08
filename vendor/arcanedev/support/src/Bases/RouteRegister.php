<?php namespace Arcanedev\Support\Bases;

use Closure;
use Illuminate\Contracts\Routing\Registrar;

/**
 * Class     RouteRegister
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class RouteRegister
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The router instance.
     *
     * @var \Illuminate\Contracts\Routing\Registrar|\Illuminate\Routing\Router
     */
    protected $router;

    /**
     * Base route prefix.
     *
     * @var string
     */
    private $prefix    = '';

    /**
     * Route name.
     *
     * @var string
     */
    private $routeName = '';

    /**
     * Route middlewares.
     *
     * @var array|string
     */
    private $middlewares = null;

    /**
     * Route namespace.
     *
     * @var string
     */
    private $namespace = '';

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * RouteRegister constructor.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    public function __construct(Registrar $router)
    {
        $this->setRegister($router);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register and map routes.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    public static function register(Registrar $router)
    {
        (new static($router))->map($router);
    }

    /**
     * Map routes.
     *
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     */
    abstract public function map(Registrar $router);

    /* ------------------------------------------------------------------------------------------------
     |  Getter & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * @param  \Illuminate\Contracts\Routing\Registrar  $router
     *
     * @return self
     */
    public function setRegister(Registrar $router)
    {
        $this->router = $router;

        return $this;
    }

    /**
     * Set prefix.
     *
     * @param  string  $prefix
     *
     * @return self
     */
    protected function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }
    /**
     * Add prefix.
     *
     * @param  string  $prefix
     *
     * @return self
     */
    protected function addPrefix($prefix)
    {
        if ( ! empty($this->prefix)) {
            $prefix = "{$this->prefix}/{$prefix}";
        }

        return $this->setPrefix($prefix);
    }

    /**
     * Set route namespace.
     *
     * @param  string  $namespace
     *
     * @return self
     */
    protected function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Set route name.
     *
     * @param  string  $routeName
     *
     * @return self
     */
    protected function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * Set route middlewares.
     *
     * @param  array|string  $middleware
     *
     * @return self
     */
    protected function setMiddlewares($middleware)
    {
        $this->middlewares = $middleware;

        return $this;
    }

    /**
     * Get route attributes.
     *
     * @param  array  $merge
     *
     * @return array
     */
    protected function getAttributes(array $merge = [])
    {
        return array_merge([
            'prefix'     => $this->prefix,
            'as'         => $this->routeName,
            'middleware' => $this->middlewares,
            'namespace'  => $this->namespace,
        ], $merge);
    }

    /**
     * Set a global where pattern on all routes.
     *
     * @param  string  $key
     * @param  string  $pattern
     */
    public function pattern($key, $pattern)
    {
        $this->router->pattern($key, $pattern);
    }

    /**
     * Set a group of global where patterns on all routes.
     *
     * @param  array  $patterns
     */
    public function patterns($patterns)
    {
        $this->router->patterns($patterns);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Load attributes from config file.
     *
     * @param  string  $key
     * @param  array   $default
     */
    protected function loadAttributes($key, array $default = [])
    {
        $attributes = config($key, $default);

        if (isset($attributes['prefix']))
            $this->addPrefix($attributes['prefix']);

        if (isset($attributes['namespace']))
            $this->setNamespace($attributes['namespace']);

        if (isset($attributes['as']))
            $this->setRouteName($attributes['as']);

        if (isset($attributes['middleware']))
            $this->setMiddlewares($attributes['middleware']);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Route registration Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Register a new GET route with the router.
     *
     * @param  string                $uri
     * @param  Closure|array|string  $action
     *
     * @return \Illuminate\Routing\Route|void
     */
    public function get($uri, $action)
    {
        return $this->router->get($uri, $action);
    }

    /**
     * Register a new POST route with the router.
     *
     * @param  string                $uri
     * @param  Closure|array|string  $action
     *
     * @return \Illuminate\Routing\Route|void
     */
    public function post($uri, $action)
    {
        return $this->router->post($uri, $action);
    }

    /**
     * Register a new PUT route with the router.
     *
     * @param  string                $uri
     * @param  Closure|array|string  $action
     *
     * @return \Illuminate\Routing\Route|void
     */
    public function put($uri, $action)
    {
        return $this->router->put($uri, $action);
    }

    /**
     * Register a new PATCH route with the router.
     *
     * @param  string                 $uri
     * @param  \Closure|array|string  $action
     *
     * @return \Illuminate\Routing\Route|void
     */
    public function patch($uri, $action)
    {
        return $this->router->patch($uri, $action);
    }

    /**
     * Register a new DELETE route with the router.
     *
     * @param  string                $uri
     * @param  Closure|array|string  $action
     *
     * @return \Illuminate\Routing\Route|void
     */
    public function delete($uri, $action)
    {
        return $this->router->delete($uri, $action);
    }

    /**
     * Register a new OPTIONS route with the router.
     *
     * @param  string                 $uri
     * @param  \Closure|array|string  $action
     *
     * @return \Illuminate\Routing\Route|void
     */
    public function options($uri, $action)
    {
        return $this->router->options($uri, $action);
    }

    /**
     * Register a new route responding to all verbs.
     *
     * @param  string                 $uri
     * @param  \Closure|array|string  $action
     *
     * @return \Illuminate\Routing\Route|void
     */
    public function any($uri, $action)
    {
        return $this->router->any($uri, $action);
    }

    /**
     * Register a new route with the given verbs.
     *
     * @param  array|string           $methods
     * @param  string                 $uri
     * @param  \Closure|array|string  $action
     *
     * @return \Illuminate\Routing\Route|void
     */
    public function match($methods, $uri, $action)
    {
        return $this->router->match($methods, $uri, $action);
    }

    /**
     * Create a route group with shared attributes.
     *
     * @param  array    $attributes
     * @param  Closure  $callback
     */
    protected function group(array $attributes, Closure $callback)
    {
        $this->router->group($attributes, $callback);
    }

    /**
     * Route a resource to a controller.
     *
     * @param  string  $name
     * @param  string  $controller
     * @param  array   $options
     */
    protected function resource($name, $controller, array $options = [])
    {
        $this->router->resource($name, $controller, $options);
    }

    /**
     * Add a new route parameter binder.
     *
     * @param  string           $key
     * @param  string|callable  $binder
     */
    protected function bind($key, $binder)
    {
        $this->router->bind($key, $binder);
    }

    /**
     * Register a model binder for a wildcard.
     *
     * @param  string         $key
     * @param  string         $class
     * @param  \Closure|null  $callback
     */
    public function model($key, $class, Closure $callback = null)
    {
        $this->router->model($key, $class, $callback);
    }
}
