<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Prestasi extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia, HasFactory;

    public $table = 'prestasis';

    protected $appends = [
        'sertifikat',
    ];

    protected $dates = [
        'tanggal_pelaksanaan',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const BIDANG_LOMBA_SELECT = [
        'Akademik'     => 'Akademik',
        'Non-Akademik' => 'Non-Akademik',
    ];

    public const STATUS_SELECT = [
        'Terverifikasi' => 'Terverifikasi',
        'Ditolak'       => 'Ditolak',
        'Pending'       => 'Pending',
    ];

    protected $fillable = [
        'mahasiswa_id',
        'nama_lomba',
        'bidang_lomba',
        'tanggal_pelaksanaan',
        'tempat_pelaksanaan',
        'prestasi_juara',
        'tingkat',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id');
    }

    public function getTanggalPelaksanaanAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setTanggalPelaksanaanAttribute($value)
    {
        $this->attributes['tanggal_pelaksanaan'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getSertifikatAttribute()
    {
        return $this->getMedia('sertifikat')->last();
    }
}