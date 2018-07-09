<?php

namespace App\Http\Middleware;

use Closure;

class HttpsProtocol {

    public function handle($request, Closure $next)
    {
    	$setting = \App\Library\Setting::loadconfig();

        if (!$request->secure() && (isset($setting['issecure']) && $setting['issecure'])) {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request); 
    }
}