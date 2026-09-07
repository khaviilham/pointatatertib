<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Tindak Lanjut') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if ($errors->any())
                        <div class="mb-4 px-4 py-3 rounded bg-red-100 text-red-800 border border-red-200">
                            <ul class="list-disc list-inside text-sm">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('tindak-lanjut.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Pelanggaran</label>
                            <select name="id_pelanggaran" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Pilih Pelanggaran --</option>
                                @foreach ($pelanggaranList as $p)
                                    <option value="{{ $p->id_pelanggaran }}" {{ (string) old('id_pelanggaran', request('pelanggaran_id')) === (string) $p->id_pelanggaran ? 'selected' : '' }}>
                                        #{{ $p->id_pelanggaran }} - {{ $p->siswa->nama ?? '-' }} ({{ $p->tanggal->format('d-m-Y') }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Jenis Tindakan</label>
                            <input type="text" name="jenis_tindakan" value="{{ old('jenis_tindakan') }}" required maxlength="100" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Hasil (opsional)</label>
                            <textarea name="hasil" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('hasil') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('tindak-lanjut.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>