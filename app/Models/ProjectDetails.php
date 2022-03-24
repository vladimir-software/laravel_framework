<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProjectDetails extends Model {

    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'project_id';
    protected $table = 'project_details';
}
