<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'address',
        'website'
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}