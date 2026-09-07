<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Sesi Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Sesi Konseling #{{ $sesiKonseling->id_sesi }}</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('sesi-konseling.index') }}" class="px-3 py-2 bg-gray-200 text-gray-800 rounded-md text-sm">Kembali</a>
                            @if (auth()->user()->role === 'BK')
                                <a href="{{ route('sesi-konseling.edit', $sesiKonseling) }}" class="px-3 py-2 bg-yellow-500 text-white rounded-md text-sm">Edit</a>
                                <form method="POST" action="{{ route('sesi-konseling.destroy', $sesiKonseling) }}" onsubmit="return confirm('Hapus sesi konseling ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-2 bg-red-600 text-white rounded-md text-sm">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500">Konseling</dt>
                            <dd class="font-medium">
                                @if ($sesiKonseling->konseling)
                                    <a href="{{ route('konseling.show', $sesiKonseling->konseling) }}" class="text-indigo-600 hover:underline">
                                        #{{ $sesiKonseling->konseling->id_konseling }}
                                    </a>
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Tanggal</dt>
                            <dd class="font-medium">{{ $sesiKonseling->tanggal?->format('d-m-Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Siswa</dt>
                            <dd class="font-medium">{{ $sesiKonseling->siswa->nama ?? '-' }} ({{ $sesiKonseling->siswa->kelas->nama_kelas ?? '-' }})</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Petugas (BK)</dt>
                            <dd class="font-medium">{{ $sesiKonseling->user->nama ?? '-' }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-gray-500">Permasalahan</dt>
                            <dd class="font-medium whitespace-pre-line">{{ $sesiKonseling->permasalahan }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-gray-500">Solusi</dt>
                            <dd class="font-medium whitespace-pre-line">{{ $sesiKonseling->solusi ?? '-' }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-gray-500">Hasil</dt>
                            <dd class="font-medium whitespace-pre-line">{{ $sesiKonseling->hasil ?? '-' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>