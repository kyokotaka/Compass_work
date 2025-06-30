<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;//DB記法を使えるようになる

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['over_name' => '北海道',
             'under_name' => '帆立',
             'over_name_kana' => 'ホッカイドウ',
             'under_name_kana' => 'ホタテ',
             'mail_address' => 'hokkaido@mail.com',
             'sex' => '1',
             'birth_day' => '2000-07-17',
             'role' => '1',
             'password' => bcrypt('11111111'),
            ]
        ]);
    }
}
