<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
class MrlAuth {
 public function handle(Request $request, Closure $next) {
   $token=$request->bearerToken();
   $user=$token ? User::where('api_token',$token)->first() : null;
   if(!$user) return response()->json(['message'=>'Unauthenticated'],401);
   $request->attributes->set('mrl_user',$user);
   return $next($request);
 }
}
