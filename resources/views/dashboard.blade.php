<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p class="mb-1">Selamat datang, <span class="font-semibold">{{ auth()->user()->nama }}</span>.</p>
                    <p class="text-sm text-gray-600">Role: <span class="font-medium">{{ auth()->user()->role }}</span></p>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                @if (in_array(auth()->user()->role, ['Wali kelas', 'Kesiswaan', 'BK'], true))
                    <a href="{{ route('pelanggaran.index') }}" class="block bg-white shadow-sm rounded-lg p-5 hover:bg-gray-50">
                        <div class="text-sm text-gray-500">Modul</div>
                        <div class="text-lg font-semibold">Pelanggaran</div>
                    </a>
                @endif
                @if (in_array(auth()->user()->role, ['Wali kelas', 'Kesiswaan'], true))
                    <a href="{{ route('bukti-pelanggaran.index') }}" class="block bg-white shadow-sm rounded-lg p-5 hover:bg-gray-50">
                        <div class="text-sm text-gray-500">Modul</div>
                        <div class="text-lg font-semibold">Bukti Pelanggaran</div>
                    </a>
                @endif
                @if (auth()->user()->role === 'BK')
                    <a href="{{ route('tindak-lanjut.index') }}" class="block bg-white shadow-sm rounded-lg p-5 hover:bg-gray-50">
                        <div class="text-sm text-gray-500">Modul</div>
                        <div class="text-lg font-semibold">Tindak Lanjut</div>
                    </a>
                    <a href="{{ route('konseling.index') }}" class="block bg-white shadow-sm rounded-lg p-5 hover:bg-gray-50">
                        <div class="text-sm text-gray-500">Modul</div>
                        <div class="text-lg font-semibold">Konseling</div>
                    </a>
                    <a href="{{ route('sesi-konseling.index') }}" class="block bg-white shadow-sm rounded-lg p-5 hover:bg-gray-50">
                        <div class="text-sm text-gray-500">Modul</div>
                        <div class="text-lg font-semibold">Sesi Konseling</div>
                    </a>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
