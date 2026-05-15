<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Master Divisi</h2>
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
    class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-bind:class="showCreate || showEdit ? 'blur-sm pointer-events-none' : ''" class="transition duration-200">
                
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Daftar Divisi</h1>
                        <p class="text-sm text-gray-500">Kelola data divisi perusahaan dengan mudah.</p>
                    </div>
                    <button @click="$dispatch('open-create-modal')"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-semibold shadow-sm hover:bg-indigo-700 transition focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        + Tambah Divisi
                    </button>
                </div>

                {{-- Alert Success --}}
                @if(session('success'))
                    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Alert Error --}}
                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Tabel --}}
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kode</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Divisi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Deskripsi</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($divisions as $item)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 text-sm font-mono font-bold text-indigo-600">{{ $item->code }}</td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $item->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $item->description ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    @if($item->active)
                                        <span class="px-2.5 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">Aktif</span>
                                    @else
                                        <span class="px-2.5 py-1 text-xs font-semibold bg-gray-100 text-gray-600 rounded-full">Nonaktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-right space-x-3">
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
                                        class="text-indigo-600 hover:text-indigo-900 font-semibold transition-colors">
                                        Edit
                                    </button>
                                    
                                    <form action="{{ route('divisions.destroy', $item) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus divisi {{ $item->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 font-semibold transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center text-sm text-gray-400 italic">
                                    Belum ada data divisi yang tersedia.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $divisions->links() }}
                </div>
            </div>

            {{-- ── Modal Tambah ── --}}
            <div x-show="showCreate"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 z-50 overflow-y-auto"
                 style="display: none;">

                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm" @click="showCreate = false"></div>

                    <div class="bg-white border border-gray-200 rounded-xl shadow-xl w-full max-w-lg z-10 relative">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900">Tambah Divisi Baru</h3>
                            <button @click="showCreate = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <form action="{{ route('divisions.store') }}" method="POST" class="p-6 space-y-5">
                            @csrf
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Kode Divisi <span class="text-red-500">*</span></label>
                                <input type="text" name="code"
                                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 uppercase transition"
                                    placeholder="Contoh: BB" maxlength="10" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Divisi <span class="text-red-500">*</span></label>
                                <input type="text" name="name"
                                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                    placeholder="Contoh: Bahan Baku" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                                <textarea name="description" rows="3"
                                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                    placeholder="Keterangan singkat mengenai divisi..."></textarea>
                            </div>

                            <div class="flex items-center gap-2 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <input type="hidden" name="active" value="0">
                                <input type="checkbox" name="active" value="1" checked id="active_create"
                                    class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="active_create" class="text-sm font-medium text-gray-700 cursor-pointer">Divisi ini aktif</label>
                            </div>

                            <div class="flex justify-end gap-3 pt-4">
                                <button type="button" @click="showCreate = false"
                                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 shadow-sm transition">
                                    Simpan Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- ── Modal Edit ── --}}
            <div x-show="showEdit"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="fixed inset-0 z-50 overflow-y-auto"
                 style="display: none;">

                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-gray-500/75 backdrop-blur-sm" @click="showEdit = false"></div>

                    <div class="bg-white border border-gray-200 rounded-xl shadow-xl w-full max-w-lg z-10 relative">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="text-lg font-bold text-gray-900">Edit Data Divisi</h3>
                            <button @click="showEdit = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <form :action="editAction" method="POST" class="p-6 space-y-5">
                            @csrf
                            @method('PUT')

                            <div>
                                <label class="block text-sm font-semibold text-gray-500 mb-1.5">Kode Divisi</label>
                                <input type="text" name="code" x-model="division.code"
                                    class="w-full bg-white border border-gray-200 text-black rounded-lg px-3 py-2.5 text-sm uppercase font-mono">
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Divisi <span class="text-red-500">*</span></label>
                                <input type="text" name="name" x-model="division.name"
                                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"
                                    required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                                <textarea name="description" x-model="division.description" rows="3"
                                    class="w-full bg-gray-50 border border-gray-300 text-gray-900 rounded-lg px-3 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition"></textarea>
                            </div>

                            <div class="flex items-center gap-2 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                <input type="hidden" name="active" value="0">
                                <input type="checkbox" name="active" value="1"
                                    :checked="division.active"
                                    @change="division.active = $el.checked"
                                    id="active_edit"
                                    class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                <label for="active_edit" class="text-sm font-medium text-gray-700 cursor-pointer">Divisi ini aktif</label>
                            </div>

                            <div class="flex justify-end gap-3 pt-4">
                                <button type="button" @click="showEdit = false"
                                    class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-indigo-600 text-white px-8 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700 shadow-sm transition">
                                    Perbarui Data
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>