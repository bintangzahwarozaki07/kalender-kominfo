<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $fillable = [
        'category_id',
        'institution_id',
        'title',
        'slug',
        'activity_date',
        'publish_date',
        'start_time',
        'end_time',
        'location',
        'person_in_charge',
        'description',
        'thumbnail',
        'status'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    public function documentations()
    {
        return $this->hasMany(Documentation::class);
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }
}