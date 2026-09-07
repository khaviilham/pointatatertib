<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use App\Models\SesiKonseling;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiKonselingController extends Controller
{
    /**
     * Display a listing of sesi konseling.
     */
    public function index(Request $request)
    {
        $query = SesiKonseling::with(['konseling', 'siswa.kelas', 'user']);

        if ($request->filled('id_konseling')) {
            $query->where('id_konseling', $request->id_konseling);
        }
        if ($request->filled('id_siswa')) {
            $query->where('id_siswa', $request->id_siswa);
        }
        if ($request->filled('id_user')) {
            $query->where('id_user', $request->id_user);
        }

        $sesi = $query->latest('tanggal')->paginate(20)->withQueryString();

        return view('sesi-konseling.index', compact('sesi'));
    }

    /**
     * Show the form for creating a new sesi konseling.
     */
    public function create(Request $request)
    {
        $this->authorizeManage();

        $konseling = Konseling::orderByDesc('tanggal')->get();
        $siswa = Siswa::with('kelas')->orderBy('nama')->get();
        $selectedKonseling = $request->query('id_konseling')
            ? Konseling::find($request->query('id_konseling'))
            : null;
        $selectedSiswa = $request->query('id_siswa')
            ? Siswa::find($request->query('id_siswa'))
            : null;

        return view('sesi-konseling.create', compact('konseling', 'siswa', 'selectedKonseling', 'selectedSiswa'));
    }

    /**
     * Store a newly created sesi konseling.
     */
    public function store(Request $request)
    {
        $this->authorizeManage();

        $data = $request->validate([
            'id_konseling'  => ['required', 'exists:konseling,id_konseling'],
            'id_siswa'     => ['required', 'exists:siswa,id_siswa'],
            'tanggal'      => ['required', 'date'],
            'permasalahan' => ['required', 'string'],
            'id_user'      => ['nullable', 'exists:user,id_user'],
            'solusi'       => ['nullable', 'string'],
            'hasil'        => ['nullable', 'string'],
        ]);

        $data['id_user'] = $data['id_user'] ?? Auth::id();

        SesiKonseling::create($data);

        return redirect()
            ->route('sesi-konseling.index')
            ->with('success', 'Sesi konseling berhasil dicatat.');
    }

    /**
     * Display the specified sesi konseling.
     */
    public function show(SesiKonseling $sesiKonseling)
    {
        $sesiKonseling->load(['konseling', 'siswa.kelas', 'user']);

        return view('sesi-konseling.show', compact('sesiKonseling'));
    }

    /**
     * Show the form for editing the specified sesi konseling.
     */
    public function edit(SesiKonseling $sesiKonseling)
    {
        $this->authorizeManage();

        $konseling = Konseling::orderByDesc('tanggal')->get();
        $siswa = Siswa::with('kelas')->orderBy('nama')->get();

        return view('sesi-konseling.edit', compact('sesiKonseling', 'konseling', 'siswa'));
    }

    /**
     * Update the specified sesi konseling.
     */
    public function update(Request $request, SesiKonseling $sesiKonseling)
    {
        $this->authorizeManage();

        $data = $request->validate([
            'id_konseling'  => ['required', 'exists:konseling,id_konseling'],
            'id_siswa'     => ['required', 'exists:siswa,id_siswa'],
            'tanggal'      => ['required', 'date'],
            'permasalahan' => ['required', 'string'],
            'id_user'      => ['required', 'exists:user,id_user'],
            'solusi'       => ['nullable', 'string'],
            'hasil'        => ['nullable', 'string'],
        ]);

        $sesiKonseling->update($data);

        return redirect()
            ->route('sesi-konseling.show', $sesiKonseling)
            ->with('success', 'Sesi konseling diperbarui.');
    }

    /**
     * Remove the specified sesi konseling.
     */
    public function destroy(SesiKonseling $sesiKonseling)
    {
        $this->authorizeManage();

        $sesiKonseling->delete();

        return redirect()
            ->route('sesi-konseling.index')
            ->with('success', 'Sesi konseling dihapus.');
    }

    /**
     * Hanya BK yang boleh create/edit/delete Sesi Konseling.
     */
    protected function authorizeManage(): void
    {
        $role = Auth::user()?->role;
        abort_unless($role === 'BK', 403);
    }
}