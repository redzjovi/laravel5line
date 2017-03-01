<?php
namespace App\Http\Models;

use App\User;
use App\Http\Models\Activity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserLine extends Model
{
    protected $table = 'users_line';

    public $timestamps = true;

    /* relationships */
    function activity()
    {
        return $this->hasOne('App\Http\Models\Activity', 'id', 'status');
    }

    function check_user($lineId)
    {
        $userLine = self::where('line_id', $lineId)->get()->first();

        if ($userLine === null)
        {
            $user = new User();
            $user->name = $user->email = strtotime(date('Y-m-d H:i:s'));
            $user->password = Hash::make('password');
            if ($user->save())
            {
                $userLine = new self();
                $userLine->user_id = $user->id;
                $userLine->line_id = $lineId;
                $userLine->status = Activity::where('code', '/0')->first()->id;
                $userLine->save();
            }
        }
        return $userLine;
    }
}