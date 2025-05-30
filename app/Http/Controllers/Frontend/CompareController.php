<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Compare;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompareController extends Controller
{
    //
    public function AddToCompare(Request $request, $property_id){
        if(Auth::check()){
            $exists = Compare::where('user_id', Auth::id())->where('property_id', $property_id)->first();
            if(!$exists){
                Compare::create([
                    'user_id' => Auth::id(),
                    'property_id' => $property_id,
                    'created_at' => Carbon::now()
                ]);

                return response()->json([
                    'success' => 'Successfully Added On Your CompareList'
                ]);
            }else{
                return response()->json([
                    'error' => 'This Property Has Already in Your Compare'
                ]);
            }
        }else{
            return response()->json([
                'error' => 'At First Login Your Account'
            ]);
        }
    }

    public function UserCompare(){
        // $id = Auth::user()->id;
        // $userData = User::find($id);

        return view('frontend.dashboard.compare');
    }

    public function GetCompareProperty(){
        $compare = Compare::with('property')->where('user_id', Auth::id())->latest()->get();


        return response()->json($compare);
    }

    public function CompareRemove($id){
        Compare::where('user_id',Auth::id())->where('id', $id)->delete();

        return response()->json([
            'success' => 'Successfully Deleted On Your CompareList'
        ]);
    }
}
