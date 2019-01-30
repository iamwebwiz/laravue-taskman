<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * Mass assignable properties
     * 
     * @var array
     */
    protected $fillable = [
        'body', 'completed'
    ];
}
