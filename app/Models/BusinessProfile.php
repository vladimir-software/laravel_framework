<?php

namespace App\Models;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class BusinessProfile extends Model {

//    public function userData() {
//        return $this->hasOne(User::class, 'id', 'user_id');
//    }

    protected $table = 'business_profile';

}
