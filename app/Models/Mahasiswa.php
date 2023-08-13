<?php

namespace App\Models;

use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mahasiswa extends Model
{
    use SoftDeletes, HasFactory;

    public $table = 'mahasiswas';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public const JENIS_KELAMIN_RADIO = [
        'laki-laki' => 'Laki - Laki',
        'perempuan' => 'Perempuan',
    ];

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nim',
        'jenis_kelamin',
        'prodi_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function prestasis()
    {
        return $this->hasMany(Prestasi::class);
    }
}