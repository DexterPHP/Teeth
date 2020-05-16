<?php

use Illuminate\Database\Seeder;
use App\Models\Rols;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Full Permission [ Admin ]
        $Super_Admin_rols = Rols::create([
            'name'  => 'Super Admin',
            'uuid'  => 'super',
            'permissions'   => json_encode([
                // [ Create Roles ]
                'create-user'       => true,
                'create-center'     => true,
                'create-doctor'     => true,
                'create-date'       => true,
                'create-Acccounter' => true,
                'create-patients'   => true,
                'create-lab'        => true,
                'create-record'     => true,
                'create-diseases'   => true,
                'create-transition' => true,
                'create-treatments' => true,
                // [ Edit Roles ]
                'edit-user'       => true,
                'edit-center'     => true,
                'edit-doctor'     => true,
                'edit-date'       => true,
                'edit-Acccounter' => true,
                'edit-patients'   => true,
                'edit-lab'        => true,
                'edit-record'     => true,
                'edit-diseases'   => true,
                'edit-transition' => true,
                'edit-treatments' => true,
                // [ Search Roles ]
                'search-user'       => true,
                'search-center'     => true,
                'search-doctor'     => true,
                'search-date'       => true,
                'search-Acccounter' => true,
                'search-patients'   => true,
                'search-lab'        => true,
                'search-record'     => true,
                'search-diseases'   => true,
                'search-transition' => true,
                'search-treatments' => true
            ]),
        ]);
        // Doctor Roles
        $Doctor_rols = Rols::create([
            'name'  => 'Doctor',
            'uuid'  => 'doctor',
            'permissions'   => json_encode([
                // [ Create Roles ]
                'create-user'       => false,
                'create-center'     => false,
                'create-doctor'     => false,
                'create-date'       => true,
                'create-Acccounter' => false,
                'create-patients'   => true,
                'create-lab'        => false,
                'create-record'     => true,
                'create-diseases'   => true,
                'create-transition' => true,
                'create-treatments' => true,
                // [ Edit Roles ]
                'edit-user'       => false,
                'edit-center'     => false,
                'edit-doctor'     => false,
                'edit-date'       => true,
                'edit-Acccounter' => false,
                'edit-patients'   => true,
                'edit-lab'        => false,
                'edit-record'     => true,
                'edit-diseases'   => true,
                'edit-transition' => false,
                'edit-treatments' => true,
                // [ Search Roles ]
                'search-user'       => false,
                'search-center'     => false,
                'search-doctor'     => false,
                'search-date'       => true,
                'search-Acccounter' => false,
                'search-patients'   => true,
                'search-lab'        => true,
                'search-record'     => true,
                'search-diseases'   => true,
                'search-transition' => true,
                'search-treatments' => true
            ]),
        ]);

        // Reception Roles
        $Reception_rols = Rols::create([
            'name'  => 'Reception',
            'uuid'  => 'reception',
            'permissions'   => json_encode([
                // [ Create Roles ]
                'create-user'       => false,
                'create-center'     => false,
                'create-doctor'     => false,
                'create-date'       => true,
                'create-Acccounter' => false,
                'create-patients'   => true,
                'create-lab'        => false,
                'create-record'     => false,
                'create-diseases'   => true,
                'create-transition' => false,
                'create-treatments' => false,
                // [ Edit Roles ]
                'edit-user'       => false,
                'edit-center'     => false,
                'edit-doctor'     => false,
                'edit-date'       => true,
                'edit-Acccounter' => false,
                'edit-patients'   => true,
                'edit-lab'        => false,
                'edit-record'     => false,
                'edit-diseases'   => false,
                'edit-transition' => false,
                'edit-treatments' => false,
                // [ Search Roles ]
                'search-user'       => false,
                'search-center'     => false,
                'search-doctor'     => true,
                'search-date'       => true,
                'search-Acccounter' => false,
                'search-patients'   => true,
                'search-lab'        => false,
                'search-record'     => false,
                'search-diseases'   => true,
                'search-transition' => false,
                'search-treatments' => false
            ]),
        ]);

        // Accounter  Roles
        $Accounter_rols = Rols::create([
            'name'  => 'Accounter',
            'uuid'  => 'accounter',
            'permissions'   => json_encode([
                // [ Create Roles ]
                'create-user'       => false,
                'create-center'     => false,
                'create-doctor'     => false,
                'create-date'       => false,
                'create-Acccounter' => false,
                'create-patients'   => false,
                'create-lab'        => false,
                'create-record'     => true,
                'create-diseases'   => false,
                'create-transition' => true,
                'create-treatments' => true,
                // [ Edit Roles ]
                'edit-user'       => false,
                'edit-center'     => false,
                'edit-doctor'     => false,
                'edit-date'       => false,
                'edit-Acccounter' => false,
                'edit-patients'   => false,
                'edit-lab'        => false,
                'edit-record'     => true,
                'edit-diseases'   => false,
                'edit-transition' => false,
                'edit-treatments' => true,
                // [ Search Roles ]
                'search-user'       => false,
                'search-center'     => false,
                'search-doctor'     => false,
                'search-date'       => false,
                'search-Acccounter' => false,
                'search-patients'   => true,
                'search-lab'        => false,
                'search-record'     => true,
                'search-diseases'   => false,
                'search-transition' => true,
                'search-treatments' => true
            ]),
        ]);
    }
}
