<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{

    public function index()
    {
        try {
            Log::info('Fetching all users');
            $users = User::all();
            Log::info('Fetched all users successfully : ' . $users);
            return ResponseHelper::success($users, 'Data pengguna berhasil diambil');
        } catch (\Exception $e) {
            Log::error('Error fetching users: ' . $e->getMessage());
            return ResponseHelper::error($e, 'Terjadi kesalahan saat mengambil data pengguna');
        }
    }

    public function show($id)
    {
        $user = User::find($id);
        Log::info('Fetching user with ID: ' . $id);
        if (!$user) {
            Log::warning('User not found with ID: ' . $id);
            return ResponseHelper::error('User tidak ditemukan');
        }

        return ResponseHelper::success($user);
     }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        Log::info('Creating user: ' . $validated['name']);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Log::info('User created successfully: ' . $user);

        return ResponseHelper::success($user, 'User berhasil dibuat', 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            Log::warning('User not found with ID: ' . $id);
            return ResponseHelper::error('User tidak ditemukan');
        }

        $validated = $request->validate([
            'name'     => 'sometimes|string|max:100',
            'email'    => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|min:6',
        ]);

        Log::info('Updating user with ID: ' . $id);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        Log::info('User updated successfully: ' . $user);

        return ResponseHelper::success($user, 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            Log::warning('User not found with ID: ' . $id);
            return ResponseHelper::error('User tidak ditemukan');
        }

        $user->delete();

        Log::info('User deleted successfully: ' . $user);

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }

    public function showManual($id)
    {
        $user = DB::select('SELECT * FROM users WHERE id = ?', [$id]);

        if (empty($user)) {
            Log::warning('User not found with ID: ' . $id);
            return ResponseHelper::error('User tidak ditemukan (raw query)');
        }

        Log::info('Fetched user successfully (raw query): ' . $user[0]);

        return ResponseHelper::success($user[0], 'Data pengguna berhasil diambil', 200, [
            'method' => 'raw SQL',
        ]);
    }
}
