<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\City;

class CityController extends Controller
{
    public function AllCity(){
        $city = City::latest()->get();
        return view('admin.backend.city.all_city', compact('city'));
    }

    public function storeCity(Request $request){
        $request->validate([
            'city_name' => 'required'
        ]);

        City::create([
            'city_name' => $request->city_name,
            'city_slug' => strtolower(str_replace(' ', '-', $request->city_name))
        ]);

        $notification = array(
            'message' => 'City Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function EditCity($id){
        $city = City::find($id);
        return response()->json($city);
    }

    public function UpdateCity(Request $request){
        $cat_id = $request->cat_id;

        City::find($cat_id)->update([
            'city_name' => $request->city_name,
            'city_slug' => strtolower(str_replace(' ', '-', $request->city_name))
        ]);

        $notification = array(
            'message' => 'City Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);
    }

    public function deleteCity($id){
        City::find($id)->delete();

        $notification = array(
            'message' => 'City Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }
}
