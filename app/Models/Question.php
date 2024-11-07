<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; 

class Question extends Model
{
    /** @use HasFactory<\Database\Factories\QuestionFactory> */
    use HasFactory;

    protected $fillable = [
        'question_type', 
        'text', 
        'is_required', 
        'open_answers_allowed', 
        'preferences_allowed', 
        'poll_id'
    ];


    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function getFormattedText(){
        if (Carbon::hasFormat($this->text, 'Y-m-d')) {
            // If it's a valid date, format it
            //dd(Carbon::parse($this->text)->format('M j'));
            return Carbon::parse($this->text)->format('M j');
        }
        else {
            return $this->text;
        }
    }
}
