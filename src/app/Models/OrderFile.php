<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class OrderFile extends Model
{
    use HasFactory, SoftDeletes;

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function orderfilepaths(){
        return $this->hasMany(OrderFilePath::class);
    }
}
