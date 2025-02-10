<?php

namespace App\Http\Middleware;

use App\Models\Tenant;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RememberTenantMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next) : Response
    {
        // Get the current tenant from url
        $tenant = $request->route('tenant');
        $tenantId = Tenant::where('code', $tenant)->first()->id;

        if (Auth::check() && Auth::user()->current_tenant_id !== $tenantId) {
            // Store the current tenant in the user's latest_tenant_id column.
            Auth::user()->update(['latest_tenant_id' => $tenantId]);
        }

        // Continue processing the request.
        return $next($request);
    }
}
