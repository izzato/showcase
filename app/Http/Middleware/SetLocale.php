<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Symfony\Component\Intl\Locale;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = Cookie::get('locale');

        if (Auth::check()
            && Auth::user()->settings()->has('locale')
        ) {
            $locale = Auth::user()->settings()->get('locale');
        }
        if ($locale) {
            if (! in_array($locale, array_merge(...array_values(config('locale.supported'))))) {
                $locale = config('locale.fallback')[$locale];
            }

            App::setLocale($locale);
            Locale::setDefault($locale);
            Session::put('locale', $locale);
        }

        return $next($request);
    }
}
