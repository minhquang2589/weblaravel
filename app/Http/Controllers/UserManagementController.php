<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class UserManagementController extends Controller
{
    //
    public function index()
    {
        // $users = User::all();
        $users = User::paginate(6);
        return view('dataview.user', ['users' => $users]);
    }
    // 
    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user->is_admin) {
                return redirect()->route('usermanagement')->with('error', 'Admin users cannot be deleted!');
            }
            $user->delete();

            return redirect()->route('usermanagement')->with('success', 'User deleted successfully!');
        } catch (QueryException $e) {
            return back()->with('error', 'Error deleting user: ' . $e->getMessage());
        } catch (\Exception $e) {
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }
}
