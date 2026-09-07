<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Konseling #{{ $konseling->id_konseling }}</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('konseling.index') }}" class="px-3 py-2 bg-gray-200 text-gray-800 rounded-md text-sm">Kembali</a>
                            @if (auth()->user()->role === 'BK')
                                <a href="{{ route('konseling.edit', $konseling) }}" class="px-3 py-2 bg-yellow-500 text-white rounded-md text-sm">Edit</a>
                                <form method="POST" action="{{ route('konseling.destroy', $konseling) }}" onsubmit="return confirm('Hapus konseling ini? Sesi terkait juga akan dihapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="px-3 py-2 bg-red-600 text-white rounded-md text-sm">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                        <div>
                            <dt class="text-gray-500">Tanggal</dt>
                            <dd class="font-medium">{{ $konseling->tanggal?->format('d-m-Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Jumlah Sesi</dt>
                            <dd class="font-medium">{{ $konseling->sesiKonseling->count() }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-gray-500">Permasalahan</dt>
                            <dd class="font-medium whitespace-pre-line">{{ $konseling->permasalahan }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-gray-500">Solusi Bimbingan</dt>
                            <dd class="font-medium whitespace-pre-line">{{ $konseling->solusi_bimbingan ?? '-' }}</dd>
                        </div>
                    </dl>

                    <hr class="my-6">

                    <div class="flex items-center justify-between mb-2">
                        <h4 class="text-md font-semibold">Sesi Konseling</h4>
                        @if (auth()->user()->role === 'BK')
                            <a href="{{ route('sesi-konseling.create', ['id_konseling' => $konseling->id_konseling]) }}" class="px-3 py-2 bg-indigo-600 text-white rounded-md text-sm">+ Tambah Sesi</a>
                        @endif
                    </div>
                    @if ($konseling->sesiKonseling && $konseling->sesiKonseling->count())
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="bg-gray-100 text-left">
                                        <th class="px-3 py-2">#</th>
                                        <th class="px-3 py-2">Tanggal</th>
                                        <th class="px-3 py-2">Siswa</th>
                                        <th class="px-3 py-2">Permasalahan</th>
                                        <th class="px-3 py-2">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($konseling->sesiKonseling as $s)
                                        <tr class="border-b">
                                            <td class="px-3 py-2">{{ $loop->iteration }}</td>
                                            <td class="px-3 py-2">{{ $s->tanggal?->format('d-m-Y') }}</td>
                                            <td class="px-3 py-2">{{ $s->siswa->nama ?? '-' }}</td>
                                            <td class="px-3 py-2">{{ \Illuminate\Support\Str::limit($s->permasalahan, 50) }}</td>
                                            <td class="px-3 py-2">
                                                <a href="{{ route('sesi-konseling.show', $s) }}" class="text-indigo-600 hover:underline">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Belum ada sesi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>