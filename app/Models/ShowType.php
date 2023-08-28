<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowType extends Model
{
    use HasFactory;

    protected $fillable = ['nome'];

    public function reservationDates()
    {
        return $this->hasMany(ReservationDate::class);
    }
}
