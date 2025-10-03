<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->paginate(10);
        
        // Determine which view to use based on the route
        if (request()->routeIs('admin.users.*')) {
            return view('admin.users.index', compact('users'));
        }
        
        return view('superadmin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user
     */
    public function create()
    {
        // Determine which view to use based on the route
        if (request()->routeIs('admin.users.*')) {
            return view('admin.users.create');
        }
        
        return view('superadmin.users.create');
    }

    /**
     * Store a newly created user
     */
    public function store(Request $request)
    {
        // Determine allowed roles based on current user
        $allowedRoles = ['user', 'admin'];
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:' . implode(',', $allowedRoles),
            'employee_role' => 'nullable|in:hr_manager,employee',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'employee_role' => $request->employee_role,
            'email_verified_at' => now(),
        ]);

        // Determine which route to redirect to based on the current route
        if (request()->routeIs('admin.users.*')) {
            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully!');
        }
        
        return redirect()->route('superadmin.users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified user
     */
    public function show(User $user)
    {
        // Determine which view to use based on the route
        if (request()->routeIs('admin.users.*')) {
            return view('admin.users.show', compact('user'));
        }
        
        return view('superadmin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user
     */
    public function edit(User $user)
    {
        // Determine which view to use based on the route
        if (request()->routeIs('admin.users.*')) {
            return view('admin.users.edit', compact('user'));
        }
        
        return view('superadmin.users.edit', compact('user'));
    }

    /**
     * Update the specified user
     */
    public function update(Request $request, User $user)
    {
        // Determine allowed roles based on current user
        $allowedRoles = ['user', 'admin'];
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:' . implode(',', $allowedRoles),
            'employee_role' => 'nullable|in:hr_manager,employee',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'employee_role' => $request->employee_role,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8|confirmed',
            ]);
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // Determine which route to redirect to based on the current route
        if (request()->routeIs('admin.users.*')) {
            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully!');
        }
        
        return redirect()->route('superadmin.users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevent admin/superadmin from deleting themselves
        if ($user->id === Auth::id()) {
            $redirectRoute = request()->routeIs('admin.users.*') ? 'admin.users.index' : 'superadmin.users.index';
            return redirect()->route($redirectRoute)
                ->with('error', 'You cannot delete your own account!');
        }

        $user->delete();

        // Determine which route to redirect to based on the current route
        if (request()->routeIs('admin.users.*')) {
            return redirect()->route('admin.users.index')
                ->with('success', 'User deleted successfully!');
        }
        
        return redirect()->route('superadmin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Toggle user status (active/inactive)
     */
    public function toggleStatus(User $user)
    {
        // Prevent admin/superadmin from deactivating themselves
        if ($user->id === Auth::id()) {
            $redirectRoute = request()->routeIs('admin.users.*') ? 'admin.users.index' : 'superadmin.users.index';
            return redirect()->route($redirectRoute)
                ->with('error', 'You cannot change your own status!');
        }

        $user->update([
            'email_verified_at' => $user->email_verified_at ? null : now(),
        ]);

        $status = $user->email_verified_at ? 'activated' : 'deactivated';
        
        // Determine which route to redirect to based on the current route
        if (request()->routeIs('admin.users.*')) {
            return redirect()->route('admin.users.index')
                ->with('success', "User {$status} successfully!");
        }
        
        return redirect()->route('superadmin.users.index')
            ->with('success', "User {$status} successfully!");
    }
}