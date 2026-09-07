<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bukti Pelanggaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (session('success'))
                        <div class="mb-4 px-4 py-3 rounded bg-green-100 text-green-800 border border-green-200">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="flex items-center justify-between mb-4">
                        <form method="GET" action="{{ route('bukti-pelanggaran.index') }}" class="flex gap-2 items-end">
                            <div>
                                <label class="block text-xs text-gray-600">ID Pelanggaran</label>
                                <input type="text" name="pelanggaran_id" value="{{ request('pelanggaran_id') }}" class="border-gray-300 rounded-md shadow-sm text-sm">
                            </div>
                            <button class="px-3 py-2 bg-gray-800 text-white rounded-md text-sm">Filter</button>
                        </form>

                        @if (in_array(auth()->user()->role, ['Wali kelas', 'Kesiswaan'], true) && request('pelanggaran_id'))
                            <a href="{{ route('bukti-pelanggaran.create', ['pelanggaran' => request('pelanggaran_id')]) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">+ Upload Bukti</a>
                        @elseif (in_array(auth()->user()->role, ['Wali kelas', 'Kesiswaan'], true))
                            <a href="{{ route('pelanggaran.index') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">Pilih Pelanggaran</a>
                        @endif
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="bg-gray-100 text-left">
                                    <th class="px-3 py-2">#</th>
                                    <th class="px-3 py-2">Pelanggaran</th>
                                    <th class="px-3 py-2">File</th>
                                    <th class="px-3 py-2">Uploaded</th>
                                    <th class="px-3 py-2">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($bukti as $item)
                                    <tr class="border-b">
                                        <td class="px-3 py-2">{{ $loop->iteration + ($bukti->currentPage() - 1) * $bukti->perPage() }}</td>
                                        <td class="px-3 py-2">{{ $item->pelanggaran->id_pelanggaran ?? '-' }}</td>
                                        <td class="px-3 py-2">{{ $item->file_path }}</td>
                                        <td class="px-3 py-2">{{ $item->created_at?->format('d-m-Y H:i') }}</td>
                                        <td class="px-3 py-2">
                                            <a href="{{ route('bukti-pelanggaran.show', $item) }}" class="text-indigo-600 hover:underline">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="px-3 py-4 text-center text-gray-500">Belum ada bukti.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $bukti->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>