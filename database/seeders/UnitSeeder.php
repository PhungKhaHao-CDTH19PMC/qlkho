<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = ['Chiếc', 'Hộp', 'Thùng', 'Que'];
        foreach ($units as $unit) {
            Unit::create([
                'name'  => $unit
            ]);
        }
    }
}
