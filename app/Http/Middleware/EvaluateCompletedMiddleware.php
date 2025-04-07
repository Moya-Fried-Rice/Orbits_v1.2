<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserEvaluation;

class EvaluateCompletedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uuid = $request->route('uuid');
        
        // Check if the evaluation exists
        $evaluation = UserEvaluation::where('uuid', $uuid)->first();
        
        // If the evaluation is already completed, redirect back to the evaluation page
        if ($evaluation && $evaluation->is_completed) {
            return redirect()
                ->route('evaluation')
                ->with('info', 'This evaluation has already been completed.');
        }
        
        return $next($request);
    }
}
