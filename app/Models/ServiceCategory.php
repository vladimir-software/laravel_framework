<?php

namespace App\Models;
use App\Models\ServiceSubCategory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model {

    protected $table = 'service_categories';

    public function serviceSubCategory() {
        return $this->hasMany(ServiceSubCategory::class, 'service_id', 'id');
    }

}
