<?php

namespace App\Http\Controllers\Auth;
use App\Models\Users;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Hash;
use Request;
use Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    public function login()
    {

        if(Request::has('username')){
            //echo 'cai meo';exit();
            $rules = array(
                'username'    => 'required',
                'password' => 'required|alphaNum|min:1'
            );
            $uri = Request::path();
            $this->redirectTo =$uri;
            $validator = Validator::make(Input::all(), $rules);
            if ($validator->fails()) {
                return Redirect::to($uri)
                    ->withErrors($validator)
                    ->withInput(Input::except('password'));
            }else{
                $userdata = array(
                    'phone'     => Input::get('username'),
                    'password'  => Input::get('password'),
                    'status' =>'Actived'
                );
                if (Auth::attempt($userdata)) {
                    return Redirect::to("admin/dashboard");
                }
                else {
                    return Redirect::to($uri);

                }
            }
        }
        return view('Admin.Dashboard.login');
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/');

    }

    public function loginFrontend()
    {
        if (!Auth::check()) {
            if(Request::has('phone')){
                $userData = array(
                    'phone'     => Input::get('phone'),
                    'password'  => Input::get('password'),
                    'status' =>'Actived'
                );
                $checkPhone = Users::where('phone', $userData['phone'])->first();
                if (count($checkPhone) == 0) {
                    return response()->json([
                        'status' => false,
                        'message' => 'phone_not_exit'
                    ]);
                } else {
                    if (Auth::attempt($userData)) {
                        return response()->json([
                            'status' => true,
                            'message' => 'Login success'
                        ]);
                    } else {
                        return response()->json([
                            'status' => false,
                            'message' => 'wrong_password'
                        ]);
                    }
                }
            }
        }
    }
}
