<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code'
    ];

    /**
     * Relation to students
     */
    public function students()
    {
        return $this->hasMany('App\student');
    }    
}
