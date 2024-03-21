<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{   
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index()
    {
        $user = auth()->user();
        
        $data['admin'] = [
            'username' => $user->name,
            'email' => $user->email
        ];
        return view('profile', $data);
    }

    public function changePassword(Request $request)
    {        
        $request->validate([
            'newPassword' => 'required'            
        ]);

        $formData = $request->all();
        $user = auth()->user();
        

        User::where('email', $user->email)->update([
            'password' => Hash::make($formData['newPassword'])
        ]);

        return back()->with("status", "Password changed successfully!");   
    }
}
