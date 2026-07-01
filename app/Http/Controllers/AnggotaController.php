<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Simpanan;
use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    /**
     * Display a listing of members.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = User::where('role', 'anggota');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        $anggota = $query->orderBy('name', 'asc')->paginate(10);

        return view('admin.anggota.index', compact('anggota', 'search', 'status'));
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'nip' => 'nullable|string|max:50|unique:users',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'required|string|min:6',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nip' => $request->nip,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
            'role' => 'anggota',
            'status' => $request->status,
        ]);

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota guru baru berhasil ditambahkan.');
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nip' => 'nullable|string|max:50|unique:users,nip,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'status' => 'required|in:aktif,nonaktif',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nip = $request->nip;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->status = $request->status;

        $user->save();

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil dihapus.');
    }

    /**
     * Display member details including savings and loan history.
     */
    public function detail($id)
    {
        $user = User::findOrFail($id);

        $simpanan = Simpanan::where('user_id', $user->id)->orderBy('tanggal_transaksi', 'desc')->get();
        $pinjaman = Pinjaman::where('user_id', $user->id)->orderBy('tanggal_pengajuan', 'desc')->get();

        $pokok = Simpanan::where('user_id', $user->id)->where('tipe_simpanan', 'pokok')->sum('nominal');
        $wajib = Simpanan::where('user_id', $user->id)->where('tipe_simpanan', 'wajib')->sum('nominal');
        $sukarela = Simpanan::where('user_id', $user->id)->where('tipe_simpanan', 'sukarela')->sum('nominal');
        $totalSimpanan = $pokok + $wajib + $sukarela;

        return view('admin.anggota.detail', compact('user', 'simpanan', 'pinjaman', 'pokok', 'wajib', 'sukarela', 'totalSimpanan'));
    }

    /**
     * Show User Profile.
     */
    public function profil()
    {
        $user = Auth::user();
        return view('profil', compact('user'));
    }

    /**
     * Update User Profile.
     */
    public function updateProfil(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'nip' => 'nullable|string|max:50|unique:users,nip,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        
        // Members cannot update their NIP
        if ($user->role === 'admin') {
            $user->nip = $request->nip;
        }
        
        $user->phone = $request->phone;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui.');
    }
}
