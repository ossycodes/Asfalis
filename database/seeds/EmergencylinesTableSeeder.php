<?php

use App\Emergencyline;
use Illuminate\Database\Seeder;

class EmergencylinesTableSeeder extends Seeder
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
                'name' => 'Inspector General Of Police',
                'description' => 'SMS Only',
                'telephone_number' => '0805966666'
            ],
            [
                'name' => 'State Security Service (SSS)',
                'description' => '',
                'telephone_number' => '08132222105-9'
            ],
            [
                'name' => 'Federal Road Safety Corps',
                'description' => '',
                'telephone_number' => '122 or 07002255372'
            ],
            [
                'name' => 'Lagos State Emergency Service',
                'description' => 'This covers Police, Ambulance Service and Traffic Service',
                'telephone_number' => '767 or 122'
            ],
            [
                'name' => 'Lagos State Traffic Management Authority (LASTMA)',
                'description' => '',
                'telephone_number' => '08029228271 (GM), 08023386821 (Provost)'
            ],
            [
                'name' => 'Police Emergency Phone Numbers',
                'description' => '',
                'telephone_number' => '01-4931260, 01-4978899'
            ],
            [
                'name' => 'Rapid Response Squad (RRS)',
                'description' => '',
                'telephone_number' => '070-55350249, 070-35068242, 080-79279349'
            ],
            [
                'name' => 'Rape helpline',
                'description' => '',
                'telephone_number' => '080072732255'
            ],
            [
                'name' => 'Depression/Suicide prevention initiative',
                'description' => '',
                'telephone_number' => '08062106493', '08092106493', '09080217555', '09034400009', '08111909909', '07013811143'
            ],
            [
                'name' => 'Nigerian Army Human Rights',
                'description' => 'If you are harassed by Army officials',
                'telephone_number' => '08160134303, 08161507644'
            ],
            [
                'name' => 'Inspector General Of Police (IGP)',
                'description' => 'SMS only',
                'telephone_number' => '0805966666'
            ],
            [
                'name' => 'Federal Road Safety Corps (FRSC) Zonal office Lagos State',
                'description' => '',
                'telephone_number' => '08033706639, 01-7742771'
            ],

            [
                'name' => 'Fire Help Line',
                'description' => '',
                'telephone_number' => '01-7944929, 080-33235892', '080-33235890'
            ],
            [
                'name' => 'Child Abuse hotline (Lagos)',
                'description' => '',
                'telephone_number' => '08085753932, 08102678442'
            ],
            [
                'name' => 'Domestic Violence (Lagos)',
                'description' => '',
                'telephone_number' => '08057542266, 08102678443'
            ],
            [
                'name' => 'Child Domestic Violence',
                'description' => '',
                'telephone_number' => '08107572829, 08131643208'
            ],
            [
                'name' => 'Police Emergency Phone Numbers',
                'description' => '',
                'telephone_number' => '01-4931260, 01-4978899'
            ],
            [
                'name' => 'Violation ofGirls and Women help line',
                'description' => '',
                'telephone_number' => '0800072732255'
            ],
        ])->each(function ($emergencyLines) {
            factory(Emergencyline::class)->create([
                'name' => $emergencyLines['name'],
                'description' => $emergencyLines['description'],
                'telephone_number' => $emergencyLines['telephone_number']
            ]);
        });
    }
}
