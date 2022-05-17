<?php

namespace App\Http\Middleware;
use Closure;

class API
{
    public function handle($request, Closure $next) {
        if ($_SERVER['HTTP_API_KEY'] != 'BA673A414C3B44C98478BB5CF10A0F832574090C') {
            return response()->json(['message' => 'Unauthorised']);
        }
        return $next($request);
    }
}
