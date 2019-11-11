<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
        $db->role_id = 1;
        $db->email = 'yf-wu@qq.com';
        $db->avatar =  'images/avatar.jpg';
        $db->password = Hash::make('111111');
        $db->api_token = (string) Str::uuid();
        $db->save();
    }
}
