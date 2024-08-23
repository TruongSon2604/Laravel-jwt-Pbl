<?php

namespace App\Http\Controllers;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class LocationController extends Controller
{
    //
    public function index()
    {

        // $brands = Location::paginate(10);
        $brands = DB::table('locations')->paginate(10);
        return response()->json($brands, 200);
    }

    public function store(Request $request)
    {
       // Validate the incoming request data
    $validated=$request->validate([
        'user_id' => 'required|exists:users,id', // Kiểm tra rằng user_id phải tồn tại trong bảng users
        'building' => 'required',
        'area' => 'required',
    ]);

    $location = new Location();
    $location->user_id = $request->user_id;
    $location->building = $request->building;
    $location->area = $request->area;
    $location->save();

    return response()->json([
        'status' => true,
        'message' => 'Location created successfully',
        'data' => $request->area
    ]);
    }

    public function update(Request $request,$id)
    {
        $request->validate([
            'building'=>'required',
            'area'=>'required'
        ]);
        $location= Location::find($id);
        $location->building = $request->building;
        $location->area = $request->area;
        $location->save();
        return response()->json([
            'status' => true,
            'message' => 'Location updated successfully',
            'data' => $request->area
        ]);
    }
    public function delete(Request $request,$id)
    {

        $location= Location::find($id);
        $location->delete();
        return response()->json([
            'status' => true,
            'message' => 'Location Delete successfully',
            'data' => $request->area
        ]);
    }

}
