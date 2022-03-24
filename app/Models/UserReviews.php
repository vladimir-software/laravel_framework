<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;
class UserReviews extends Model {

    protected $table = 'user_reviews';
    public function user() {
        return $this->hasOne(User::class, 'id', 'to_user_id');
    }

}
