<?php

use App\EmergencylineCategory;
use Illuminate\Database\Seeder;

class EmergencylineCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        collect([
            [
                'name' => 'Fire Service',

            ],
            [
                'name' => 'Armed Forces',
            ],
            [
                'name' => 'Domestic Violence',
            ]
        ])->each(function ($emergencyLineCategory) {
            factory(EmergencylineCategory::class)->create([
                'name' => $emergencyLineCategory['name'],
            ]);
        });
    }
}
