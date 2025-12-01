<?php

namespace Modules\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Emargareten\InertiaModal\Modal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('role')
            ->when($request->search, function ($q, $search) {
                $q->where(function ($query) use ($search) {
                    $query->where('name', 'ilike', "%{$search}%")
                        ->orWhere('email', 'ilike', "%{$search}%");
                });
            })
            ->when($request->role_id, function ($q, $roleId) {
                $q->where('role_id', $roleId);
            })
            ->when($request->status !== null && $request->status !== '', function ($q) use ($request) {
                if ($request->status === 'active') {
                    $q->whereNotNull('email_verified_at');
                } elseif ($request->status === 'inactive') {
                    $q->whereNull('email_verified_at');
                }
            });

        // Sorting
        $sortField = $request->get('sort', 'created_at');
        $sortDirection = $request->get('direction', 'desc');
        $query->orderBy($sortField, $sortDirection);

        $users = $query->paginate($request->get('per_page', 10))
            ->withQueryString();

        return Inertia::render('user::index', [
            'users' => $users,
            'roles' => Role::orderBy('name')->get(['id', 'name', 'display_name']),
            'filters' => $request->only(['search', 'role_id', 'status', 'sort', 'direction', 'per_page']),
        ]);
    }

    /**
     * Show the form for creating a new resource (modal).
     */
    public function create(): Modal
    {
        return Inertia::modal('user::create', [
            'roles' => Role::where('active', true)->orderBy('name')->get(['id', 'name', 'display_name']),
        ])->baseRoute('users.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role_id' => ['nullable', 'exists:roles,id'],
            'email_verified' => ['boolean'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'] ?? null,
            'email_verified_at' => ($validated['email_verified'] ?? false) ? now() : null,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User created successfully!');
    }

    /**
     * Display the specified resource (modal).
     */
    public function show(User $user): Modal
    {
        $user->load('role');

        return Inertia::modal('user::show', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'role_id' => $user->role_id,
                'role' => $user->role ? [
                    'id' => $user->role->id,
                    'name' => $user->role->name,
                    'display_name' => $user->role->display_name,
                ] : null,
                'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                'updated_at' => $user->updated_at->format('Y-m-d H:i:s'),
            ],
            'roles' => Role::where('active', true)->orderBy('name')->get(['id', 'name', 'display_name']),
        ])->baseRoute('users.index');
    }

    /**
     * Show the form for editing the specified resource (modal).
     */
    public function edit(User $user): Modal
    {
        return Inertia::modal('user::edit', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
                'email_verified' => $user->email_verified_at !== null,
            ],
            'roles' => Role::where('active', true)->orderBy('name')->get(['id', 'name', 'display_name']),
        ])->baseRoute('users.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'confirmed', Password::defaults()],
            'role_id' => ['nullable', 'exists:roles,id'],
            'email_verified' => ['boolean'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role_id = $validated['role_id'] ?? null;

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        // Handle email verification status
        if ($validated['email_verified'] ?? false) {
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
            }
        } else {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'You cannot delete your own account!');
        }

        // Prevent deleting users with Administrator role
        $user->load('role');
        if ($user->role && strtolower($user->role->name) === 'administrator') {
            return redirect()->route('users.index')
                ->with('error', 'Users with Administrator role cannot be deleted.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully!');
    }

    /**
     * Bulk destroy multiple users.
     */
    public function bulkDestroy(Request $request)
    {
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:users,id'],
        ]);

        // Get Administrator role
        $adminRole = Role::whereRaw('LOWER(name) = ?', ['administrator'])->first();

        // Filter out current user and users with Administrator role from deletion
        $ids = array_filter($validated['ids'], function ($id) use ($adminRole) {
            if ($id === auth()->id()) {
                return false;
            }
            if ($adminRole) {
                $user = User::find($id);
                if ($user && $user->role_id === $adminRole->id) {
                    return false;
                }
            }
            return true;
        });

        if (empty($ids)) {
            return redirect()->route('users.index')
                ->with('error', 'No users were deleted. Administrator users and your own account cannot be deleted!');
        }

        User::whereIn('id', $ids)->delete();

        return redirect()->route('users.index')
            ->with('success', count($ids) . ' user(s) deleted successfully!');
    }

    /**
     * Toggle user verification status.
     */
    public function toggleVerification(User $user)
    {
        if ($user->email_verified_at) {
            $user->email_verified_at = null;
            $message = 'User has been unverified.';
        } else {
            $user->email_verified_at = now();
            $message = 'User has been verified.';
        }

        $user->save();

        return redirect()->back()->with('success', $message);
    }

    /**
     * Show the change role form (modal).
     */
    public function changeRole(User $user): Modal
    {
        return Inertia::modal('user::change-role', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ],
            'roles' => Role::where('active', true)->orderBy('name')->get(['id', 'name', 'display_name']),
        ])->baseRoute('users.index');
    }

    /**
     * Update user role.
     */
    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate([
            'role_id' => ['nullable', 'exists:roles,id'],
        ]);

        $user->role_id = $validated['role_id'];
        $user->save();

        return redirect()->route('users.index')
            ->with('success', 'User role updated successfully!');
    }
}
