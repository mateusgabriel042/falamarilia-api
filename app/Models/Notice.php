<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $table = 'notices';

    protected $fillable = [
        'id',
        'title',
        'description',
        'type',
    ];

    public $timestamps = true;
}
