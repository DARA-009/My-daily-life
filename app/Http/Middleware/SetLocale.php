<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $supportedLocales = ['km', 'en'];

        if (Session::has('locale') && in_array(Session::get('locale'), $supportedLocales)) {
            App::setLocale(Session::get('locale'));
        } elseif (Auth::check() && Auth::user()->settings && in_array(Auth::user()->settings->locale, $supportedLocales)) {
            $locale = Auth::user()->settings->locale;
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            App::setLocale(config('app.locale', 'km'));
        }

        return $next($request);
    }
}
