<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Bukti Pelanggaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold">Bukti #{{ $bukti->id_bukti }}</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('bukti-pelanggaran.index') }}" class="px-3 py-2 bg-gray-200 text-gray-800 rounded-md text-sm">Kembali</a>
                            @if (in_array(auth()->user()->role, ['Wali kelas', 'Kesiswaan'], true))
                                <form method="POST" action="{{ route('bukti-pelanggaran.destroy', $bukti) }}" onsubmit="return confirm('Hapus bukti ini?')">
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
                                @if ($bukti->pelanggaran)
                                    <a href="{{ route('pelanggaran.show', $bukti->pelanggaran) }}" class="text-indigo-600 hover:underline">
                                        #{{ $bukti->pelanggaran->id_pelanggaran }}
                                    </a>
                                @else
                                    -
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-gray-500">Uploaded</dt>
                            <dd class="font-medium">{{ $bukti->created_at?->format('d-m-Y H:i') }}</dd>
                        </div>
                        <div class="md:col-span-2">
                            <dt class="text-gray-500">File</dt>
                            <dd class="font-medium break-all">
                                @php
                                    $url = asset('storage/' . $bukti->file_path);
                                @endphp
                                <a href="{{ $url }}" target="_blank" class="text-indigo-600 hover:underline">{{ $bukti->file_path }}</a>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>