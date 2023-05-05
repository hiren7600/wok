<?php

namespace App\Http\Middleware;

use App\Models\BlockUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CheckBlockMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $currentuser = Auth::user()->user_id;

        $check_block_user = BlockUser::where('to_user_id',$currentuser)->where('user_id', $request->route('user_id'))->first();
        if (!empty($check_block_user)) {
            if($request->ajax()) {

                $data 		  = [];
                $data['type'] = 'success';
                $data['redirectUrl'] = url('profile/block/'.$request->route('user_id'));
                return response()->json($data);
            }else {
                return new RedirectResponse(url('profile/block/'.$request->route('user_id')));
            }
        }

        return $next($request);
    }
}
