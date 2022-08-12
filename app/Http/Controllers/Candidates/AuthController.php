<?php

namespace App\Http\Controllers\Candidates;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Site\ThemeMethods;
use App\Traits\Site\CandidateMethods;

use App\Models\Employe;
use App\Models\User;

class AuthController extends Controller
{
    use ThemeMethods;
    use CandidateMethods;

    public function login($name=null)
    {
        $register_route = '';
        if($name == 'register'){
            $register_route = "register";
        }
        return $this->client_view('candidates.auth.login', ['register_route' => $register_route]);
    }
    protected function register(Request $request)
    {
        
        $data = $request->validate([
            'first_name' => 'required|string|max:50',
            'middle_name' => 'nullable|string|max:20',
            'last_name' => 'required|string|max:50',
            'email' => 'required:|unique:users|max:50',
            'password' => 'required|confirmed|min:8',
        ]);
        $fields = [];
        $fields['email'] = $data['email'];
        $fields['password'] = \Hash::make($data['password']);
        $fields['user_type'] = "candidate";
        $user = User::create($fields);
        $employe = Employe::create([
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'],
            'last_name' => $data['last_name'],
            'user_id' => $user->id,
        ]);
        return $this->loginAttempt([
            "email" => $data['email'],
            "password" => $data['password']
        ]);
    }
    private function loginAttempt($credentials)
    {
        if (\Auth::attempt($credentials)) {
            return redirect()->route('candidate.dashboard');
        }
        return redirect()->back()->withErrors(['message' => 'Invalid credentials']);
    }
    private function logout()
    {
        \Auth::logout();
        return redirect()->route('/candidate/login');
    }
}
