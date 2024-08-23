<?php

namespace App\Http\Controllers;
use App\Models\Brands;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class BrandsController extends Controller
{

    public function index()
    {
        // $brands = Brands::paginate(10);
        $brand= DB::table('brands')->get()->paginate(10);
        return response()->json($brands, 200);
    }

    public function show($id)
    {
        $brand = Brands::find($id);

        if ($brand) {
            return response()->json($brand, 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Brand not found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:brands,name',
            ]);

            $brand = new Brands();
            $brand->name = $validated['name'];
            $brand->save();

            return response()->json([
                'status' => true,
                'message' => 'Brand added successfully',
                'data' => $brand
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to add brand',
                'error' => $e->getMessage() // Optional: for debugging
            ], 500);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|unique:brands,name',
            ]);

            Brands::where('id', $id)->update([
                'name' => $request->name
            ]);

            return response()->json('Brand updated successfully', 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update brand'
            ], 500);
        }
    }
    public function delete($id)
    {
        $brand= Brands::find($id);
        if($brand)
        {
            $brand->delete();
            return response()->json('brand delete');
        }
        else{
            return response()->json('brand not found');
        }

    }

}
