<?php namespace Arcanedev\Support;

use Illuminate\Support\Collection as IlluminateCollection;

/**
 * Class     Collection
 *
 * @package  Arcanedev\Support
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class Collection extends IlluminateCollection
{
    /* ------------------------------------------------------------------------------------------------
     |  Custom Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Return only unique items from the collection array.
     *
     * @param  string|callable|null  $key
     * @param  bool                  $strict
     *
     * @return static
     */
    public function unique($key = null, $strict = false)
    {
        if (is_null($key))
            return new static(array_unique($this->items, SORT_REGULAR));

        $key    = $this->valueRetriever($key);
        $exists = [];

        return $this->reject(function ($item) use ($key, $strict, &$exists) {
            if (in_array($id = $key($item), $exists, $strict)) {
                return true;
            }
            $exists[] = $id;
        });
    }

    /**
     * Return only unique items from the collection array using strict comparison.
     *
     * @param  string|callable|null  $key
     *
     * @return static
     */
    public function uniqueStrict($key = null)
    {
        return $this->unique($key, true);
    }

    /**
     * Reset the collection.
     *
     * @return static
     */
    public function reset()
    {
        $this->items = [];

        return $this;
    }
}
