<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationDate extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'show_type_id',
        'titolo',
        'descrizione',
        'prezzo',
        'pranzo_cena',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function showType()
    {
        return $this->belongsTo(ShowType::class, 'show_type_id');
    }
}
