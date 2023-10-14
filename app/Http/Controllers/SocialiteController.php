<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{

    //GITHUB
//    public function githubredirect()
//    {
//        return Socialite::driver('github')->redirect();
//    }
//
//    public function githubcallback()
//    {
//        try {
//            $user = Socialite::driver('github')->user();
//
////            dd($user);
//            $github_user = User::updateOrCreate([
//                'github_id' => $user->id
//            ], [
//                'name' => $user->nickname,
//                'nickname' => $user->nickname,
//                'auth_type' => 'github',
//                'email' => $user->email,
//                'github_token'=>$user->token,
//                'password'=>Hash::make(Str::random(10))]);
//
//            Auth::login($github_user);
//           return redirect('/dashboard');
//
//        } catch (Exception $e) {
//          dd($e);
//        }
//    }
//
//    // GOOGLE
//
//    public function googleredirect()
//    {
//        return Socialite::driver('google')->redirect();
//    }
//
//    public function googlecallback()
//    {
//        try {
//            $user = Socialite::driver('google')->user();
//
////            dd($user);
//            $google_user = User::updateOrCreate([
////                should be social id or something
//                'github_id' => $user->id
//            ], [
//                'name' => $user->name,
////                'nickname' => $user->nickname,
//                'auth_type' => 'google',
//                'email' => $user->email,
////                'github_token'=>$user->token,
//                'password'=>Hash::make(Str::random(10))]);
//
//            Auth::login($google_user);
//            return redirect('/dashboard');
//
//        } catch (Exception $e) {
//            dd($e);
//        }
//    }


    // ONE CODE

    public function redirect($provider){

        return Socialite::driver($provider)->redirect();

    }

    public function callback($provider){

        try {
            $user = Socialite::driver($provider)->stateless()->user();
//            dd($provider);
            if(User::where('email',$user->getEmail())->exists() &&
                !User::where('email', $user->getEmail())->where('provider', $provider)->exists()
                ) {
                return redirect('login')->withErrors(['email'=>'Account with this email already registered']);
            }
            $social_user = User::updateOrCreate([
//         in user migration should be provider_id table or something
                'provider_id' => $user->id,
                'email'=>$user->email,
            ], [
                //  in user migration should be provider table
                'provider' => $provider,
                'name' => $user->name ?? $user->nickname,
//                'nickname' => $user->nickname,
                'email' => $user->email,
//                'github_token'=>$user->token,
                'provider_token'=>$user->token,
                'password'=>Hash::make(Str::random(10)),
                'email_verified_at'=>now()
            ]);


            Auth::login($social_user);
            return redirect('/dashboard');
        } catch (Exception $e){
            dd($e);
        }


    }
}
