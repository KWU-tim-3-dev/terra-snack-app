<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use SoftDeletes, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address'
    ];
       protected $dates = ['deleted_at'];
    //  customer
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'user_id');
    }
}
