<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Solicitation extends Model
{
    use SoftDeletes;

    protected $table = 'solicitations';

    protected $fillable = [
        'id',
        'service_id',
        'category_id',
        'user_id',
        'status',
        'description',
        'photo',
        'geolocation',
        'comment',
        'protocol'
    ];

    public $timestamps = true;

    public function service(): HasOne
    {
        return $this->hasOne(Service::class);
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
