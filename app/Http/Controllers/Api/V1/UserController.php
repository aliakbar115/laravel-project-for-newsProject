<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;


class UserController extends Controller
{
    /**
     * show all users
     * @return void
     */
    public function index()
    {
        $users = User::paginate(10);
        return new \App\Http\Resources\V1\UserCollection($users);
    }
    /**
     * create user
     * @param Request $request
     * @return string
     */
    public function create(Request $request){
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'is_staff'=>Rule::in([0,1]),
            'verify'=>Rule::in([true,false]),
        ]);
        $validated['password'] = bcrypt($request->get('password'));
        if ($request->verify) {
            $validated['email_verified_at']=now();
        }
        User::create($validated);
        return [
            'status'=>'success'
        ];
    }
    /**
     * edit user
     * @param Request $request
     * @param User $user
     * @return array
     */
    public function edit(Request $request,User $user){
        return new \App\Http\Resources\V1\User($user);
    }
    /**
     * update user
     * @param Request $request
     * @return string
     */
    public function update(Request $request){
        $user=User::find($request->id);
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'is_staff'=>Rule::in([0,1]),
            'verify'=>Rule::in([true,false]),
        ]);
        if (!is_null($request->get('password'))) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
            $validated['password'] = bcrypt($request->get('password'));
        }
        if ($request->verify) {
            $validated['email_verified_at']=now();
        }else{
            $validated['email_verified_at']=null;
        }
        $user->update($validated);
        return [
            'status'=>'success'
        ];
    }
    public function delete(Request $request,User $user){
        $user->delete();
        $users = User::paginate(10);
        return [
            'status'=>'success',
            'users'=>new \App\Http\Resources\V1\UserCollection($users)
        ];
    }
    /**
     * search in name or email in all users
     * @param Request $request
     * @return array
     */
    public function search(Request $request){
        $users = User::query();
        if ($keyword = request('search')) {
            $users->where('email', 'LIKE', "%$keyword%");
            $users->orWhere('name', 'LIKE', "%{$keyword}%");
        }
        $users_search = $users->latest()->paginate(10);
        return new \App\Http\Resources\V1\UserCollection($users_search);
    }
}
