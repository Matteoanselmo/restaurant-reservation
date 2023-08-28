<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_date_id',
        'client_id',
        'posto',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function reservationDate()
    {
        return $this->belongsTo(ReservationDate::class);
    }
}
