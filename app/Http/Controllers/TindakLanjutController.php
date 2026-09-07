<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\TindakLanjut;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TindakLanjutController extends Controller
{
    /**
     * Display a listing of tindak lanjut.
     */
    public function index(Request $request)
    {
        $query = TindakLanjut::with(['pelanggaran.siswa.kelas', 'user']);

        if ($request->filled('id_pelanggaran')) {
            $query->where('id_pelanggaran', $request->id_pelanggaran);
        }
        if ($request->filled('id_user')) {
            $query->where('id_user', $request->id_user);
        }

        $tindakLanjut = $query->latest('tanggal')->paginate(20)->withQueryString();

        return view('tindak-lanjut.index', compact('tindakLanjut'));
    }

    /**
     * Show the form for creating a new tindak lanjut.
     */
    public function create(Request $request)
    {
        $this->authorizeManage();

        $pelanggaran = Pelanggaran::with('siswa')->orderByDesc('tanggal')->get();
        $userId = $request->query('id_user');
        $selectedPelanggaran = $request->query('id_pelanggaran')
            ? Pelanggaran::find($request->query('id_pelanggaran'))
            : null;

        return view('tindak-lanjut.create', compact('pelanggaran', 'userId', 'selectedPelanggaran'));
    }

    /**
     * Store a newly created tindak lanjut.
     */
    public function store(Request $request)
    {
        $this->authorizeManage();

        $data = $request->validate([
            'id_pelanggaran' => ['required', 'exists:pelanggaran,id_pelanggaran'],
            'id_user'        => ['nullable', 'exists:user,id_user'], // default: Auth::id() jika kosong
            'tanggal'        => ['required', 'date'],
            'jenis_tindakan' => ['required', 'string', 'max:100'],
            'hasil'          => ['required', 'string'],
        ]);

        $data['id_user'] = $data['id_user'] ?? Auth::id();

        TindakLanjut::create($data);

        return redirect()
            ->route('tindak-lanjut.index')
            ->with('success', 'Tindak lanjut berhasil dicatat.');
    }

    /**
     * Display the specified tindak lanjut.
     */
    public function show(TindakLanjut $tindakLanjut)
    {
        $tindakLanjut->load(['pelanggaran.siswa.kelas', 'pelanggaran.jenisPelanggaran', 'user']);

        return view('tindak-lanjut.show', compact('tindakLanjut'));
    }

    /**
     * Show the form for editing the specified tindak lanjut.
     */
    public function edit(TindakLanjut $tindakLanjut)
    {
        $this->authorizeManage();

        $pelanggaran = Pelanggaran::with('siswa')->orderByDesc('tanggal')->get();

        return view('tindak-lanjut.edit', compact('tindakLanjut', 'pelanggaran'));
    }

    /**
     * Update the specified tindak lanjut.
     */
    public function update(Request $request, TindakLanjut $tindakLanjut)
    {
        $this->authorizeManage();

        $data = $request->validate([
            'id_pelanggaran' => ['required', 'exists:pelanggaran,id_pelanggaran'],
            'id_user'        => ['required', 'exists:user,id_user'],
            'tanggal'        => ['required', 'date'],
            'jenis_tindakan' => ['required', 'string', 'max:100'],
            'hasil'          => ['required', 'string'],
        ]);

        $tindakLanjut->update($data);

        return redirect()
            ->route('tindak-lanjut.show', $tindakLanjut)
            ->with('success', 'Tindak lanjut diperbarui.');
    }

    /**
     * Remove the specified tindak lanjut.
     */
    public function destroy(TindakLanjut $tindakLanjut)
    {
        $this->authorizeManage();

        $tindakLanjut->delete();

        return redirect()
            ->route('tindak-lanjut.index')
            ->with('success', 'Tindak lanjut dihapus.');
    }

    /**
     * Hanya BK yang boleh create/edit/delete Tindak Lanjut.
     */
    protected function authorizeManage(): void
    {
        $role = Auth::user()?->role;
        abort_unless($role === 'BK', 403);
    }
}