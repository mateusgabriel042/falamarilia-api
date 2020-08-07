<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'id',
        'label',
        'active',
        'service_id',
        'icon'
    ];

    public $timestamps = true;

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function solicitation(): HasMany
    {
        return $this->hasMany(Solicitation::class);
    }
}
