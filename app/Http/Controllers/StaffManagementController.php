<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StaffProvince;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StaffManagementController extends Controller
{
    public function index(Request $request)
    {
        $roleFilter = $request->input('role', 'STAFF'); // Default to STAFF
        $users = User::where('role', $roleFilter)->with('staffProvinces')->paginate(10);

        return view('Admin.StaffManagement.index', compact('users', 'roleFilter'));
    }

    public function create()
    {
        return view('Admin.StaffManagement.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'province' => 'required|string|max:255',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'STAFF',
        ]);

        // Assign the province
        StaffProvince::create([
            'user_id' => $user->id,
            'province' => $request->province,
        ]);

        return redirect()->route('staff-management.index')->with('success', 'Staff created successfully.');
    }

    public function edit($id)
    {
        $user = User::with('staffProvinces')->findOrFail($id);
        return view('Admin.StaffManagement.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'province' => 'required|string|max:255',
        ]);

        // Update user details
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Update province
        $user->staffProvinces()->updateOrCreate(
            ['user_id' => $user->id],
            ['province' => $request->province]
        );

        return redirect()->route('staff-management.index')->with('success', 'Staff updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Delete the user and their associated province
        $user->delete();

        return redirect()->route('staff-management.index')->with('success', 'Staff deleted successfully.');
    }
}
