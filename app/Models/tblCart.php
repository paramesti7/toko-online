<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tblCart extends Model
{
    use HasFactory;
    // protected $table = 'tbl_carts';
    public $timestamps = true;
    public $fillable = [
        'idUser',
        'id_barang',
        'qty',
        'price',
        'status',
    ];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'id_barang');
    }
}
