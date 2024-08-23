<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $category = Category::paginate(10);
        return response()->json($category, 200);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if ($category) {
            return response()->json($category, 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'category not found'
            ], 404);
        }
    }

    // public function store(Request $request)
    // {
    //     try {
    //         $validated = $request->validate([
    //             'name' => 'required|unique:category,name',
    //             'image' => 'required',
    //         ]);

    //         $category = new Category();
    //         $category->name = $validated['name'];
    //         $category->image = $validated['image'];
    //         $category->save();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'category added successfully',
    //             'data' => $category
    //         ]);
    //     } catch (\Illuminate\Validation\ValidationException $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Validation failed',
    //             'errors' => $e->errors()
    //         ], 422);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => 'Failed to add brand',
    //             'error' => $e->getMessage() // Optional: for debugging
    //         ], 500);
    //     }
    // }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:category,name',
            'image' => 'required|image',
        ]);

        $category = new Category();
        $category->name = $request->name;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageData = file_get_contents($file->getRealPath());
            $base64 = base64_encode($imageData);
            $mimeType = $file->getClientMimeType();
            $category->image = 'data:' . $mimeType . ';base64,' . $base64;
        }

        $category->save();

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'data' => $category
        ]);
    }

    public function update($id, Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|unique:category,name,' . $id, // Cập nhật thông tin không bị trùng tên
            'image' => 'nullable|image', // Ảnh là tùy chọn
        ]);

        // Tìm category cần cập nhật
        $category = Category::findOrFail($id);

        // Cập nhật tên
        $category->name = $request->name;

        // Nếu có ảnh mới, cập nhật ảnh
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageData = file_get_contents($file->getRealPath());
            $base64 = base64_encode($imageData);
            $mimeType = $file->getClientMimeType();
            $category->image = 'data:' . $mimeType . ';base64,' . $base64;
        }

        // Lưu thông tin đã cập nhật
        $category->save();

        // Trả về phản hồi JSON
        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => $category
        ]);
    }
    public function delete($id)
    {
        $Category= Category::find($id);
        if($Category)
        {
            $Category->delete();
            return response()->json([
                'status' => true,
                'message' => 'Category deleted',
                'data' => $category
            ]);
        }
        else{
            return response()->json([
                'status' => false,
                'message' => 'Not Delete success',

            ]);
        }

    }
}
