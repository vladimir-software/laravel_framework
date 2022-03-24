<?php

namespace App\Models;

use App\Models\QuestionTypes;
use Illuminate\Database\Eloquent\Model;

class Questions extends Model {

    protected $table = 'questions';

    public function question_types() {
        return $this->hasMany(QuestionTypes::class, 'question_id', 'id');
    }

}
