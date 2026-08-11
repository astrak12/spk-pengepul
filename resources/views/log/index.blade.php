<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Log Aktivitas Sistem
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-gray-800">

                <h3 class="text-lg font-bold text-gray-700 mb-4">Riwayat Tindakan Pengguna</h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 border">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 border">Waktu aktivitas</th>
                                <th class="px-6 py-3 border">Pengguna</th>
                                <th class="px-6 py-3 border">Aksi</th>
                                <th class="px-6 py-3 border">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 border text-gray-900 font-semibold">
                                        {{ $log->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="px-6 py-4 border">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-bold px-2 py-1 rounded">
                                            {{ $log->user->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 border font-bold text-gray-700">{{ $log->action }}</td>
                                    <td class="px-6 py-4 border">{{ $log->description }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500 border">
                                        Belum ada aktivitas yang tercatat.
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