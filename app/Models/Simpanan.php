<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    protected $table = 'simpanan';

    protected $fillable = [
        'user_id',
        'tipe_simpanan',
        'nominal',
        'tanggal_transaksi',
        'keterangan',
    ];

    /**
     * Get the user that owns the saving.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
