<?php

namespace App\Http\Middleware;

use App\Http\Helpers\TokenReader;
use Closure;
use JWTAuth;
use Exception;
use ReallySimpleJWT\Token;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class TokenControl extends BaseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            if (isset($request->token) && isset($request->tc)) {
                $read = new TokenReader();
                $tokenValidate = Token::validate($request->token, env('JWT_SECRET'));
                $token = $read->read($request->token, "", "");
                if ($token === true && $tokenValidate == true) {
                    return $next($request);
                } else {
                    return response()->json(array(['status' => "UNAUTHORIZED"]), 401, ['Content-type' => 'application/json; charset=utf-8']);
                }
            } else {
                return response()->json(array(['status' => "BadRequest"]), 400, ['Content-type' => 'application/json; charset=utf-8']);
            }
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 401);
        }

    }

}
