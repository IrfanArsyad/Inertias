<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Module;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  $module  Module name or ID
     * @param  string  $action  Action: read, create, update, delete
     */
    public function handle(Request $request, Closure $next, string $module, string $action = 'read'): Response
    {
        $user = $request->user();

        // If not authenticated, redirect to login
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if user has permission
        if (!$user->canAccess($action, $module)) {
            // For AJAX/Inertia requests, return 403
            if ($request->expectsJson() || $request->header('X-Inertia')) {
                abort(403, 'You do not have permission to access this resource.');
            }

            // For regular requests, redirect with error
            return redirect()->back()->with('error', 'You do not have permission to access this resource.');
        }

        return $next($request);
    }
}
