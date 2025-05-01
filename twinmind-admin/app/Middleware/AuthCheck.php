<?php

namespace App\Middleware;

use Closure;

class AuthCheck {
    public function handle($request, Closure $next) {
        // Eğer kullanıcı giriş yapmamışsa ve istek signin/signup sayfaları dışındaysa
        if (
            !session()->has('user') &&
            !in_array($request->path(), ['auth/signin', 'auth/signup'])
        ) {
            return redirect('/auth/signin')->with('fail', 'Önce giriş yapmalısınız.');
        }

        // Eğer kullanıcı giriş yapmışsa ve signin/signup sayfalarına erişmeye çalışıyorsa
        if (
            session()->has('user') &&
            in_array($request->path(), ['auth/signin', 'auth/signup'])
        ) {
            return redirect('/');
        }

        return $next($request);
    }
}