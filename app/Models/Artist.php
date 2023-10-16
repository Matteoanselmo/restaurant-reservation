<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    use HasFactory;

    protected $fillable = [
        'show_type_id',
        'titolo',
        'descrizione',
        'img_name',
        'img_path',
        'img_ext'
    ];

    public function showType()
    {
        return $this->belongsTo(ShowType::class, 'show_type_id');
    }

}
