<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'rut','name', 'lastName', 'age', 'course'
    ];

    /**
     * Relation to students
     */
    public function course()
    {
        return $this->belongsTo('App\course', 'course');
    }        
}
