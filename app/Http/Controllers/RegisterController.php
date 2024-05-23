<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    //
    public function index()
    {
        return view('auth.register');
    }
    //
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|regex:/^\d{10}$/',
            'birthday' => 'required|date',
            'gender' => 'required|in:Male,Female',
            'password' => 'required|string|min:8',
            'address' => 'nullable|string|max:255',
        ]);
        if ($validator->fails()) {
            return redirect()->route('register')->withErrors($validator)->withInput();
        }
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            $data = [
                'email' => $request->email,
                'message' => 'This email has already been taken. Please use or click forgot password!',
            ];
            return redirect()->route('login')->with('existingUser', $data);
        }
        try {
            DB::beginTransaction();

        $user = new User();
        $user->name = $request->fullname;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->genders = $request->gender;
        $user->birthday = $request->birthday;
        $user->password = Hash::make($request->password);
        $user->address = $request->address;
        $user->save();
        Auth::login($user);
        DB::commit();
        return redirect()->route('login')->with('success', 'Your account has been registered successfully! Please log in.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('register')->withErrors([$e->getMessage()])->withInput();
        }
    }
}
