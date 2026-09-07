<?php

namespace App\Http\Controllers;

use App\Models\Konseling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonselingController extends Controller
{
    /**
     * Display a listing of konseling.
     */
    public function index(Request $request)
    {
        $query = Konseling::query();

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }

        $konseling = $query->latest('tanggal')->paginate(20)->withQueryString();

        return view('konseling.index', compact('konseling'));
    }

    /**
     * Show the form for creating a new konseling.
     */
    public function create()
    {
        $this->authorizeManage();

        return view('konseling.create');
    }

    /**
     * Store a newly created konseling.
     */
    public function store(Request $request)
    {
        $this->authorizeManage();

        $data = $request->validate([
            'tanggal'          => ['required', 'date'],
            'permasalahan'     => ['required', 'string'],
            'solusi_bimbingan' => ['required', 'string'],
        ]);

        Konseling::create($data);

        return redirect()
            ->route('konseling.index')
            ->with('success', 'Konseling berhasil dicatat.');
    }

    /**
     * Display the specified konseling.
     */
    public function show(Konseling $konseling)
    {
        $konseling->load('sesiKonseling.siswa.kelas', 'sesiKonseling.user');

        return view('konseling.show', compact('konseling'));
    }

    /**
     * Show the form for editing the specified konseling.
     */
    public function edit(Konseling $konseling)
    {
        $this->authorizeManage();

        return view('konseling.edit', compact('konseling'));
    }

    /**
     * Update the specified konseling.
     */
    public function update(Request $request, Konseling $konseling)
    {
        $this->authorizeManage();

        $data = $request->validate([
            'tanggal'          => ['required', 'date'],
            'permasalahan'     => ['required', 'string'],
            'solusi_bimbingan' => ['required', 'string'],
        ]);

        $konseling->update($data);

        return redirect()
            ->route('konseling.show', $konseling)
            ->with('success', 'Konseling diperbarui.');
    }

    /**
     * Remove the specified konseling.
     */
    public function destroy(Konseling $konseling)
    {
        $this->authorizeManage();

        $konseling->delete();

        return redirect()
            ->route('konseling.index')
            ->with('success', 'Konseling dihapus.');
    }

    /**
     * Hanya BK yang boleh create/edit/delete Konseling.
     */
    protected function authorizeManage(): void
    {
        $role = Auth::user()?->role;
        abort_unless($role === 'BK', 403);
    }
}