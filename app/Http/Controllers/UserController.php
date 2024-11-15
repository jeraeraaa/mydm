<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user dengan role tertentu (super_user, admin, inventaris).
     */
    public function index(Request $request)
    {
        // Ambil ID role untuk 'super_user', 'admin', dan 'inventaris'
        $rolesToShow = DB::table('roles')->whereIn('name', ['super_user', 'admin', 'inventaris'])->pluck('id');

        // Ambil data anggota dengan role yang sesuai untuk ditampilkan di tabel
        $anggota = DB::table('anggota')
            ->join('roles', 'anggota.id_role', '=', 'roles.id')
            ->whereIn('anggota.id_role', $rolesToShow)
            ->select('anggota.id_anggota', 'anggota.nama_anggota', 'anggota.email', 'roles.name as role_name')
            ->get();

        // Ambil daftar role untuk dropdown
        $roles = DB::table('roles')->whereIn('name', ['super_user', 'admin', 'inventaris'])->get();

        return view('role.index', compact('anggota', 'roles'));
    }

    /**
     * Update role anggota berdasarkan ID.
     */
    public function updateRole(Request $request, $id)
    {
        // Cek apakah pengguna yang login memiliki role 'super_user'
        $user = Auth::guard('anggota')->user();
        if (!$user || $user->role->name !== 'super_user') {
            return redirect()->route('role.index')->withErrors(['error' => 'Anda tidak memiliki izin untuk mengubah role.']);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'id_role' => 'required|exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('role.index')->withErrors($validator)->withInput();
        }

        // Update role di tabel anggota
        DB::table('anggota')->where('id_anggota', $id)->update(['id_role' => $request->id_role]);

        return redirect()->route('role.index')->with('success', 'Role berhasil diperbarui.');
    }

    /**
     * Tambahkan role untuk anggota yang sudah ada berdasarkan NIM.
     */
    public function createUser(Request $request)
    {
        // Cek apakah pengguna yang login memiliki role 'super_user'
        $user = Auth::guard('anggota')->user();
        if (!$user || $user->role->name !== 'super_user') {
            return redirect()->route('role.index')->withErrors(['error' => 'Anda tidak memiliki izin untuk menambahkan role.']);
        }

        // Validasi bahwa id_anggota ada di tabel anggota dan belum memiliki role tertentu
        $validator = Validator::make($request->all(), [
            'id_anggota' => [
                'required',
                'string',
                'exists:anggota,id_anggota',
                function ($attribute, $value, $fail) {
                    $existingRole = DB::table('anggota')
                        ->where('id_anggota', $value)
                        ->whereIn('id_role', DB::table('roles')->whereIn('name', ['super_user', 'admin', 'inventaris'])->pluck('id'))
                        ->exists();
                    if ($existingRole) {
                        $fail('Anggota ini sudah memiliki role super_user, admin, atau inventaris.');
                    }
                },
            ],
            'id_role' => 'required|exists:roles,id',
        ], [
            'id_anggota.required' => 'NIM wajib diisi.',
            'id_anggota.exists' => 'NIM tidak ditemukan di dalam database.',
            'id_role.required' => 'Role wajib dipilih.',
            'id_role.exists' => 'Role tidak valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        try {
            // Update role anggota di tabel
            DB::table('anggota')->where('id_anggota', $request->id_anggota)->update(['id_role' => $request->id_role]);

            return redirect()->route('role.index')->with('success', 'Role berhasil ditambahkan untuk anggota.');
        } catch (\Exception $e) {
            // Tampilkan pesan error jika terjadi masalah saat update
            return redirect()->back()->withErrors(['error' => 'Gagal menambahkan role: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Mengatur ulang role user menjadi "anggota" alih-alih menghapus user.
     */
    public function deleteUser($id)
    {
        try {
            // Cek apakah pengguna yang login memiliki role 'super_user'
            $user = Auth::guard('anggota')->user();
            if (!$user || $user->role->name !== 'super_user') {
                return redirect()->route('role.index')->withErrors(['error' => 'Anda tidak memiliki izin untuk menghapus role.']);
            }

            // Ambil ID role untuk 'anggota'
            $roleAnggota = DB::table('roles')->where('name', 'anggota')->first();

            if (!$roleAnggota) {
                return redirect()->route('role.index')->with('error', 'Role Anggota tidak ditemukan.');
            }

            // Update role menjadi 'anggota' daripada menghapus user
            DB::table('anggota')->where('id_anggota', $id)->update(['id_role' => $roleAnggota->id]);

            return redirect()->route('role.index')->with('success', 'Role berhasil direset menjadi anggota.');
        } catch (\Exception $e) {
            return redirect()->route('role.index')->withErrors(['error' => 'Gagal mereset role: ' . $e->getMessage()]);
        }
    }

    /**
     * Memeriksa apakah NIM ada di database untuk validasi AJAX.
     */
    public function checkNim(Request $request)
    {
        try {
            $nimExists = DB::table('anggota')->where('id_anggota', $request->nim)->exists();

            return response()->json(['exists' => $nimExists]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memeriksa NIM: ' . $e->getMessage()], 500);
        }
    }
}
