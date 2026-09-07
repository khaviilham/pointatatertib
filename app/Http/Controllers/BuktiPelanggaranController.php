<?php

namespace App\Http\Controllers;

use App\Models\BuktiPelanggaran;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BuktiPelanggaranController extends Controller
{
    /**
     * Display a listing of all bukti pelanggaran.
     * Optional filter by pelanggaran_id via ?pelanggaran_id=.
     */
    public function index(Request $request)
    {
        $query = BuktiPelanggaran::query()->with('pelanggaran')->orderByDesc('id_bukti');

        if ($request->filled('pelanggaran_id')) {
            $query->where('id_pelanggaran', $request->pelanggaran_id);
        }

        $bukti = $query->paginate(15)->withQueryString();

        return view('bukti-pelanggaran.index', compact('bukti'));
    }

    /**
     * Show the form for creating a new lampiran.
     */
    public function create(Pelanggaran $pelanggaran)
    {
        $this->authorizeInput();

        return view('bukti-pelanggaran.create', compact('pelanggaran'));
    }

    /**
     * Store a newly created lampiran.
     */
    public function store(Request $request, Pelanggaran $pelanggaran)
    {
        $this->authorizeInput();

        $data = $request->validate([
            'jenis_bukti' => ['required', 'in:foto,video,catatan_saksi,lainnya'],
            'file'        => ['nullable', 'file', 'max:10240'], // 10MB
            'keterangan'  => ['nullable', 'string'],
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store(
                'bukti-pelanggaran/' . $pelanggaran->id_pelanggaran,
                'public'
            );
        }

        BuktiPelanggaran::create([
            'id_pelanggaran' => $pelanggaran->id_pelanggaran,
            'jenis_bukti'    => $data['jenis_bukti'],
            'file_path'      => $filePath,
            'keterangan'     => $data['keterangan'] ?? null,
        ]);

        return redirect()
            ->route('pelanggaran.show', $pelanggaran)
            ->with('success', 'Lampiran bukti berhasil ditambahkan.');
    }

    /**
     * Show lampiran (opsional; redirect ke file bila ada).
     */
    public function show(BuktiPelanggaran $buktiPelanggaran)
    {
        if ($buktiPelanggaran->file_path && Storage::disk('public')->exists($buktiPelanggaran->file_path)) {
            return response()->file(Storage::disk('public')->path($buktiPelanggaran->file_path));
        }

        return back()->with('error', 'File tidak ditemukan.');
    }

    /**
     * Remove the specified lampiran.
     */
    public function destroy(BuktiPelanggaran $buktiPelanggaran)
    {
        $this->authorizeInput();

        $pelanggaranId = $buktiPelanggaran->id_pelanggaran;

        if ($buktiPelanggaran->file_path && Storage::disk('public')->exists($buktiPelanggaran->file_path)) {
            Storage::disk('public')->delete($buktiPelanggaran->file_path);
        }

        $buktiPelanggaran->delete();

        return redirect()
            ->route('pelanggaran.show', $pelanggaranId)
            ->with('success', 'Lampiran bukti dihapus.');
    }

    /**
     * Wali kelas & Kesiswaan yang boleh kelola lampiran bukti.
     */
    protected function authorizeInput(): void
    {
        $role = Auth::user()?->role;
        abort_unless(in_array($role, ['Wali kelas', 'Kesiswaan'], true), 403);
    }
}