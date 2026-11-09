<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $fillable = [
        'activity_id',
        'documentation_id',
        'title',
        'url',
        'platform'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function documentation()
    {
        return $this->belongsTo(Documentation::class);
    }
}