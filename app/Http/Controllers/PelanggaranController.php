<?php

namespace App\Http\Controllers;

use App\Models\JenisPelanggaran;
use App\Models\Pelanggaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PelanggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pelanggaran::with(['siswa.kelas', 'jenisPelanggaran', 'user', 'buktiPelanggaran']);

        if ($request->filled('id_siswa')) {
            $query->where('id_siswa', $request->id_siswa);
        }
        if ($request->filled('id_kelas')) {
            $query->whereHas('siswa', fn ($q) => $q->where('id_kelas', $request->id_kelas));
        }
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_dari);
        }
        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_sampai);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pelanggaran = $query->latest('tanggal')->paginate(20)->withQueryString();

        return view('pelanggaran.index', compact('pelanggaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeCreate();

        $siswa = Siswa::with('kelas')->orderBy('nama')->get();
        $jenis = JenisPelanggaran::orderBy('nama_pelanggaran')->get();

        return view('pelanggaran.create', compact('siswa', 'jenis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeCreate();

        $data = $request->validate([
            'id_siswa'        => ['required', 'exists:siswa,id_siswa'],
            'id_jenis'        => ['required', 'exists:jenis_pelanggaran,id_jenis'],
            'tanggal'         => ['required', 'date'],
            'waktu_kejadian'  => ['nullable', 'date_format:H:i'],
            'lokasi'          => ['required', 'string', 'max:100'],
            'status'          => ['required', 'string', 'max:50'],
            'kronologi'       => ['nullable', 'string'],
        ]);

        $jenis = JenisPelanggaran::findOrFail($data['id_jenis']);

        DB::transaction(function () use ($data, $jenis) {
            $pelanggaran = new Pelanggaran();
            $pelanggaran->id_user    = Auth::id();
            $pelanggaran->id_siswa   = $data['id_siswa'];
            $pelanggaran->id_jenis   = $data['id_jenis'];
            $pelanggaran->tanggal    = $data['tanggal'];
            $pelanggaran->waktu_kejadian = $data['waktu_kejadian'] ?? null;
            $pelanggaran->lokasi     = $data['lokasi'];
            $pelanggaran->status     = $data['status'];
            $pelanggaran->kronologi  = $data['kronologi'] ?? null;
            $pelanggaran->poin       = (int) $jenis->point; // snapshot poin
            $pelanggaran->save();

            Siswa::where('id_siswa', $data['id_siswa'])
                ->increment('total_point', (int) $jenis->point);
        });

        return redirect()
            ->route('pelanggaran.index')
            ->with('success', 'Pelanggaran berhasil dicatat dan poin siswa telah diperbarui.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggaran $pelanggaran)
    {
        $pelanggaran->load(['siswa.kelas', 'jenisPelanggaran', 'user', 'buktiPelanggaran', 'tindakLanjut.user']);

        return view('pelanggaran.show', compact('pelanggaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggaran $pelanggaran)
    {
        $this->authorizeModify();

        $siswa = Siswa::with('kelas')->orderBy('nama')->get();
        $jenis = JenisPelanggaran::orderBy('nama_pelanggaran')->get();

        return view('pelanggaran.edit', compact('pelanggaran', 'siswa', 'jenis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggaran $pelanggaran)
    {
        $this->authorizeModify();

        $data = $request->validate([
            'id_siswa'        => ['required', 'exists:siswa,id_siswa'],
            'id_jenis'        => ['required', 'exists:jenis_pelanggaran,id_jenis'],
            'tanggal'         => ['required', 'date'],
            'waktu_kejadian'  => ['nullable', 'date_format:H:i'],
            'lokasi'          => ['required', 'string', 'max:100'],
            'status'          => ['required', 'string', 'max:50'],
            'kronologi'       => ['nullable', 'string'],
        ]);

        $newPoin = (int) JenisPelanggaran::where('id_jenis', $data['id_jenis'])->value('point');
        $oldPoin = (int) $pelanggaran->poin;
        $oldSiswaId = $pelanggaran->id_siswa;
        $newSiswaId = $data['id_siswa'];

        DB::transaction(function () use ($data, $pelanggaran, $newPoin, $oldPoin, $oldSiswaId, $newSiswaId) {
            // rollback poin lama jika siswa sama
            if ($oldSiswaId === $newSiswaId) {
                $delta = $newPoin - $oldPoin;
                if ($delta !== 0) {
                    Siswa::where('id_siswa', $newSiswaId)->increment('total_point', $delta);
                }
            } else {
                // kembalikan poin ke siswa lama, lalu tambahkan ke siswa baru
                Siswa::where('id_siswa', $oldSiswaId)->decrement('total_point', $oldPoin);
                Siswa::where('id_siswa', $newSiswaId)->increment('total_point', $newPoin);
            }

            $pelanggaran->fill([
                'id_user'         => Auth::id(),
                'id_siswa'        => $data['id_siswa'],
                'id_jenis'        => $data['id_jenis'],
                'tanggal'         => $data['tanggal'],
                'waktu_kejadian'  => $data['waktu_kejadian'] ?? null,
                'lokasi'          => $data['lokasi'],
                'status'          => $data['status'],
                'kronologi'       => $data['kronologi'] ?? null,
                'poin'            => $newPoin,
            ])->save();
        });

        return redirect()
            ->route('pelanggaran.show', $pelanggaran)
            ->with('success', 'Pelanggaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggaran $pelanggaran)
    {
        $this->authorizeModify();

        $poin = (int) $pelanggaran->poin;
        $idSiswa = $pelanggaran->id_siswa;

        DB::transaction(function () use ($pelanggaran, $poin, $idSiswa) {
            $pelanggaran->delete();
            Siswa::where('id_siswa', $idSiswa)->decrement('total_point', $poin);
        });

        return redirect()
            ->route('pelanggaran.index')
            ->with('success', 'Pelanggaran dihapus dan poin siswa dikembalikan.');
    }

    /**
     * Hanya Wali kelas & Kesiswaan yang boleh input pelanggaran baru.
     */
    protected function authorizeCreate(): void
    {
        $role = Auth::user()?->role;
        abort_unless(in_array($role, ['Wali kelas', 'Kesiswaan'], true), 403);
    }

    /**
     * Hanya Wali kelas & Kesiswaan yang boleh edit/hapus pelanggaran.
     */
    protected function authorizeModify(): void
    {
        $role = Auth::user()?->role;
        abort_unless(in_array($role, ['Wali kelas', 'Kesiswaan'], true), 403);
    }
}