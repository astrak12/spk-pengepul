<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manajemen Akun Pengguna
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                    <strong>Berhasil!</strong> {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-green-600">
                <div class="p-6 text-gray-900">
                    
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-700">Daftar Pengguna Sistem</h3>
                        <a href="{{ route('user.create') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg shadow transition-colors">
                            + Tambah Pengguna
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 border">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100 border-b">
                                <tr>
                                    <th scope="col" class="px-6 py-4">No</th>
                                    <th scope="col" class="px-6 py-4">Nama Lengkap</th>
                                    <th scope="col" class="px-6 py-4">Email</th>
                                    <th scope="col" class="px-6 py-4">Hak Akses (Role)</th>
                                    <th scope="col" class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $key => $u)
                                    <tr class="bg-white border-b hover:bg-green-50 transition-colors">
                                        <td class="px-6 py-4 font-medium text-gray-900">{{ $key + 1 }}</td>
                                        <td class="px-6 py-4 font-bold">{{ $u->name }}</td>
                                        <td class="px-6 py-4">{{ $u->email }}</td>
                                        <td class="px-6 py-4">
                                            @if($u->role == 'admin')
                                                <span class="bg-red-100 text-red-800 text-xs font-bold px-3 py-1 rounded-full border border-red-300 uppercase">Admin</span>
                                            @elseif($u->role == 'pimpinan')
                                                <span class="bg-blue-100 text-blue-800 text-xs font-bold px-3 py-1 rounded-full border border-blue-300 uppercase">Pimpinan</span>
                                            @else
                                                <span class="bg-gray-100 text-gray-800 text-xs font-bold px-3 py-1 rounded-full border border-gray-300 uppercase">Operator</span>
                                            @endif
                                        </td>
                                       <td class="px-6 py-4 text-center flex justify-center space-x-4">
    <a href="{{ route('user.edit', $u->id) }}" class="text-blue-600 hover:underline font-semibold mt-1">Edit</a>
    
    <form action="{{ route('user.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus akun {{ $u->name }} ini?');">
        @csrf
        @method('DELETE')
        <button type="submit" class="text-red-600 hover:underline font-semibold bg-transparent border-none cursor-pointer">Hapus</button>
    </form>
</td>
                                            
                                            <form action="{{ route('user.destroy', $u->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-white bg-red-500 hover:bg-red-600 font-medium rounded text-xs px-3 py-2 shadow" onclick="return confirm('Yakin ingin menghapus akun {{ $u->name }} ini?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500 font-bold">Belum ada data pengguna.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>