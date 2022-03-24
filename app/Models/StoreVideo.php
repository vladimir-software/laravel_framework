<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoreVideo extends Model
{
    //
    protected $table = 'store_video';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title', 'description','video'];
    public $timestamps = false;

}
