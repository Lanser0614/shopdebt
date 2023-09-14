<?php

namespace App\Http\Middleware;

use App\Constants\RolesEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->user()->hasRole(RolesEnum::OWNER->value)){
            return response([
                'message' => 'Access denied',
                'success' => false
            ], 403);
        }
        return $next($request);
    }
}
