<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserReviewController extends Controller
{
    public function store(Request $request){
        if (!auth()->check()) {
            return back()->with('error','Please login to give review!');
        }
        try{
            $review=DB::transaction(function()use($request){
                $review=UserReview::create([
                    'user_id'=>auth()->user()->id,
                    'product_id'=>$request->product_id,
                    'user_rating'=>$request->user_rating,
                    'user_review'=>$request->user_review,

                ]);
                return $review;
            });
            if($review){
                return back()->with('success','Your review is published successfully!');
            }
        }
        catch(\Exception $e){
            return back()->with('error',$e->getMessage());

        }
    }
}
