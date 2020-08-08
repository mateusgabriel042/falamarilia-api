<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'id',
        'name',
        'category_id',
        'color',
        'icon'
    ];

    public $timestamps = true;

    public function category(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function solicitation(): HasMany
    {
        return $this->hasMany(Solicitation::class);
    }
}
