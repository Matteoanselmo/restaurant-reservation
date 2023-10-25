<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtistReservationDate extends Model
{
    use HasFactory;

    protected $table = 'artist_reservation_date';
    protected $fillable = ['artist_id', 'reservation_date_id'];

    public function artist()
    {
        return $this->belongsTo(Artist::class, 'artist_id', 'id');
    }

    public function reservationDate()
    {
        return $this->belongsTo(ReservationDate::class, 'reservation_date_id', 'id');
    }
}
