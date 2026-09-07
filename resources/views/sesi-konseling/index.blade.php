<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Sesi Konseling') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800 border border-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex items-center justify-between mb-4">
                        <form method="GET" action="{{ route('sesi-konseling.index') }}" class="flex flex-wrap gap-2 items-end">
                            <div>
                                <label class="block text-xs text-gray-600">Dari</label>
                                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="border-gray-300 rounded-md shadow-sm text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600">Sampai</label>
                                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="border-gray-300 rounded-md shadow-sm text-sm">
                            </div>
                            <button class="px-3 py-2 bg-gray-800 text-white rounded-md text-sm">Filter</button>
                        </form>

                        @if (auth()->user()->role === 'BK')
                            <a href="{{ route('sesi-konseling.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">+ Tambah Sesi</a>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="px-3 py-2">#</th>
                                    <th class="px-3 py-2">Tanggal</th>
                                    <th class="px-3 py-2">Konseling</th>
                                    <th class="px-3 py-2">Siswa</th>
                                    <th class="px-3 py-2">Kelas</th>
                                    <th class="px-3 py-2">Petugas (BK)</th>
                                    <th class="px-3 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($sesiKonseling as $item)
                                    <tr class="border-b">
                                        <td class="px-3 py-2">{{ $loop->iteration + ($sesiKonseling->currentPage() - 1) * $sesiKonseling->perPage() }}</td>
                                        <td class="px-3 py-2">{{ $item->tanggal?->format('d-m-Y') }}</td>
                                        <td class="px-3 py-2">
                                            @if ($item->konseling)
                                                <a href="{{ route('konseling.show', $item->konseling) }}" class="text-indigo-600 hover:underline">#{{ $item->konseling->id_konseling }}</a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-3 py-2">{{ $item->siswa->nama ?? '-' }}</td>
                                        <td class="px-3 py-2">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                                        <td class="px-3 py-2">{{ $item->user->nama ?? '-' }}</td>
                                        <td class="px-3 py-2">
                                            <a href="{{ route('sesi-konseling.show', $item) }}" class="text-indigo-600 hover:underline">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="7" class="px-3 py-4 text-center text-gray-500">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $sesiKonseling->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>