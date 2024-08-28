<?php

namespace App\Http\Controllers\Image;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Photo;
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

    public function CreateImage($id)
    {
        $Category = Category::all();
        $Id = $id;
        return view("User.Image.CreateImage", compact("Category","Id"));
    }
    public function AddImage2Album(Request $request, $id)
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

        $photos = Photo::create([
            "album_id" => $id,
            "title" => $title,
            "description" => $description,
            "url" => "https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/albums/" . $Email . "/" . $folder . "/" . $filename,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        $categories = json_decode($request->input('categories'), true);
        foreach($categories as $x)
        {
            $cateid = $this->find_id_categorie($x);
            if($cateid != 0)
            {
                $photos->category()->attach($cateid);
            }
        }

        return redirect()->route("showalbum",["id" => $id]);
    }
    private function find_id_categorie($x)
    {
        $id = Category::where("name",$x)->first();
        if($id != null)
        {
            return $id->id;
        }
        else
        {
            return 0;
        }
    }
}
