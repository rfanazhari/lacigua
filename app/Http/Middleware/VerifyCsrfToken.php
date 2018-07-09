<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Closure;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */

    protected $dontReport = [
        HttpException::class,
        ModelNotFoundException::class,
        // opt from logging this error to your log files (optional)
        TokenMismatchException::class,
    ];

    public function handle($request, Closure $next)
    {
        $except = [];

        $dh = base_path().'\\app\Http\Controllers';
        if(!(strpos(PHP_OS, 'WIN') !== false)) $dh = str_replace('\\', '/', $dh);

        if ($dh = opendir($dh)) {
            while (($file = readdir($dh)) !== false) {
                if(strpos($file, 'Controller.php') !== false && $file != 'Controller.php') {
                    $except[] = str_replace('Controller.php', '', $file);
                    $except[] = str_replace('Controller.php', '', $file).'/*';
                }
            }
            closedir($dh);
        }

        $dh = base_path().'\\app\Modules';
        if(!(strpos(PHP_OS, 'WIN') !== false)) $dh = str_replace('\\', '/', $dh);

        if ($dh = opendir($dh)) {
            while (($file = readdir($dh)) !== false) {
                if(!in_array($file, ['.', '..', 'frontend'])) {
                    $except[] = $file;
                    $except[] = $file.'/*';
                }
            }
            closedir($dh);
        }

        $setting = \App\Library\Setting::loadconfig();
        array_walk($except, function(&$value, $key) use ($setting) { $value = $setting['backend']['aliaspage'].$value; });
        
        if(isset($setting['fdevelopment']['status']) && $setting['fdevelopment']['status']) {
            $except[] = '';
            $except[] = '/*';
        }

        $regex = '#' . implode('|', $except) . '#';
        
        if ($this->isReading($request) || $this->tokensMatch($request) || preg_match($regex, $request->path()))
        {
            return $this->addCookieToResponse($request, $next($request));
        }

        return \Redirect::back()->withError('Sorry, we could not verify your request. Please try again.');
    }
}
