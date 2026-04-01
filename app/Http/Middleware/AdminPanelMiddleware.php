<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AdminPanelMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if($user === null){
            Log::debug('Неавторизованный пользователь попытался зайти в панель администратора');
            return redirect('/admin');
        }

        if(in_array($user->group_role, [User::ROLE_GUEST, User::ROLE_BANNED])){
            Log::debug('Заблокированный пользователь или гость попытался пройти на недоступную ему страницу');
            Auth::logout();
            return redirect('/admin');
        }

        if($user->group_role == User::ROLE_CLIENT)
            return redirect('/');

        return $next($request);
    }
}
