<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UserController extends Controller
{
    // Menampilkan semua pengguna
    public function index()
    {
        $users = User::all();  // Ambil data semua user
        return Inertia::render('Dashboard/Index', [
            'users' => $users,
        ]);
    }

    // Menyimpan data user baru
    public function store(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed', // Password wajib di-confirm
        ]);

        // Menyimpan user baru ke database
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),  // Hash password sebelum disimpan
        ]);

        return redirect()->route('dashboard')->with('success', 'User created successfully.');
    }

    // Memperbarui data user yang sudah ada
    public function update(Request $request, $id)
    {
        // Validasi data input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id, // Pastikan email unique, kecuali untuk user yang sedang diupdate
            'password' => 'nullable|min:8|confirmed', // Password bisa kosong jika tidak diubah
        ]);

        // Ambil data user berdasarkan ID
        $user = User::findOrFail($id);
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update password jika ada input baru
        if ($request->password) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();  // Simpan perubahan ke database

        return redirect()->route('dashboard')->with('success', 'User updated successfully.');
    }

    // Menghapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);  // Ambil data user berdasarkan ID
        $user->delete();  // Hapus user

        return redirect()->route('dashboard')->with('success', 'User deleted successfully.');
    }
}
