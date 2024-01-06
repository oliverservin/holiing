<?php

namespace App\Http\Middleware;

use App\Models\Domain;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomDomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $domain = $request->header('LinksPageHost');
        $domain = Domain::where('name', $domain)->orWhere('name', $request->getHost())->firstOrFail();

        $request->merge([
            'domain' => $domain,
        ]);

        return $next($request);
    }
}
