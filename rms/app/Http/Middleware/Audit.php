<?php

namespace App\Http\Middleware;

use Closure;

class Audit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //1 for local machine 2 for msts_rms
        if($request->segment(1) != 'data' && $request->segment(2) != 'data') {
            \App\Audit::create([
                'url' => $request->fullUrl() != '' ? $request->fullUrl() : '',
                'method' => $request->method(),
                'ip' => $request->ip(),
                'user_id' => !auth()->guest() ? auth()->user()->id : null,
                'guard' => check_guard(),
                'request_json' => $request->segment(1) == 'data' ? '["data":"data_table_requests"]' : json_encode($request->all()),
            ]);
        }

        return $next($request);
    }

}
