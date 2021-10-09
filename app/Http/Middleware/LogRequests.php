<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class LogRequests
{
    public function handle($request, Closure $next)
    {
        $request->start = microtime(true);
        return $next($request);
    }
    
    public function terminate($request, $response)
    {
        $endTime = microtime(true);
        $duration = ($endTime - LARAVEL_START) > 0 ? number_format($endTime - LARAVEL_START, 3, '.', '') : 0;
        $start = formatTimeWithMiliSecond(LARAVEL_START);
        $end = formatTimeWithMiliSecond($endTime);
        $routeArray = app('request')->route()->getAction();
        $controllerAction = class_basename($routeArray['controller']);
        list($controller, $action) = explode('@', $controllerAction);

        $log = "$controller\t".
            "$action\t".
            "$start\t" .
            "$end\t" .
            "$duration";

        if(env('APP_ENV') == 'production') {
            $this->time($duration, $log, config('common.TIME_WARNING_PRODUCTION'), config('common.TIME_CRITICAL_PRODUCTION'));
        } else {
            $this->time($duration, $log, config('common.TIME_WARNING_STAGING'), config('common.TIME_CRITICAL_STAGING'));
        }
    }

    protected function time($duration, $log, $timeWarning, $timeCritical) {
        if ($duration >= $timeCritical) {
            $log .= "\t Controller processing time critical exceeded";
            Log::critical($log);
        } elseif ($duration >= $timeWarning) {
            $log .= "\t Controller processing time exceeded";
            Log::warning($log);
        } else {
            Log::info($log);
        }
    }
}
