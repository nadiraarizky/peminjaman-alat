<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. Menampilkan daftar semua user
    public function index()
    {
        // Mengambil user terbaru agar yang baru daftar muncul di atas
        $users = User::latest()->get(); 
        return view('admin.users.index', compact('users'));
    }

    // 2. Fungsi BARU: Menampilkan detail user via JSON (untuk Modal)
    // Jika kamu ingin detailnya lebih canggih, fungsi ini bisa dipakai
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // 3. Menyimpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,petugas,user', // Sesuaikan dengan enum di DB
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Catat Log
        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Tambah User',
            'description' => auth()->user()->name . ' menambah user baru: ' . $user->name . ' sebagai ' . $user->role
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan!');
    }

    // 4. Menampilkan halaman edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // 5. Mengupdate data user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:admin,petugas,user',
            'password' => 'nullable|string|min:8', // Password opsional saat edit
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Update User',
            'description' => auth()->user()->name . ' mengubah data user: ' . $user->name
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    // 6. Menghapus data user 
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Proteksi agar tidak menghapus diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'activity' => 'Hapus User',
            'description' => auth()->user()->name . ' menghapus user: ' . $user->name
        ]);

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }
}