<?php

use App\Cable;
use Illuminate\Database\Seeder;

class CableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cable::create([
            'name' => 'ВВГ',
            'count' => 2,
            'weight' => 1.5
        ]);

        Cable::create([
            'name' => 'ВВГ',
            'count' => 2,
            'weight' => 4
        ]);

        Cable::create([
            'name' => 'ВВГ',
            'count' => 3,
            'weight' => 1.5
        ]);

        Cable::create([
            'name' => 'ВВГ',
            'count' => 3,
            'weight' => 2.5
        ]);

        Cable::create([
            'name' => 'ВВГ',
            'count' => 3,
            'weight' => 4
        ]);

        Cable::create([
            'name' => 'ВВГ',
            'count' => 4,
            'weight' => 1.5
        ]);

        Cable::create([
            'name' => 'ВВГ',
            'count' => 4,
            'weight' => 2.5
        ]);

        Cable::create([
            'name' => 'ВВГ',
            'count' => 4,
            'weight' => 4
        ]);

        Cable::create([
            'name' => 'ВВГ',
            'count' => 4,
            'weight' => 6
        ]);

        Cable::create([
            'name' => 'ВВГ',
            'count' => 5,
            'weight' => 1.5
        ]);
        Cable::create([
            'name' => 'ВВГ',
            'count' => 5,
            'weight' => 2.5
        ]);
        Cable::create([
            'name' => 'ВВГ',
            'count' => 5,
            'weight' => 4
        ]);
        Cable::create([
            'name' => 'ВВГ',
            'count' => 5,
            'weight' => 6
        ]);
        Cable::create([
            'name' => 'АВВГ',
            'count' => 2,
            'weight' => 2.5
        ]);

        Cable::create([
            'name' => 'АВВГ',
            'count' => 2,
            'weight' => 4
        ]);
        Cable::create([
            'name' => 'АВВГ',
            'count' => 2,
            'weight' => 10
        ]);

        Cable::create([
            'name' => 'АВВГ',
            'count' => 2,
            'weight' => 16
        ]);

        Cable::create([
            'name' => 'ШВВП',
            'count' => 2,
            'weight' => 0.5
        ]);
        Cable::create([
            'name' => 'ШВВП',
            'count' => 2,
            'weight' => 0.75
        ]);
        Cable::create([
            'name' => 'ШВВП',
            'count' => 3,
            'weight' => 0.75
        ]);
        Cable::create([
            'name' => 'ПВС',
            'count' => 2,
            'weight' => 0.75
        ]);
        Cable::create([
            'name' => 'ПВС',
            'count' => 2,
            'weight' => 2.5
        ]);
        Cable::create([
            'name' => 'ПВС',
            'count' => 3,
            'weight' => 2.5
        ]);
        Cable::create([
            'name' => 'ПВС',
            'count' => 4,
            'weight' => 2.5
        ]);
        Cable::create([
            'name' => 'ПВС',
            'count' => 4,
            'weight' => 2.5
        ]);


    }
}
