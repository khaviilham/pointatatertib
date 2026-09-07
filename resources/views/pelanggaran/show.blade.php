<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pelanggaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Informasi Pelanggaran</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('pelanggaran.index') }}" class="px-3 py-2 bg-gray-200 text-gray-800 rounded-md text-sm">Kembali</a>
                            @if (in_array(auth()->user()->role, ['Wali kelas', 'Kesiswaan'], true))
                                <a href="{{ route('pelanggaran.edit', $pelanggaran) }}" class="px-3 py-2 bg-yellow-500 text-white rounded-md text-sm">Edit</a>
                                <form method="POST" action="{{ route('pelanggaran.destroy', $pelanggaran) }}" onsubmit="return confirm('Hapus pelanggaran ini? Poin siswa akan dikurangi.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-2 bg-red-600 text-white rounded-md text-sm">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500">Siswa</dt>
                            <dd class="font-medium">{{ $pelanggaran->siswa->nama ?? '-' }} ({{ $pelanggaran->siswa->kelas->nama_kelas ?? '-' }})</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Jenis Pelanggaran</dt>
                            <dd class="font-medium">{{ $pelanggaran->jenisPelanggaran->nama_pelanggaran ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Poin</dt>
                            <dd class="font-medium">{{ $pelanggaran->poin }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Status</dt>
                            <dd class="font-medium">{{ $pelanggaran->status }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Tanggal</dt>
                            <dd class="font-medium">{{ $pelanggaran->tanggal->format('d-m-Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Waktu</dt>
                            <dd class="font-medium">{{ $pelanggaran->waktu_kejadian ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Lokasi</dt>
                            <dd class="font-medium">{{ $pelanggaran->lokasi }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Total Poin Siswa Saat Ini</dt>
                            <dd class="font-medium">{{ $pelanggaran->siswa->total_point ?? 0 }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-gray-500">Kronologi</dt>
                            <dd class="font-medium whitespace-pre-line">{{ $pelanggaran->kronologi ?? '-' }}</dd>
                        </div>
                    </dl>

                    <hr class="my-6">

                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-md font-semibold">Bukti Pelanggaran</h4>
                        @if (in_array(auth()->user()->role, ['Wali kelas', 'Kesiswaan'], true))
                            <a href="{{ route('bukti-pelanggaran.create', ['pelanggaran' => $pelanggaran->id_pelanggaran]) }}" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm">+ Tambah Bukti</a>
                        @endif
                    </div>
                    @if ($pelanggaran->buktiPelanggaran && $pelanggaran->buktiPelanggaran->count())
                        <ul class="space-y-1 text-sm">
                            @foreach ($pelanggaran->buktiPelanggaran as $b)
                                <li class="flex items-center justify-between border-b py-1">
                                    <a href="{{ route('bukti-pelanggaran.show', $b) }}" class="text-indigo-600 hover:underline">{{ $b->file_path }}</a>
                                    <span class="text-xs text-gray-500">{{ $b->created_at?->format('d-m-Y H:i') }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">Belum ada bukti.</p>
                    @endif

                    <hr class="my-6">

                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-md font-semibold">Tindak Lanjut</h4>
                        @if (auth()->user()->role === 'BK')
                            <a href="{{ route('tindak-lanjut.create', ['pelanggaran_id' => $pelanggaran->id_pelanggaran]) }}" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm">+ Tambah Tindak Lanjut</a>
                        @endif
                    </div>
                    @if ($pelanggaran->tindakLanjut && $pelanggaran->tindakLanjut->count())
                        <ul class="space-y-1 text-sm">
                            @foreach ($pelanggaran->tindakLanjut as $t)
                                <li class="border-b py-1">
                                    <a href="{{ route('tindak-lanjut.show', $t) }}" class="text-indigo-600 hover:underline">{{ $t->jenis_tindakan }}</a>
                                    <span class="text-xs text-gray-500 ml-2">{{ $t->tanggal }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-sm text-gray-500">Belum ada tindak lanjut.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>