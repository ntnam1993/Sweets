<?php

namespace App\Http\Middleware;

use App\Region;
use Closure;

class EparkSearch
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $regionSlug = $request->route('region');

        // check if this region slug exists
        if ($regionSlug) {
            $isRegionExists = Region::where('slug', $regionSlug)->exists();
            if (!$isRegionExists) {
                abort(404);
            }
        }
        return $next($request);
    }
}
