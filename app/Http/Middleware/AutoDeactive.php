<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AutoDeactive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role == 'user') {
            $user = auth()->user();

            $activatedTill = $user->activated_till ? Carbon::parse($user->activated_till) : Carbon::parse($user->created_at)->addYear();;

            $currentDate = Carbon::now();
            $difference = $currentDate->diffInDays($activatedTill, false);

            if ($difference <= 0) {
                $user->is_active = 1;
                $user->save();
            }
        }

        return $next($request);
    }
}
