<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\Store;
use Carbon\Carbon;

class SessionTimeout {

    protected $session;
    protected $timeout = 1200;

    public function __construct(Store $session) {
        $this->session = $session;
        $this->timeout = config('session.lifetime');
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $user = \Auth::User();
        if (!$this->session->has('lastActivityTime')) {
            $this->session->put('lastActivityTime', time());
        } else if (time() - $this->session->get('lastActivityTime') > $this->timeout) {
            $this->session->forget('lastActivityTime');
            Auth::logout();
            $time = $this->timeout / 60;
            return redirect()->route('login')->with(['warning' => 'Anda tidak melakukan aktivtas selama '.$time.' menit.']);
        }
        $this->session->put('lastActivityTime', time());
        return $next($request);
    }

}
