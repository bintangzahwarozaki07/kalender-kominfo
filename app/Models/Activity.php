<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    /**
     * Kolom yang boleh diisi melalui model.
     */
    protected $fillable = [
        // Data utama kegiatan
        'category_id',
        'institution_id',
        'title',
        'slug',

        // Jadwal kegiatan
        'activity_date',
        'publish_date',
        'start_time',
        'end_time',

        // Informasi kegiatan
        'location',
        'person_in_charge',
        'description',
        'thumbnail',
        'status',

        // Identitas surat undangan
        'letter_number',
        'letter_attachment',
        'letter_recipient',
        'letter_date',
        'signatory_position',
        'signatory_name',
        'signatory_nip',
    ];

    /**
     * Konversi tipe data atribut.
     */
    protected function casts(): array
    {
        return [
            'activity_date' => 'date',
            'publish_date' => 'date',
            'letter_date' => 'date',
        ];
    }

    /**
     * Relasi kegiatan dengan kategori.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Relasi kegiatan dengan instansi.
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Relasi kegiatan dengan dokumentasi.
     */
    public function documentations()
    {
        return $this->hasMany(Documentation::class);
    }

    /**
     * Relasi kegiatan dengan tautan.
     */
    public function links()
    {
        return $this->hasMany(Link::class);
    }
}
