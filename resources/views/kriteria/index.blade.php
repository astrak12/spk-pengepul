<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Kriteria') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow">
                        {{ session('success') }}
                    </div>
                @endif

                @if(Auth::user()->role == 'admin')
                    <a href="{{ route('kriteria.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors inline-block mb-4">
                        + Tambah Kriteria
                    </a>
                @endif

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 border">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 border">Kode Kriteria</th>
                                <th class="px-6 py-3 border">Nama Kriteria</th>
                                <th class="px-6 py-3 border">Bobot</th>
                                <th class="px-6 py-3 border">Jenis</th>
                                
                                @if(Auth::user()->role == 'admin')
                                    <th scope="col" class="px-6 py-4 text-center border">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($kriterias as $kriteria)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 border">{{ $kriteria->kode_kriteria }}</td>
                                    <td class="px-6 py-4 border font-semibold text-gray-900">{{ $kriteria->nama_kriteria }}</td>
                                    <td class="px-6 py-4 border">{{ $kriteria->bobot }}</td>
                                    <td class="px-6 py-4 border uppercase">{{ $kriteria->jenis }}</td>
                                    
                                    @if(Auth::user()->role == 'admin')
                                        <td class="px-6 py-4 border text-center flex justify-center space-x-4">
                                            <a href="{{ route('kriteria.edit', $kriteria->id) }}" class="text-blue-600 hover:underline font-semibold">Edit</a>
                                            
                                            <form action="{{ route('kriteria.destroy', $kriteria->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus kriteria ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:underline font-semibold">Hapus</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ Auth::user()->role == 'admin' ? '5' : '4' }}" class="px-6 py-4 text-center text-gray-500 border">
                                        Belum ada data kriteria.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>