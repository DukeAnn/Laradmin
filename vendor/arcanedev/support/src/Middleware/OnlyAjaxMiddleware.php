<?php namespace Arcanedev\Support\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Class     OnlyAjaxMiddleware
 *
 * @package  Arcanedev\Support\Middleware
 * @author   ARCANEDEV <arcanedev.maroc@gmail.com>
 */
class OnlyAjaxMiddleware
{
    /* ------------------------------------------------------------------------------------------------
     |  Main Functions
     | ------------------------------------------------------------------------------------------------
     */
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure                  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->ajax() || $request->wantsJson()) {
            return $next($request);
        }

        return response('Method not allowed', 405);
    }
}
