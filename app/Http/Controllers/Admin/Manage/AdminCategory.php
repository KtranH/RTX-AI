<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategory extends Controller
{
    //
    public function ShowCategory()
    {
        $randomCategory = Category::withCount('photos')->get()->random(5);
        $countCategory = Category::all()->count();

        $mostPreferredCategory = Category::withCount('users')
            ->orderBy('users_count', 'desc')
            ->first();

        $leastPhotosCategory = Category::withCount('photos')
            ->orderBy('photos_count', 'asc')
            ->first();

        $mostPhotosCategory = Category::withCount('photos')
            ->orderBy('photos_count', 'desc')
            ->first();

        $allCategory = Category::paginate(15);        
        return view('Admin.Manage.Category', compact('randomCategory', 'countCategory', 'mostPreferredCategory', 'mostPhotosCategory', 'leastPhotosCategory', 'allCategory'));
    }
    public function SearchCategory(Request $request)
    {
        $findCategory = Category::where('name', 'like', '%' . $request->search . '%')->paginate(15);
        if ($request->ajax()) {
            return response()->json([
                'table_html' => view('Admin.Components.category-table', ['allCategory' => $findCategory])->render(),
                'pagination_html' => $findCategory->links('vendor.pagination.tailwind')->render()
            ]);
        }
        return response()->json($findCategory);
    }
    public function AddCategory(Request $request)
    {
        if(!$request->name) {
            return response()->json(['success' => false, 'message' => 'Vui lòng nhập thể loại']);
        }
        try {
            if(Category::where('name', $request->name)->exists()) {
                return response()->json(['success' => false, 'message' => 'Thể loại đã tồn tại']);
            }
            $category = new Category();
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();
            return response()->json(['success' => true, 'category' => $category]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }    
    public function DeleteCategory(Request $request)
    {
        try {
            $category = Category::findOrFail($request->id);
            $category->delete();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function UpdateCategory(Request $request)
    {
        if(!$request->name) {
            return response()->json(['success' => false, 'message' => 'Vui lòng nhập thể loại']);
        }
        try {
            $category = Category::findOrFail($request->id);
            if(Category::where('name', $request->name)->exists()) {
                return response()->json(['success' => false, 'message' => 'Thể loại đã tồn tại']);
            }
            $category->name = $request->name;
            $category->description = $request->description;
            $category->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function LockCategory(Request $request)
    {
        try {
            $category = Category::findOrFail($request->id);
            $category->is_deleted = 1;
            $category->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function UnlockCategory(Request $request)
    {
        try {
            $category = Category::findOrFail($request->id);
            $category->is_deleted = 0;
            $category->save();
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
