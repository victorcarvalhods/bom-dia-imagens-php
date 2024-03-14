<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    public static function getUserByEmail(String $email){
        $user = User::where('email', $email)->first();
        return $user;
    }


}
