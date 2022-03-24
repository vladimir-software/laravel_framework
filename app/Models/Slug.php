<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;

class Slug extends Model {

    public static function generate() {
        $uuid4 = Uuid::uuid4();
        return $uuid4->toString();
    }

}
