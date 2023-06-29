<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\User;
use App\Role;

class UserManagementController extends Controller
{

    /**
     * Constructor
     * 
     */
    public function __construct()
    {
        // Dependency injection
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search'));

        $users = User::with('roles')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->paginate(10)
            ->appends(request()->query());
        return view('admin.user-management.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();

        return view('admin.user-management.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();

        $request->validate([
            'username' => 'required',
            'email' => 'required|email'
        ]);

        $input['name'] = $input['username'];
        $input['password'] = $input['password'];
        $input['activated'] = 1;
        
        User::create($input);

        return redirect()->route('user-management.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('roles')->find($id);

        $roles = Role::get();

        return view('admin.user-management.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $user->username = $request->username ?? $user->username;
        $user->email = $request->email ?? $user->email;
        $user->name = $user->username;
        $user->surename = $request->surename ?? $user->surename;
        $user->dob = $request->dob ?? $user->dob;
        $user->address = $request->address ?? $user->address;
        $user->city = $request->city ?? $user->city;
        $user->bio_data = $request->bio_data ?? $user->bio_data;
        $user->user_role_id = $request->user_role_id ?? $user->user_role_id;

        if ($request->password) {
            $user->password = $request->password;
        }

        $user->save();

        return redirect()->route('user-management.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Block the specific user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function blockUser($id)
    {
        $user = User::find($id);
        $user->user_blocked_status = 1;
        $user->save();

        return redirect()->back();
    }

    /**
     * Unblock the specific user
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function unblockUser($id)
    {
        $user = User::find($id);
        $user->user_blocked_status = 0;
        $user->save();

        return redirect()->back();
    }
}
