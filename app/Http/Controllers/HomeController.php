<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(Auth::user()->hasRole('admin')){
            return redirect()->route('admin.dashboard');
        }
        if(Auth::user()->hasRole('agent')){
            return redirect()->route('agent.dashboard');
        }
    }
    /**
     * agent Change Password
     * @param Request $request
     */
    public function changePassword(Request $request){

        $user = Auth::user();

       $request->validate([
            'current_password' => 'required|string|min:6',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
       ]);

        if($request->id !== $user->id){
            return response()->json([
                'errors' => [
                    'current_password' => ['no permission to edit password']
                ]
            ], 401);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'errors' => [
                    'current_password' => ['Incorrect Current Password']
                ]
            ], 401);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'message' =>'success'
        ], 200);
    }
}
