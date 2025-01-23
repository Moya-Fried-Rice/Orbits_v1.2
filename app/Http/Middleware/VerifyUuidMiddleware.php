<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyUuidMiddleware
{
    protected $model;

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $model): Response
    {
        $uuid = $request->route('uuid');

        // Check if the model exists
        if (!class_exists($model) || !app($model)->where('uuid', $uuid)->exists()) {
            abort(404, 'Resource not found.');
        }

        return $next($request);
    }
}
