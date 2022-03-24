<?php

namespace App\Models;

use App\Models\Questions;
use App\Models\QuestionTypes;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model {

    protected $table = 'categories';

    public function questions() {
        return $this->hasMany(Questions::class, 'category_id', 'id');
    }

}
