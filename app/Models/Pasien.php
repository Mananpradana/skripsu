<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pasien';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'umur',
        'lokasi_desa', 
        'tanggal_ditambahkan', 
        'keterangan'
    ];
}
