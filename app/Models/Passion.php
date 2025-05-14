<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passion extends Model
{
    protected $guarded = [];
    
    public function questions()
    {
        return $this->belongsToMany(Question::class, 'passion_question_maps');
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
