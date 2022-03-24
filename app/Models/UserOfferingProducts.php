<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;
use App\Models\Users\UserProfile;
use Illuminate\Database\Eloquent\Relations\Pivot;


class UserOfferingProducts extends Model {

    protected $table = 'user_offering_products';
    
    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function userProfile() {
        return $this->belongsTo(UserProfile::class, 'user_id', 'user_id');
    }
}
