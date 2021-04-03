<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductPriceController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id ,Request $request )
    {
        $data = $request->validate([
            'from'=>'required|date_format:Y-m-d',
            'to'=>'required|date_format:Y-m-d|after_or_equal:from',
        ]);
        $product  =Product::findOrFail($id);


//        return response()->json(['data'=>[ $product->price($data['from'] , $data['to'])]]);


//        $days = (new Carbon($data['from']))->diffInDays(new Carbon($data['to'])) + 1;
//        $price = $days * $product->price;
//
//        return response()->json([
//            'data'=>[
//                'total' => $price,
//                'breakdown' =>[
//                    $product->price => $days
//                ]
//            ]
//        ]);
//
        return response()->json([
            'data'=> $product->price($data['from']  ,$data['to'])
        ]);


    }
}
