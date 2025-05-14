<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $guarded = [];

    public function passions()
    {
        return $this->belongsToMany(Passion::class, 'passion_question_maps');
    }

    public function responses()
    {
        return $this->hasMany(QuestionResponse::class);
    }
}
