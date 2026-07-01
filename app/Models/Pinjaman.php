<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    protected $table = 'pinjaman';

    protected $fillable = [
        'user_id',
        'nominal_pinjaman',
        'bunga_persen',
        'lama_angsuran_bulan',
        'sisa_angsuran_bulan',
        'tanggal_pengajuan',
        'tanggal_jatuh_tempo',
        'status',
        'alasan',
    ];

    /**
     * Get the user that owns the loan.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the installments for the loan.
     */
    public function angsuran()
    {
        return $this->hasMany(Angsuran::class, 'pinjaman_id');
    }
}
