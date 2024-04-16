<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // $headers = [
        //  'Access-Control-Allow-Methods'=> 'POST, GET, OPTIONS, PUT, DELETE, PATCH',
        //  'Access-Control-Allow-Headers'=> 'Content-Type, X-Auth-Token, Origin',
        //  'Access-Control-Allow-Origin' => '*'
        // ];
        // if($request->getMethod() == "OPTIONS") {

        //  return response()->make('OK', 200, $headers);
        // }
        // $response = $next($request);
        // foreach($headers as $key => $value)
        //  $response->header($key, $value);
        // return $response;

        $response = $next($request);
        if(isset($response->headers)) {
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application');
        }

        return $response;
    }
}
