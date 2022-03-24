<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

//use Illuminate\Database\Eloquent\Model;

class admin extends Authenticatable {

    use Notifiable;

    protected $guard = 'admin';
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $table = 'users';

}
