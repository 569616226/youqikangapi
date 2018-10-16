<?php

namespace App\Containers\Company\Middlewares;

use Apiato\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Middlewares\Middleware;
use Closure;
use Illuminate\Http\Request;

/**
 * Class WebAuthentication
 *
 * @author  Mahmoud Zalt  <mahmoud@zalt.me>
 */
class UserAuthentication extends Middleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        if (\Auth::user()->is_client) {

            return response()->json(['msg' => '接口认证失败'], 401);
        }

        return $next($request);
    }
}
