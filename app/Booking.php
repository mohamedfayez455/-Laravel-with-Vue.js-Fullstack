<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Product;

class Booking extends Model
{

    public function Product()
    {
        return $this->belongsTo(Product::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function scopeBetweenDates(Builder $query , $from , $to){
        return $query->Where('to' , '>=' , $from)->where('from' , '<=' , $to);
    }

}
