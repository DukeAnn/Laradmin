<?php namespace Arcanedev\Support;

use Arcanedev\Support\Exceptions\PackageException;

/**
 * Class     PackageServiceProvider
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class PackageServiceProvider extends ServiceProvider
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Vendor name.
     *
     * @var string
     */
    protected $vendor       = 'arcanedev';

    /**
     * Package name.
     *
     * @var string
     */
    protected $package      = '';

    /**
     * Package base path.
     *
     * @var string
     */
    protected $basePath     = '';

    /**
     * Merge multiple config files into one instance (package name as root key)
     *
     * @var bool
     */
    protected $multiConfigs = false;

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the base path of the package.
     *
     * @return string
     */
    abstract public function getBasePath();

    /**
     * Get config folder.
     *
     * @return string
     */
    protected function getConfigFolder()
    {
        return realpath($this->getBasePath() . DS .'config');
    }

    /**
     * Get config key.
     *
     * @return string
     */
    protected function getConfigKey()
    {
        return str_slug($this->package);
    }

    /**
     * Get config file path.
     *
     * @return string
     */
    protected function getConfigFile()
    {
        return $this->getConfigFolder() . DS . "{$this->package}.php";
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Boot the service provider.
     */
    public function boot()
    {
        parent::boot();

        $this->checkPackageName();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Package Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Setup package path and stuff.
     */
    protected function setup()
    {
        $this->checkPackageName();
        $this->registerConfig();
    }

    /**
     * Register configs.
     *
     * @param  string  $separator
     */
    protected function registerConfig($separator = '.')
    {
        if ($this->multiConfigs)
            $this->registerMultipleConfigs($separator);
        else
            $this->mergeConfigFrom($this->getConfigFile(), $this->getConfigKey());
    }

    /**
     * Register all package configs.
     *
     * @param  string  $separator
     */
    private function registerMultipleConfigs($separator = '.')
    {
        foreach (glob($this->getConfigFolder() . '/*.php') as $configPath) {
            $this->mergeConfigFrom(
                $configPath,
                $this->getConfigKey() . $separator . basename($configPath, '.php')
            );
        }
    }

    /**
     * Register commands service provider.
     *
     * @param  \Illuminate\Support\ServiceProvider|string  $provider
     */
    protected function registerCommands($provider)
    {
        if ($this->app->runningInConsole())
            $this->app->register($provider);
    }

    /**
     * Publish the config file.
     */
    protected function publishConfig()
    {
        $this->publishes([
            $this->getConfigFile() => config_path("{$this->package}.php"),
        ], 'config');
    }

    /**
     * Publish the migration files.
     */
    protected function publishMigrations()
    {
        if (is_dir($path = ($this->getBasePath() . '/database/migrations/'))) {
            $this->publishes([
                $path => database_path('migrations'),
            ], 'migrations');
        }
    }

    /**
     * Publish and load the views if $load argument is true.
     *
     * @param  bool  $load
     */
    protected function publishViews($load = true)
    {
        if (is_dir($path = ($this->getBasePath() . '/resources/views'))) {
            $this->publishes([
                $path => base_path("resources/views/vendor/{$this->package}"),
            ], 'views');

            if ($load) $this->loadViews();
        }
    }

    /**
     * Publish and load the translations if $load argument is true.
     *
     * @param  bool  $load
     */
    protected function publishTranslations($load = true)
    {
        if (is_dir($path = ($this->getBasePath() . '/resources/lang'))) {
            $this->publishes([
                $path => base_path("resources/lang/vendor/{$this->package}"),
            ], 'lang');

            if ($load) $this->loadTranslations();
        }
    }

    /**
     * Publish the factories.
     */
    protected function publishFactories()
    {
        if (is_dir($path = ($this->getBasePath() . '/database/factories'))) {
            $this->publishes([
                $path => database_path('factories'),
            ], 'factories');
        }
    }

    /**
     * Publish all the package files.
     *
     * @param  bool  $load
     */
    protected function publishAll($load = true)
    {
        $this->publishConfig();
        $this->publishMigrations();
        $this->publishViews($load);
        $this->publishTranslations($load);
        $this->publishFactories();
    }

    /**
     * Load the views files.
     */
    protected function loadViews()
    {
        $this->loadViewsFrom($this->getBasePath() . '/resources/views', $this->package);
    }

    /**
     * Load the translations files.
     */
    protected function loadTranslations()
    {
        $this->loadTranslationsFrom($this->getBasePath() . '/resources/lang', $this->package);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check package name.
     *
     * @throws PackageException
     */
    private function checkPackageName()
    {
        if (empty($this->package) || empty($this->package)) {
            throw new PackageException('You must specify the vendor/package name.');
        }
    }

    /**
     * Check if has the base config.
     *
     * @return bool
     */
    protected function hasPackageConfig()
    {
        return $this->getConfigFile() !== false;
    }
}
