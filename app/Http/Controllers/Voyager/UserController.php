<?php

namespace App\Http\Controllers\Voyager;

use App\Models\User;
use Illuminate\Http\Request;
use TCG\Voyager\Models\Role;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getAllUsers()
    {
        $users = User::latest()->paginate(50);

        return view('voyager::users.index', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();

        return view('voyager::users.edit', compact('user', 'roles'));
    }

    public function showUser($id)
    {
        $user = User::findOrFail($id);

        return view('voyager::users.show', compact('user'));
    }

    public function updateUser($id, Request $request)
    {
        $user = User::findOrFail($id);

        $user->email = $request->email;
        $user->name = $request->name;
        $user->balance = $request->balance;
        $user->role_id = $request->user_role;

        if(!empty($request->password)) {
            $user->password = $request->password;
        }

        $user->save();

        return back()->with('success', 'Данные пользователя успешно обновлены.');
    }

    public function searchUser(Request $request)
    {
        $searchTerm = $request->input('id');
        
        if (!empty($searchTerm)) {
            $userById = User::find($searchTerm);
            
            $userByName = User::where('name', 'like', '%' . $searchTerm . '%')->first();

            if ($userById) {
                return redirect()->route('admin.users.show', $userById->id);
            }

            if ($userByName) {
                return redirect()->route('admin.users.show', $userByName->id);
            }

            return back()->with('error', 'Пользователь не найден');
        }

        return back();
    }

    public function destroyUser($id)
    {
        User::findOrFail($id)->delete();
        
        return back();
    }
}
