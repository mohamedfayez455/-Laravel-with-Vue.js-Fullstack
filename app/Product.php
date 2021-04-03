<?php

namespace App;

use Carbon\Carbon;
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
        return $this->bookings()->betweenDates($from , $to)->count() == 0;
    }

    public function price($from , $to) :array{
        $days = (new Carbon($from))->diffInDays(new Carbon($to)) + 1;
        $price = $days * $this->price;

        return [
            'total' => $price,
            'breakdown' =>[
                $this->price => $days
            ]
        ];
    }
}
