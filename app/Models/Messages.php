<?php

namespace App\Models;

use App\Models\Messages;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Messages extends Model {

    public function getReceiverData() {
        return $this->hasOne(User::class, 'id', 'receiver_id');
    }

    public function getSenderData() {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }

    protected $table = 'messages';

}
