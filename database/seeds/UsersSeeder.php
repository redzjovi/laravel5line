<?php
use App\Http\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->truncate();
	    User::create(array(
	        'name' => 'Admin',
	        'email' => 'admin@admin.com',
	        'password' => Hash::make('admin'),
	    ));
    }
}