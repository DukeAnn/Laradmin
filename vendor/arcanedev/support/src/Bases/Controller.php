<?php namespace Arcanedev\Support\Bases;

use Arcanedev\Support\Traits\Abortable;
use Illuminate\Routing\Controller as IlluminateController;

/**
 * Class     Controller
 *
 * @package  Arcanedev\Support\Bases
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
abstract class Controller extends IlluminateController
{
    /* ------------------------------------------------------------------------------------------------
     |  Traits
     | ------------------------------------------------------------------------------------------------
     */
    use Abortable;

    /* ------------------------------------------------------------------------------------------------
     |  Properties
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * The view data.
     *
     * @var array
     */
    protected $data         = [];

    /* ------------------------------------------------------------------------------------------------
     |  Constructor
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Instantiate the controller.
     */
    public function __construct()
    {
        $this->setCurrentPage();
    }

    /* ------------------------------------------------------------------------------------------------
     |  Getters & Setters
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Get data.
     *
     * @return array
     */
    protected function getData()
    {
        return $this->data;
    }

    /**
     * Set view data.
     *
     * @param  string|array  $name
     * @param  mixed         $value
     *
     * @return self
     */
    protected function setData($name, $value = null)
    {
        if (is_array($name)) {
            $this->data = array_merge($this->data, $name);
        }
        elseif (is_string($name)) {
            $this->data[$name]  = $value;
        }

        return $this;
    }

    /**
     * Set the current page.
     *
     * @param  string  $page
     *
     * @return self
     */
    protected function setCurrentPage($page = '')
    {
        return $this->setData('current_page', $page);
    }

    /* ------------------------------------------------------------------------------------------------
     |  Check Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Check if the Request is an ajax Request.
     *
     * @return bool
     */
    protected static function isAjaxRequest()
    {
        return request()->ajax();
    }

    /**
     * Accepts only ajax request.
     *
     * @param  string  $message
     * @param  array   $headers
     */
    protected static function onlyAjax($message = 'Access denied !', array $headers = [])
    {
        if ( ! self::isAjaxRequest()) {
            self::accessNotAllowed($message, $headers);
        }
    }
}
