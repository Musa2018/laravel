<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Governorate;
use App\Models\Role;
use App\Models\User;

class UsersController extends Controller
{
public function index(){
    $users=User::with('role')->with('governorate')->orderBy('created_at')->paginate(10);
    return view('auth.users',compact('users'));
}
public function show(User $user){

return view('auth.show',compact('user'));
}
public function edit(User $user){
    $roles=Role::all();
    $governorates=Governorate::all();
    return view('auth.edit',compact('user','roles','governorates'));
}
    public function update(UserUpdateRequest $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'role_id' => 'required|exists:roles,id',
            'governorate_id' => 'nullable|exists:governorates,id',
        ]);

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'تم تحديث بيانات المستخدم بنجاح ✅');
    }
    public function destroy(User $user) {
        // --> /user/{id} (DELETE)
        $user->delete();

        return redirect()->route('users.index');
    }

}
