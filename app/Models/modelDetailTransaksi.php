<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class modelDetailTransaksi extends Model
{
    use HasFactory;
    protected $table = 'detail_transaksis';
    public $timestamps = true;
    protected $fillable = [
        'id_transaksi',
        'id_barang',
        'qty',
        'price',
        'status',
    ];

    public function transaksi()
    {
        return $this->belongsTo(transaksi::class, 'id_transaksi',
        'id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'id_barang',
        'id');
    }
    
}
