<?php

namespace App\Http\Controllers;

use App\Http\Requests\Rating\RatingStoreRequest;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingController extends Controller
{
    public function store(RatingStoreRequest $request)
    {
        dd($request->all());
        try {
            $rating = DB::transaction(function () use ($request) {
                $rating = Rating::create([
                    'product_id' => $request->productid,
                    'user_id' => auth()->user()->id,
                    'rating' => $request->rating,
                    'comment' => $request->comment,
                ]);
                return $rating;
            });
            if ($rating) {
                return response()->json(['message' => 'Rating saved!']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
