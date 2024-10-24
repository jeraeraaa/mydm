<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\RegistersUsers;



// class RegisterController extends Controller
// {
//     public function showRegistrationForm()
//     {
//         return view('auth.register');
//     }

//     public function register(Request $request)
//     {
//         $request->validate([
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:users',
//             'password' => 'required|string|min:8|confirmed',
//         ]);

//         $user = User::create([
//             'name' => $request->name,
//             'email' => $request->email,
//             'password' => Hash::make($request->password),
//         ]);

//         Auth::login($user);

//         return redirect('/home');  // Redirect to the home page
//     }
// }

class RegisterController extends Controller
{
    use RegistersUsers;

    // Redirect user setelah registrasi
    protected $redirectTo = '/home';

    public function __construct()
    {
        $this->middleware('guest');
    }

    // Validator untuk validasi input register
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    // Buat user baru dan simpan ke database
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
