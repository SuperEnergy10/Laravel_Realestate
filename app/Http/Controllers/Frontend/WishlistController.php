<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    //
    public function AddToWishList(Request $request, $property_id){
        if(Auth::check()){
            $exists = Wishlist::where('user_id', Auth::id())->where('property_id', $property_id)->first();
            if(!$exists){
                Wishlist::create([
                    'user_id' => Auth::id(),
                    'property_id' => $property_id,
                    'created_at' => Carbon::now()
                ]);

                return response()->json([
                    'success' => 'Successfully Added On Your Wishlish'
                ]);
            }else{
                return response()->json([
                    'error' => 'This Property Has Already in Your Wishlish'
                ]);
            }
        }else{
            return response()->json([
                'error' => 'At First Login Your Account'
            ]);
        }
    }


    public function UserWishList(){
        $id = Auth::user()->id;
        $userData = User::find($id);

        return view('frontend.dashboard.wishlist', compact('userData'));
    }

    public function GetWishListProperty(){
        $wishlist = Wishlist::with('property')->where('user_id', Auth::id())->latest()->get();

        $wishQty = Wishlist::count();

        return response()->json([
            'wishlist' => $wishlist,
            'wishQty' => $wishQty
        ]);
    }

    public function WishListRemove($id){
        Wishlist::where('user_id',Auth::id())->where('id', $id)->delete();

        return response()->json([
            'success' => 'Successfully Deleted On Your Wishlish'
        ]);
    }
}
