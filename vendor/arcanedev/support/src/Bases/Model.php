<?php namespace Arcanedev\Support\Bases;

use Arcanedev\Support\Traits\PrefixedModel;
use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class     Model
 *
 * @package  Arcanedev\Support\Laravel
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Model extends Eloquent
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use PrefixedModel;

    /* ------------------------------------------------------------------------------------------------
     |  Other Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get the attributes that have been changed since last sync.
     *
     * @return array
     */
    public function getDirty()
    {
        $dirty    = [];
        $original = $this->getCastedOriginal();

        foreach ($this->attributes as $key => $value) {
            if ($this->hasCast($key, $value)) {
                $value = $this->castAttribute($key, $value);
            }

            if (
                ! array_key_exists($key, $original) ||
                ($value !== $original[$key] && ! $this->originalIsNumericallyEquivalent($key))
            ) {
                $dirty[$key] = $value;
            }
        }

        return $dirty;
    }

    /**
     * Get the casted original attributes.
     *
     * @return array
     */
    protected function getCastedOriginal()
    {
        $original = [];

        foreach ($this->original as $key => $value) {
            $original[$key] = $this->hasCast($key) ? $this->castAttribute($key, $value) : $value;
        }

        return $original;
    }
}
