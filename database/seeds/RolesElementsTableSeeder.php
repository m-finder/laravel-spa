<?php

use App\Models\RoleElement;
use Illuminate\Database\Seeder;

class RolesElementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['element_id' => 1, 'role_id' => 1],
            ['element_id' => 2, 'role_id' => 1],
            ['element_id' => 3, 'role_id' => 1],
            ['element_id' => 4, 'role_id' => 1],
            ['element_id' => 5, 'role_id' => 1],
            ['element_id' => 6, 'role_id' => 1],
            ['element_id' => 7, 'role_id' => 1],
            ['element_id' => 8, 'role_id' => 1],
            ['element_id' => 9, 'role_id' => 1],
            ['element_id' => 10, 'role_id' => 1],
            ['element_id' => 11, 'role_id' => 1],
            ['element_id' => 12, 'role_id' => 1],
            ['element_id' => 13, 'role_id' => 1],
            ['element_id' => 14, 'role_id' => 1],
            ['element_id' => 15, 'role_id' => 1],
            ['element_id' => 16, 'role_id' => 1],
            ['element_id' => 17, 'role_id' => 1],
            ['element_id' => 18, 'role_id' => 1],
            ['element_id' => 19, 'role_id' => 1],
            ['element_id' => 20, 'role_id' => 1],
            ['element_id' => 21, 'role_id' => 1],
            ['element_id' => 22, 'role_id' => 1],
            ['element_id' => 23, 'role_id' => 1],
            ['element_id' => 24, 'role_id' => 1],
            ['element_id' => 25, 'role_id' => 1],
            ['element_id' => 26, 'role_id' => 1],
        ];

        RoleElement::insert($data);
    }
}
