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
    protected $onDelete = 'cascade';

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function showType()
    {
        return $this->belongsTo(ShowType::class, 'show_type_id');
    }

    public function images()
    {
        return $this->hasMany(ReservationDateImage::class, 'reservation_date_id');
    }

    public function artists()
    {
        return $this->belongsToMany(Artist::class, 'artist_reservation_date', 'reservation_date_id', 'artist_id');
    }
}
