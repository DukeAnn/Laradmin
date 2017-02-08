<?php namespace Arcanedev\Support;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Filesystem\Filesystem;
use JsonSerializable;

/**
 * Class     Json
 *
 * @package  Arcanedev\Support
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Json implements Arrayable, Jsonable, JsonSerializable
{
    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The file path.
     *
     * @var string
     */
    protected $path;

    /**
     * The laravel filesystem instance.
     *
     * @var Filesystem
     */
    protected $filesystem;

    /**
     * The attributes collection.
     *
     * @var Collection
     */
    protected $attributes;

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Construct the Json instance.
     *
     * @param  mixed       $path
     * @param  Filesystem  $filesystem
     */
    public function __construct($path, Filesystem $filesystem = null)
    {
        $this->path         = (string) $path;
        $this->filesystem   = $filesystem ?: new Filesystem;
        $this->attributes   = Collection::make($this->getAttributes());
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the filesystem instance.
     *
     * @return Filesystem
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * Set the filesystem instance.
     *
     * @param  Filesystem  $filesystem
     *
     * @return self
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set path.
     *
     * @param  mixed  $path
     *
     * @return self
     */
    public function setPath($path)
    {
        $this->path = (string) $path;

        return $this;
    }

    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Make new instance.
     *
     * @param  string      $path
     * @param  Filesystem  $filesystem
     *
     * @return static
     */
    public static function make($path, Filesystem $filesystem = null)
    {
        return new static($path, $filesystem);
    }

    /**
     * Get file content.
     *
     * @return string
     */
    public function getContents()
    {
        return $this->filesystem->get($this->getPath());
    }

    /**
     * Update json contents from array data.
     *
     * @param  array  $data
     *
     * @return bool
     */
    public function update(array $data)
    {
        $this->attributes = new Collection(array_merge(
            $this->attributes->toArray(),
            $data
        ));

        return $this->save();
    }

    /**
     * Handle call to __call method.
     *
     * @param  string  $method
     * @param  array   $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments = [])
    {
        return method_exists($this, $method)
            ? call_user_func_array([$this, $method], $arguments)
            : $this->attributes->get($method);
    }

    /**
     * Handle magic method __get.
     *
     * @param  string  $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Get the specified attribute from json file.
     *
     * @param  string      $key
     * @param  mixed|null  $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->attributes->get($key, $default);
    }

    /**
     * Set a specific key & value.
     *
     * @param  string  $key
     * @param  mixed   $value
     *
     * @return self
     */
    public function set($key, $value)
    {
        $this->attributes->offsetSet($key, $value);

        return $this;
    }

    /**
     * Save the current attributes array to the file storage.
     *
     * @return bool
     */
    public function save()
    {
        return $this->filesystem->put($this->getPath(), $this->toJsonPretty());
    }

    /**
     * Get file contents as array.
     *
     * @return array
     */
    public function getAttributes()
    {
        return json_decode($this->getContents(), true);
    }

    /**
     * Convert the given array data to pretty json.
     *
     * @param  array  $data
     *
     * @return string
     */
    public function toJsonPretty(array $data = null)
    {
        return json_encode($data ?: $this->attributes, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
    }

    /**
     * Handle call to __toString method.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getContents();
    }

    /**
     * Convert to array.
     *
     * @return array
     */
    public function toArray()
    {
        return $this->getAttributes();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * Allow to encode the json object to json file.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }
}
