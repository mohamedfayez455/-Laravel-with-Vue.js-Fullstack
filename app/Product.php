<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function availableFor($from , $to) :bool{
        return  $this->bookings()->betweenDates($from , $to)->count() ? true : false;
    }
}
