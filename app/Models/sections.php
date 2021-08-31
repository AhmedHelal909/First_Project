<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sections extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function product(){
        return $this->hasMany(products::class);
    }
    public function invoices(){
        return $this->hasMany(invoices::class);
    }
}
