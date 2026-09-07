<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Tindak Lanjut') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Tindak Lanjut #{{ $tindakLanjut->id_tindak_lanjut }}</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('tindak-lanjut.index') }}" class="px-3 py-2 bg-gray-200 text-gray-800 rounded-md text-sm">Kembali</a>
                            @if (auth()->user()->role === 'BK')
                                <a href="{{ route('tindak-lanjut.edit', $tindakLanjut) }}" class="px-3 py-2 bg-yellow-500 text-white rounded-md text-sm">Edit</a>
                                <form method="POST" action="{{ route('tindak-lanjut.destroy', $tindakLanjut) }}" onsubmit="return confirm('Hapus tindak lanjut ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-2 bg-red-600 text-white rounded-md text-sm">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500">Pelanggaran</dt>
                            <dd class="font-medium">
                                @if ($tindakLanjut->pelanggaran)
                                    <a href="{{ route('pelanggaran.show', $tindakLanjut->pelanggaran) }}" class="text-indigo-600 hover:underline">
                                        #{{ $tindakLanjut->pelanggaran->id_pelanggaran }} - {{ $tindakLanjut->pelanggaran->siswa->nama ?? '-' }}
                                    </a>
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Tanggal</dt>
                            <dd class="font-medium">{{ $tindakLanjut->tanggal?->format('d-m-Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Jenis Tindakan</dt>
                            <dd class="font-medium">{{ $tindakLanjut->jenis_tindakan }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Petugas (BK)</dt>
                            <dd class="font-medium">{{ $tindakLanjut->user->nama ?? '-' }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-gray-500">Hasil</dt>
                            <dd class="font-medium whitespace-pre-line">{{ $tindakLanjut->hasil ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>