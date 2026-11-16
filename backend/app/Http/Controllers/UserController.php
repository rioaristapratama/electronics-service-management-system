<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Menampilkan daftar pengguna.
     */
    public function index(Request $request): View
    {
        $users = User::with('role')
            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('users.index', compact('users'));
    }

    /**
     * Menampilkan formulir tambah pengguna.
     */
    public function create(): View
    {
        $roles = Role::orderBy('name')->get();

        return view('users.form', [
            'user' => new User(),
            'roles' => $roles,
            'isEdit' => false,
        ]);
    }

    /**
     * Menyimpan pengguna baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'is_active' => ['required', 'boolean'],
        ]);

        $this->validateAssignableRole(
            $request,
            (int) $validated['role_id']
        );

        $user = new User();

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => $validated['password'],
        ]);

        $user->role_id = $validated['role_id'];
        $user->is_active = $validated['is_active'];

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Menampilkan formulir edit pengguna.
     */
    public function edit(User $user): View
    {
        $roles = Role::orderBy('name')->get();

        return view('users.form', [
            'user' => $user,
            'roles' => $roles,
            'isEdit' => true,
        ]);
    }

    /**
     * Memperbarui data pengguna.
     */

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'role_id' => ['required', 'exists:roles,id'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'is_active' => ['required', 'boolean'],
        ]);

        $this->validateAssignableRole(
            $request,
            (int) $validated['role_id']
        );

        /*
     * Perlindungan akun sendiri.
     * Pemeriksaan dilakukan sebelum aturan Owner terakhir.
     */
        if ($request->user()->id === $user->id) {
            if (!(bool) $validated['is_active']) {
                return back()->withErrors([
                    'is_active' => 'Anda tidak dapat menonaktifkan akun sendiri.',
                ])->withInput();
            }

            if ((int) $validated['role_id'] !== (int) $user->role_id) {
                return back()->withErrors([
                    'role_id' => 'Anda tidak dapat mengganti role akun sendiri.',
                ])->withInput();
            }
        }

        /*
     * Perlindungan Owner terakhir.
     * Sistem harus memiliki minimal satu Owner aktif.
     */
        $targetIsActiveOwner = $user->is_active
            && $user->role?->name === 'Owner';

        $removesActiveOwner = !(bool) $validated['is_active']
            || (int) $validated['role_id'] !== (int) $user->role_id;

        if ($targetIsActiveOwner && $removesActiveOwner) {
            $activeOwnerCount = User::whereHas('role', function ($query) {
                $query->where('name', 'Owner');
            })
                ->where('is_active', true)
                ->count();

            if ($activeOwnerCount <= 1) {
                throw ValidationException::withMessages([
                    'role_id' => 'Perubahan ditolak. Sistem harus memiliki minimal satu Owner aktif.',
                ]);
            }
        }

        $user->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ]);

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->role_id = $validated['role_id'];
        $user->is_active = $validated['is_active'];

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Memeriksa apakah pengguna boleh memberikan role tertentu.
     */
    private function validateAssignableRole(
        Request $request,
        int $roleId
    ): void {
        $role = Role::findOrFail($roleId);

        if (
            $role->name === 'Owner'
            && !$request->user()->role?->permissions()
                ->where('name', 'settings.manage')
                ->exists()
        ) {
            throw ValidationException::withMessages([
                'role_id' => 'Anda tidak memiliki izin untuk memberikan role Owner.',
            ]);
        }
    }
}
