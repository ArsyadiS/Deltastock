<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Division;
use App\Models\Warehouse;
use App\Models\Unit;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //divisi
        $divisions = [
            ['name' => 'Bahan Baku', 'code' => 'BB', 'description' => 'Material mentah untuk produksi kosmetik'],
            ['name' => 'Bahan Kemas', 'code' => 'BK', 'description' => 'Material untuk bahan pengemas produk'],
            ['name' => 'Produk Jadi', 'code' => 'PJ', 'description' => 'Produk kosmetik hasil produksi'],
        ];

        foreach ($divisions as $division) {
            $div = Division::firstOrCreate(['code' => $division['code']], $division);

            //gudang
            Warehouse::firstOrCreate(
                ['code' => 'GDG-' . $division['code']],
                [
                    'division_id' => $div->id,
                    'name' => 'Gudang ' . $division['name'],
                    'code' => 'GDG-' . $division['code'],
                    'description' => 'Gudang Utama ' . $division['name'],
                ]
            );
        }

        //satuan
        $units = [
            ['name' => 'Kilogram', 'symbol'=> 'kg'],
            ['name' => 'Gram', 'symbol' => 'g'],
            ['name' => 'Liter', 'symbol' => 'l'],
            ['name' => 'Milimeter', 'symbol' => 'm'],
            ['name' => 'Pieces', 'symbol' => 'pcs'],
            ['name' => 'Box', 'symbol' => 'box'],
            ['name' => 'Drum', 'symbol' => 'drum'],
            ['name' => 'Jerigen', 'symbol' => 'jrg'],
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(['symbol' => $unit['symbol']], $unit);
        }

        $this->command->info('Master data berhasil dibuat!');
    }
}