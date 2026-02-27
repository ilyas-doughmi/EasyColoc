<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckColocationMembership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $colocation = $request->route('colocation');

        if ($colocation && $request->user()) {
            $pivot = $colocation->User()->wherePivot('user_id', $request->user()->id)->first()?->pivot;

            if (!$pivot || $pivot->status !== 'active') {
                return redirect()->route('colocations.index')
                                 ->with('error', 'Vous n\'êtes pas membre actif de cette colocation.');
            }
        }

        return $next($request);
    }
}
