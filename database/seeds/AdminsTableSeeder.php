<?php

use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $db = new \App\Models\Admin();
        $db->name = 'wu';
        $db->email = 'yf-wu@qq.com';
        $db->avatar =  'images/avatar.png';
        $db->password = Hash::make('111111');
        $db->token = (string) Str::uuid();
        $db->save();
    }
}
