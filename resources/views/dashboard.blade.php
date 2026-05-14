<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700/50">
            <p class="text-sm text-gray-400">Total Item</p>
            <p class="text-2xl font-semibold text-white mt-1">0</p>
        </div>
        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700/50">
            <p class="text-sm text-gray-400">Transaksi Hari Ini</p>
            <p class="text-2xl font-semibold text-white mt-1">0</p>
        </div>
        <div class="bg-gray-800 rounded-lg p-6 border border-gray-700/50">
            <p class="text-sm text-gray-400">Stok Hampir Habis</p>
            <p class="text-2xl font-semibold text-white mt-1">0</p>
        </div>
    </div>

</x-app-layout>