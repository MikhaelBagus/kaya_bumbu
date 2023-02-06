<?php

namespace App\Http\Middleware;

use App\Models\Auth\Role;
use Cartalyst\Sentinel\Hashing\BcryptHasher;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Closure;

class SentinelPermission {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @param                           $role
     *
     * @return mixed
     */
	public function handle( $request, Closure $next, $role ) {

        Sentinel::setHasher( new BcryptHasher() );

        $user = Sentinel::check();

        if ( ! $user ) {
            return redirect()->guest( '/login' );
        }

        if (isset($user->roles[0]) && $user->roles[0]->slug == 'root') {
            return $next($request);
        }

        if ( $user->roles[0]->hasAccess( $role ) ) {
            return $next( $request );
        }

        if ( $request->ajax() || $request->wantsJson() ) {
            return response( trans( 'backpack::base.unauthorized' ), 401 );
        }

        #return abort(404, 'Unauthorized action.');
        return redirect( 'no-access' );
	}
}
