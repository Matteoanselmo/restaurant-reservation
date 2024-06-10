<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationDateImage extends Model {
    use HasFactory;

    protected $table = 'reservation_dates_images'; // Nome della tabella
    protected $fillable = ['reservation_date_id', 'name', 'ext', 'path'];

    public function reservationDate() {
        return $this->belongsTo(ReservationDate::class, 'reservation_date_id');
    }
}
