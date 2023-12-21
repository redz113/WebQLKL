<?php

namespace App\Models;

use App\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Topic extends Model
{
    use HasFactory, Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'department',
        'number_student',
        'required',
        'note',
        'instructor_id',
        'subinstructor_id',
        'status',
        'user_id',
        'academic_year'
    ];

    protected $filterable = [
        'name',
        'department',
        'required',
        'note'
    ];

    protected $hidden = [
        'instructor_id',
        'subinstructor_id'
    ];

    public $table = "topics";

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAll($topics){
        if(!empty(request()->department)){
            $topics = $topics->where('department','=', request()->department);
        }

        if(!empty(request()->academic_year)){
            $topics = $topics->where('topics.academic_year','=', request()->academic_year);
        }

        
        if(isset(request()->status) && request()->status != ""){
            $topics = $topics->where('status','=', request()->status);
        }

        return $topics;
    }
}
