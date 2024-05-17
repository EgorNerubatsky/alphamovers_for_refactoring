<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function filepaths()
    {
        return $this->hasMany(FilePath::class);
    }
}