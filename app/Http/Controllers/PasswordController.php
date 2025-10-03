<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Password;
use Illuminate\Support\Facades\Crypt;

class PasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            // Only allow admin users to access password management
            if (Auth::user()->role !== 'admin') {
                abort(403, 'Access denied. Only administrators can manage passwords.');
            }
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Password::forUser($user->id);

        // All passwords are admin context since only admins can access

        // Filter by category
        if ($request->has('category') && $request->category !== 'all') {
            $query->byCategory($request->category);
        }

        // Filter favorites
        if ($request->has('favorites') && $request->favorites) {
            $query->favorites();
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('account_name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        $passwords = $query->orderBy('is_favorite', 'desc')
                          ->orderBy('created_at', 'desc')
                          ->paginate(10);

        $categories = Password::forUser($user->id)
                             ->select('category')
                             ->distinct()
                             ->pluck('category');

        return view('passwords.index', compact('passwords', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = [
            'general' => 'General',
            'social' => 'Social Media',
            'email' => 'Email',
            'banking' => 'Banking',
            'work' => 'Work',
            'shopping' => 'Shopping',
            'entertainment' => 'Entertainment',
            'other' => 'Other'
        ];

        return view('passwords.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255',
            'password' => 'required|string',
            'notes' => 'nullable|string',
            'category' => 'required|string|max:50',
            'url' => 'nullable|url',
            'is_favorite' => 'boolean'
        ]);

        $user = Auth::user();

        $password = Password::create([
            'user_id' => $user->id,
            'title' => $request->title,
            'account_name' => $request->account_name,
            'username' => $request->username,
            'encrypted_password' => Crypt::encryptString($request->password),
            'notes' => $request->notes,
            'category' => $request->category,
            'url' => $request->url,
            'is_favorite' => $request->has('is_favorite')
        ]);

        return redirect()->route('passwords.index')
                        ->with('success', 'Password saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Password $password)
    {
        // Ensure user can only view their own passwords
        if ($password->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return view('passwords.show', compact('password'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Password $password)
    {
        // Ensure user can only edit their own passwords
        if ($password->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $categories = [
            'general' => 'General',
            'social' => 'Social Media',
            'email' => 'Email',
            'banking' => 'Banking',
            'work' => 'Work',
            'shopping' => 'Shopping',
            'entertainment' => 'Entertainment',
            'other' => 'Other'
        ];

        return view('passwords.edit', compact('password', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Password $password)
    {
        // Ensure user can only update their own passwords
        if ($password->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'account_name' => 'required|string|max:255',
            'username' => 'nullable|string|max:255',
            'password' => 'required|string',
            'notes' => 'nullable|string',
            'category' => 'required|string|max:50',
            'url' => 'nullable|url',
            'is_favorite' => 'boolean'
        ]);

        $password->update([
            'title' => $request->title,
            'account_name' => $request->account_name,
            'username' => $request->username,
            'encrypted_password' => Crypt::encryptString($request->password),
            'notes' => $request->notes,
            'category' => $request->category,
            'url' => $request->url,
            'is_favorite' => $request->has('is_favorite')
        ]);

        return redirect()->route('passwords.index')
                        ->with('success', 'Password updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Password $password)
    {
        // Ensure user can only delete their own passwords
        if ($password->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $password->delete();

        return redirect()->route('passwords.index')
                        ->with('success', 'Password deleted successfully!');
    }

    /**
     * Toggle favorite status
     */
    public function toggleFavorite(Password $password)
    {
        // Ensure user can only modify their own passwords
        if ($password->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        $password->update(['is_favorite' => !$password->is_favorite]);

        return response()->json([
            'success' => true,
            'is_favorite' => $password->is_favorite
        ]);
    }

    /**
     * Copy password to clipboard (AJAX)
     */
    public function copyPassword(Password $password)
    {
        // Ensure user can only access their own passwords
        if ($password->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access');
        }

        return response()->json([
            'success' => true,
            'password' => $password->getDecryptedPassword()
        ]);
    }

}
