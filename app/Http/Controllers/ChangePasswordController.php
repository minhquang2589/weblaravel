<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class ChangePasswordController extends Controller
{
    //
    public function index()
    {
        return view('auth.changepassword');
    }
    //
    public function change(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string|min:8',
            'new_password' => 'required|string|min:8|different:current_password',
            'confirm_password' => 'required|string|same:new_password',
        ]);
        $user = Auth::user();
        try {
            DB::beginTransaction();

            if (!Hash::check($request->current_password, $user->password)) {
                throw ValidationException::withMessages(['current_password' => 'The provided password does not match your current password.']);
            }
            $user->password = Hash::make($request->new_password);
            $user->save();
            DB::commit();
            Session::flash('success', 'Your password has been changed successfully!');
            return view('layout.confirmok');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors([$e->getMessage()]);
        }
    }
}
