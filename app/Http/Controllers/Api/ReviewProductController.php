<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductReviewIndexResource;
use App\Product;
use Illuminate\Http\Request;

class ReviewProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id , Request $request)
    {
        $product = Product::findOrFail($id);
        return  ProductReviewIndexResource::collection($product->reviews()->latest()->get());
    }
}
