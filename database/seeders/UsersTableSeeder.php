<?php

namespace Database\Seeders;

//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //usersテーブルにユーザーを追加する
        DB::table('users')->insert([
            ['over_name' => '松尾',
            'under_name' => '清美',
            'over_name_kana' =>'マツオ',
            'under_name_kana' => 'キヨミ',
            'mail_address' => 'matsuokiyomi@gmail.com',
            'sex' => '2',
            'birth_day' => '1998-3-19',
            'role' => '1',
            'password' => bcrypt('12345678'),]
            ]);
    }
}
