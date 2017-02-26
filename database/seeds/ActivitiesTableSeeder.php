<?php
use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('activities')->insert([
            [
                'code' => '/0',
                'name' => 'Register',
                // 'help' => 'Ketik /help untuk bantuan '.PHP_EOL.'Ketik /2 untuk bermain PHP',
                'help' => 'Ketik /1 untuk mencari informasi tentang smartphone',
            ],
            [
                'code' => '/1',
                'name' => 'GSMArena',
                'help' => 'Ketik "nama_ponsel" untuk mencari ponsel, contoh "iphone 5"'.PHP_EOL.'Ketik /0 untuk kembali ke awal',
            ],
        ]);
    }
}