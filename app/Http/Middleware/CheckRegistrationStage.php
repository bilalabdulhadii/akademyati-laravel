<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRegistrationStage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param string $stage
     */
    public function handle(Request $request, Closure $next, $stage): Response
    {
        $basicInfo = $request->session()->get('basic_info');
        $userId = $request->session()->get('user_id');

        if ($stage === 'role' && empty($basicInfo)) {
            return redirect()->route('register');
        }

        if ($stage === 'additional_info' && empty($userId)) {
            return redirect()->route('profile-type');
        }

        return $next($request);
    }
}
