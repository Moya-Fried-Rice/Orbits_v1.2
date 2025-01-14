<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{

    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            // Check if the user is authenticated
            $user = $request->user();

            if (!$user) {
                // Log the error for debugging
                Log::error('Unauthenticated user attempted to access protected route.', ['ip' => $request->ip()]);
                
                // Abort with 401 Unauthorized if the user is not authenticated
                abort(401, 'Unauthenticated');
            }

            // Check if the user has one of the allowed roles
            if (!in_array($user->role_id, $roles)) {
                // Log the error for debugging
                Log::warning('Access denied for user with insufficient role.', ['user_id' => $user->id, 'role' => $user->role_id, 'ip' => $request->ip()]);
                
                // Abort with 403 Forbidden if the user does not have one of the allowed roles
                abort(403, 'Access denied');
            }

            // Proceed to the next middleware if all checks pass
            return $next($request)
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
            
        } catch (\Exception $e) {
            // Log the exception message and stack trace for debugging
            Log::error('An error occurred while handling the request.', [
                'error_message' => $e->getMessage(),
                'stack_trace' => $e->getTraceAsString(),
                'ip' => $request->ip(),
            ]);
            
            // Abort with a 500 Internal Server Error if an exception occurs
            abort(500, 'Internal Server Error');
        }
    }
}
