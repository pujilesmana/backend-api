<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function index()
    {
        try {
            $users = User::all();
            return ResponseHelper::success($users, 'Data pengguna berhasil diambil');
        } catch (\Exception $e) {
            return ResponseHelper::error($e, 'Terjadi kesalahan saat mengambil data pengguna');
        }
    }

    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
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

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        return ResponseHelper::success($user, 'User berhasil dibuat', 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return ResponseHelper::error('User tidak ditemukan');
        }

        $validated = $request->validate([
            'name'     => 'sometimes|string|max:100',
            'email'    => 'sometimes|email|unique:users,email,' . $id,
            'password' => 'sometimes|min:6',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return ResponseHelper::success($user, 'User berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return ResponseHelper::error('User tidak ditemukan');
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }

    public function showManual($id)
    {
        $user = DB::select('SELECT * FROM users WHERE id = ?', [$id]);

        if (empty($user)) {
            return ResponseHelper::error('User tidak ditemukan (raw query)');
        }

        return ResponseHelper::success($user[0], 'Data pengguna berhasil diambil', 200, [
            'method' => 'raw SQL',
        ]);
    }
}
