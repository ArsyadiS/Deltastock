<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Divisi') }}
        </h2>
    </x-slot>

    <div x-data="{ 
        showCreate: false, 
        showEdit: false, 
        editAction: '',
        division: {
            code: '',
            name: '',
            description: '',
            active: true
        }
    }"
    x-on:open-create-modal.window="showCreate = true"
    class="py-12 bg-gray-50 min-h-screen"> <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-bind:class="showCreate || showEdit ? 'blur-sm pointer-events-none' : ''" class="transition duration-200">
                
                {{-- Header Section --}}
                <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Divisi</h1>
                        <p class="text-sm text-gray-500 mt-1">Kelola struktur organisasi dan kategori divisi perusahaan.</p>
                    </div>
                    <button @click="$dispatch('open-create-modal')"
                        class="inline-flex items-center justify-center bg-indigo-600 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-indigo-300 transition-all active:scale-95">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Tambah Divisi
                    </button>
                </div>

                {{-- Alerts --}}
                @if(session('success'))
                    <div class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 px-4 py-4 rounded-r-lg shadow-sm flex items-center">
                        <svg class="w-5 h-5 mr-3 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                {{-- Tabel Card --}}
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50/80"> <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Kode</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Nama Divisi</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Deskripsi</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($divisions as $item)
                                <tr class="hover:bg-indigo-50/30 transition-colors group">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-mono font-bold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                            {{ $item->code }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $item->name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">{{ $item->description ?? '-' }}</td>
                                    <td class="px-6 py-4 text-center">
                                        @if($item->active)
                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold bg-emerald-100 text-emerald-700 rounded-full">
                                                <span class="w-1.5 h-1.5 mr-1.5 bg-emerald-500 rounded-full"></span> Aktif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 text-xs font-bold bg-gray-100 text-gray-500 rounded-full">
                                                <span class="w-1.5 h-1.5 mr-1.5 bg-gray-400 rounded-full"></span> Nonaktif
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-right space-x-2">
                                        <button
                                            @click="
                                                showEdit = true;
                                                editAction = '{{ route('divisions.update', $item) }}';
                                                division = {
                                                    code: '{{ $item->code }}',
                                                    name: '{{ $item->name }}',
                                                    description: '{{ addslashes($item->description) }}',
                                                    active: {{ $item->active ? 'true' : 'false' }}
                                                }
                                            "
                                            class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-lg text-xs font-bold text-gray-700 shadow-sm hover:bg-gray-50 hover:text-indigo-600 transition-all">
                                            Edit
                                        </button>
                                        
                                        <form action="{{ route('divisions.destroy', $item) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus divisi {{ $item->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-white border border-red-100 rounded-lg text-xs font-bold text-red-600 shadow-sm hover:bg-red-50 transition-all">
                                                Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-200 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                            <p class="text-gray-400 italic">Belum ada data divisi.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $divisions->links() }}
                </div>
            </div>

            {{-- Modal - Modalnya tetap bersih tapi inputannya diberi fokus indigo yang jelas --}}
            </div>
    </div>
</x-app-layout>