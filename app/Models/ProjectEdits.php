<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProjectEdits extends Model {

    public $timestamps = false;
    public $primaryKey = 'id';
    protected $table = 'project_edits';
}
