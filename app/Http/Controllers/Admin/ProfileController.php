<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Range;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
        $this->middleware('auth')->except('getConfigRangeJson');
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


    public function configRangePage()
    {
        $range = Range::find(1)->toArray();
        return view('range', ['range' => $range]);
    }

    public function saveConfigRange(Request $request)
    {
        $range = Range::find(1);
        $request->validate([
            'parah' => 'required|integer',
            'sedang' => 'required|integer',
            'rendah' => 'required|integer',
        ]);

        $formData = $request->all();
        $range->parah = $formData['parah'];
        $range->sedang = $formData['sedang'];
        $range->rendah = $formData['rendah'];
        $range->save();

        return back()->with("status", "Range Warna Legenda has been updated successfully!");
    }

    public static function getConfigRange(): array
    {
        $range = Range::find(1);

        return [
            'parah' => $range->parah,
            'sedang' => $range->sedang,
            'rendah' => $range->rendah,
        ];
    }
}
