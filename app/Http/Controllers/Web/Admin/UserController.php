<?php

namespace App\Http\Controllers\Web\Admin;

use App\Models\User;
use App\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Mail\SendUserCredentials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserController extends \App\Http\Controllers\Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');
        
        // Filter by search term (name or email)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }
        
        // Filter by is_active status
        if ($request->filled('status')) {
            $query->where('is_active', $request->input('status'));
        }
        
        $users = $query->paginate(15)->appends($request->query());
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        
        // Generate a random temporary password
        $tempPassword = Str::random(12);
        $data['password'] = bcrypt($tempPassword);
        $data['is_active'] = true; // Activate user by default

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            $photo = $request->file('profile_photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('profile-photos', $filename, 'public');
            $data['profile_photo'] = $filename;
        }

        $user = User::create($data);

        // Attach roles if provided
        if ($request->has('roles')) {
            $user->roles()->sync($request->input('roles', []));
        }

        // Send email with credentials
        try {
            Mail::to($user->email)->send(new SendUserCredentials($user, $tempPassword));
        } catch (\Exception $e) {
            // Log error but don't fail the user creation
            Log::error('Failed to send user credentials email: ' . $e->getMessage());
        }

        return redirect()->route('admin.users.show', $user->id)
                        ->with('success', 'Utilisateur créé avec succès. Un email avec les identifiants a été envoyé.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        $user->load('roles');
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $user->load('roles');
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $data = $request->validated();

        // Only hash password if provided
        if ($request->filled('password')) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            if ($user->profile_photo && Storage::disk('public')->exists('profile-photos/' . $user->profile_photo)) {
                Storage::disk('public')->delete('profile-photos/' . $user->profile_photo);
            }
            
            $photo = $request->file('profile_photo');
            $filename = time() . '_' . $photo->getClientOriginalName();
            $photo->storeAs('profile-photos', $filename, 'public');
            $data['profile_photo'] = $filename;
        }

        $user->update($data);

        // Update roles if provided
        if ($request->has('roles')) {
            $user->roles()->sync($request->input('roles', []));
        }

        return redirect()->route('admin.users.show', $user->id)
                        ->with('success', 'Utilisateur modifié avec succès.');
    }

    /**
     * Remove the specified user from storage (soft delete).
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
                        ->with('success', 'Utilisateur supprimé avec succès.');
    }
}
