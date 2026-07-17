<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documentation extends Model
{
    protected $fillable = [
        'activity_id',
        'photo',
        'caption',
        'is_cover'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}