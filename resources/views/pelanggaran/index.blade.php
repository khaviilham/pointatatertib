<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Pelanggaran') }}
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
                        <form method="GET" action="{{ route('pelanggaran.index') }}" class="flex flex-wrap gap-2 items-end">
                            <div>
                                <label class="block text-xs text-gray-600">Dari</label>
                                <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="border-gray-300 rounded-md shadow-sm text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600">Sampai</label>
                                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="border-gray-300 rounded-md shadow-sm text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-600">Status</label>
                                <input type="text" name="status" value="{{ request('status') }}" class="border-gray-300 rounded-md shadow-sm text-sm" placeholder="status">
                            </div>
                            <button class="px-3 py-2 bg-gray-800 text-white rounded-md text-sm">Filter</button>
                        </form>

                        @if (in_array(auth()->user()->role, ['Wali kelas', 'Kesiswaan'], true))
                            <a href="{{ route('pelanggaran.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">+ Catat Pelanggaran</a>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="px-3 py-2">#</th>
                                    <th class="px-3 py-2">Tanggal</th>
                                    <th class="px-3 py-2">Siswa</th>
                                    <th class="px-3 py-2">Kelas</th>
                                    <th class="px-3 py-2">Jenis</th>
                                    <th class="px-3 py-2">Poin</th>
                                    <th class="px-3 py-2">Status</th>
                                    <th class="px-3 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pelanggaran as $item)
                                    <tr class="border-b">
                                        <td class="px-3 py-2">{{ $loop->iteration + ($pelanggaran->currentPage() - 1) * $pelanggaran->perPage() }}</td>
                                        <td class="px-3 py-2">{{ $item->tanggal->format('d-m-Y') }}</td>
                                        <td class="px-3 py-2">{{ $item->siswa->nama ?? '-' }}</td>
                                        <td class="px-3 py-2">{{ $item->siswa->kelas->nama_kelas ?? '-' }}</td>
                                        <td class="px-3 py-2">{{ $item->jenisPelanggaran->nama_pelanggaran ?? '-' }}</td>
                                        <td class="px-3 py-2">{{ $item->poin }}</td>
                                        <td class="px-3 py-2">{{ $item->status }}</td>
                                        <td class="px-3 py-2">
                                            <a href="{{ route('pelanggaran.show', $item) }}" class="text-indigo-600 hover:underline">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="px-3 py-4 text-center text-gray-500">Belum ada data pelanggaran.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $pelanggaran->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>