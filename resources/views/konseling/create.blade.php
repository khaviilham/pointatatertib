<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Konseling') }}
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

                    <form method="POST" action="{{ route('konseling.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                            <input type="date" name="tanggal" value="{{ old('tanggal', date('Y-m-d')) }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Permasalahan</label>
                            <textarea name="permasalahan" rows="4" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('permasalahan') }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Solusi Bimbingan (opsional)</label>
                            <textarea name="solusi_bimbingan" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('solusi_bimbingan') }}</textarea>
                        </div>

                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('konseling.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm">Batal</a>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>