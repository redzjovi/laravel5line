<?php
namespace App\Http\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserLine extends Model
{
    protected $table = 'users_line';

    public $status_array = ['1' => 'register'];
    public $timestamps = true;

    function check_user($lineId)
    {
        $userLine = self::where('line_id', $lineId)->get()->first();

        if ($userLine === null)
        {
            $user = new User();
            $user->name = $user->email = '';
            $user->password = Hash::make('password');
            if ($user->save())
            {
                $userLine = new self();
                $userLine->user_id = $user->id;
                $userLine->line_id = $lineId;
                $userLine->status = array_search('register', $this->status_array);
                $userLine->save();
            }
        }
        return $userLine;
    }
}