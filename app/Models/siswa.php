<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    use HasFactory;
    protected $fillable = [
        'nis',
        'nama',
        'jk',
        'ttl',
        'kelas',
        'jurusan',
        'image'
    ];
    protected $table = 'siswa';
    public $timestamps = false;
}
