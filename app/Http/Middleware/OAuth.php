<?php

namespace App\Http\Middleware;

use Closure;

class OAuth
{
    public function handle($request, Closure $next)
    {
        $ss = \Session::all();

        if(!str_contains($request->route()->getName(), 'generated')
            && $request->route()->getName() != 'logout'
            && $request->route()->getName() != 'index'
            && $request->route()->getName() != 'login'
            && $request->route()->getName() != 'loginExe'
        ){
            if(isset($ss['login'])){
                if($ss['userRole'] == 'tender' && $request->route()->uri == 'tender/submission-form/{id}' && $request->route()->id == $ss['userTender']){
                    return $next($request);
                } else if($ss['userRole'] == 'superadmin') {
                    return $next($request);
                } else return redirect('/tender/submission-form/'.$ss['userTender']);
            } else return abort(401);
        } else {
            if(
                $request->route()->getName() == 'index'
                || $request->route()->getName() == 'logout'
                || $request->route()->getName() == 'loginExe'
                || $request->route()->getName() == 'login'
            ) return $next($request);
            else if(!isset($ss['login']) || !$ss['login']) return redirect('/');
            else return $next($request);
        }

    }
}
