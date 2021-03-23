<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;

class ProductAvailabilityController extends Controller
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
            'from'=>'required|date_format:Y-m-d|after_or_equal:now',
            'to'=>'required|date_format:Y-m-d|after_or_equal:from',
        ]);
        $product  =Product::findOrFail($id);
//        dd($product->availableFor($data['from'] , $data['to']));

        return $product->availableFor($data['from'] , $data['to'])
            ? response()->json([])
            : response()->json([], 404);
    }
}
