<?php
namespace App\Models\Users;

use App\Models\UserSurvey;
use App\Models\Users\UserProfile;
use App\Models\BusinessProfile;
use App\Models\UserPayments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {

    use Notifiable;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    protected $table = 'users';

    public function userSurvey() {
        return $this->hasMany(UserSurvey::class, 'user_id', 'id');
    }

    public function userProfile() {
        return $this->belongsTo(UserProfile::class, 'id', 'user_id');
    }

    public function userBusiness() {
        return $this->hasOne(BusinessProfile::class, 'user_id', 'id');
    }

    public function userPayments() {
        return $this->hasOne(UserPayments::class, 'user_id', 'id')->orderBy('id', 'desc')->limit(1);
    }

}
