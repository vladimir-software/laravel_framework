<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\UserReviews;
class UserReviewDetail extends Model {

    protected $table = 'user_review_details';

    public function userReview() {
        return $this->belongsTo(UserReviews::class, 'user_review_id', 'id');
    }

}
