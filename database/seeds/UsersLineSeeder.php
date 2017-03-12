<?php
use App\Http\Models\UserLine;
use Illuminate\Database\Seeder;

class UsersLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_line')->truncate();
	    UserLine::create(array(
	        'user_id' => '1',
	        'line_id' => '0',
	        'status' => '0',
	    ));
    }
}