<?php

namespace App\Http\Controllers\Api;

use App\Address;
use App\Booking;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'bookings'=> 'required|array|min:1',
            'bookings.*.product_id'=> 'required|exists:products,id',
            'bookings.*.from'=> 'required|date|after_or_equal:today',
            'bookings.*.to'=> 'required|date|after_or_equal:bookings.*.from',
            'customer.first_name' => 'required|min:2',
            'customer.last_name' => 'required|min:2',
            'customer.email' => 'required|email',
            'customer.street' => 'required|min:2',
            'customer.city' => 'required|min:2',
            'customer.country' => 'required|min:2',
            'customer.state' => 'required|min:2',
            'customer.zip' => 'required|min:2',
        ]);

        $data = array_merge($data , $request->validate([
            'bookings.*' =>['required' ,function($attribute, $value ,$fail){
                $product = Product::findOrFail($value['product_id']);
                    if ( ! $product->availableFor($value['from'] , $value['to'])){
                    $fail("this object is not available right now with given dates !");
                }
            }]
        ]));

        $bookingData = $data['bookings'];
        $addressData = $data['customer'];

        $bookings = collect($bookingData)->map(function($bookingData) use($addressData){
            $product = Product::findOrFail($bookingData['product_id']);
            $booking  = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];
            $booking->price = $product->price($booking->from ,$booking->to)['total'];
            $booking->Product()->associate($product);
            $booking->address()->associate(Address::create($addressData));
            $booking->save();
            return $booking;
        });

        return $bookings;
    }
}
