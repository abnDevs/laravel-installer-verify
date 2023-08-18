<?php
namespace AbnDevs\Installer\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RedirectIfInstalledMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Storage::disk('local')->exists('installed')) {
            return redirect()->route('login');
        }

        return $next($request);
    }
}
