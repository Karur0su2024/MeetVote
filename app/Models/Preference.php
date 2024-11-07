<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    /** @use HasFactory<\Database\Factories\PreferenceFactory> */
    use HasFactory;

    protected $fillable = ['name', 'value', 'icon', 'background', 'color'];

}
