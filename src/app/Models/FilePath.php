<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static get()
 */
class FilePath extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'file_id',
    ];

    public function file(){
        return $this->belongsTo(File::class);
    }
}
