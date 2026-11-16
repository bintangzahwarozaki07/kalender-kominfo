<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivitySubmission extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'institution_id',
        'title',
        'activity_date',
        'start_time',
        'end_time',
        'location',
        'person_in_charge',
        'description',
        'status',
        'admin_note',
        'activity_id',
    ];

    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
        ];
    }

    // Relasi ke akun Pemohon
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke kategori
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi ke instansi
    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    // Relasi ke kegiatan resmi jika disetujui
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
}
