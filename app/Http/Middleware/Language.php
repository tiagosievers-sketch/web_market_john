<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;

class Language
{
    public function __construct(Application $app, Request $request) {
        $this->app = $app;
        $this->request = $request;
    }
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
{
    // Verifica se o 'locale' está presente na URL
    if ($request->has('locale')) {
        // Define o idioma com base no parâmetro 'locale' da URL
        $this->app->setLocale($request->input('locale'));

        // Armazena o idioma na sessão para persistir em futuras requisições
        session(['my_locale' => $request->input('locale')]);
    } else {
        // Caso não tenha o parâmetro 'locale', usa o valor da sessão ou o padrão
        $this->app->setLocale(session('my_locale', config('app.locale')));
    }

    // Se o usuário estiver autenticado, atualiza o idioma preferido dele
    $user = Auth::user();
    if ($user) {
        $user->update([
            'preferred_language' => $this->app->getLocale(),
        ]);
    }

    return $next($request);
}

}
