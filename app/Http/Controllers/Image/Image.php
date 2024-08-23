<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Models\WorkFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class Image extends Controller
{
    public function ShowWorkFlow()
    {
        $workflow = WorkFlow::paginate(6);
        return view("User.Image.Creativity", compact("workflow"));
    }

    public function CreateImage()
    {
        $Category = Category::all();
        return view("User.Image.CreateImage", compact("Category"));
    }
    public function AddImage2Album(Request $request)
    {
        $request->validate([
            'cover' => 'required|image|max:4096',
        ],
        [
            'cover.required' => 'Vui lòng chọn một file ảnh.',
            'cover.image' => 'File được chọn phải là ảnh (jpeg, png, bmp, gif, svg, webp).',
            'cover.max' => 'Dung lượng file không được vượt quá 4MB.',
        ]);

        $request->validate([
            'categories' => 'required|string', 
        ], [
            'categories.required' => 'Vui lòng chọn ít nhất một thể loại.',
            'categories.string' => 'Thể loại phải là một chuỗi ký tự.',
        ]);

        $categories = json_decode($request->input('categories'), true);
        dd($categories);

        $Day = Carbon::now()->day;
        $Month = Carbon::now()->month;
        $Year = Carbon::now()->year;
        
        $folder = $Day . "_" . $Month . "_" . $Year;
        $Email = Cookie::get("token_account");

        $image = $request->file('cover');
        $title = $request->input('title');
        $description = $request->input('description');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        Storage::disk('r2')->put("albums/" . $Email . "/" . $folder . "/" . $filename, file_get_contents($image));


    }
    private function find_id()
    {
        $email = request()->cookie("token_account");
        $id = User::where("email",$email)->first();
        return $id->id;
    }
}
