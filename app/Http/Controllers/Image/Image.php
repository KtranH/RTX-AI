<?php

namespace App\Http\Controllers\Image;

use App\AI_Create_Image;
use App\FindInformation;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Category;
use App\Models\Photo;
use App\Models\User;
use App\Models\WorkFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Image extends Controller
{
    use FindInformation;
    use AI_Create_Image;

    public function ShowWorkFlow()
    {
        $workflow = WorkFlow::paginate(6);
        //return view("User.Image.Creativity", compact("workflow"));
    }

    public function ShowImage($id)
    {
        $image = Photo::find($id);
        $listcate = $image->category()->where("photo_id",$id)->get();
        $album = $image->album;
        $user = $album->user;
        $idUser = $this->find_id();
        $idUserAlbum = $album->user_id;

        Session::put("Owner", $idUser == $idUserAlbum ? "true" : null);
        return view('User.Image.Image', compact('image', 'album', 'user', 'listcate'));
    }

    public function CreateImage($id)
    {
        $Category = Category::all();
        $Id = $id;
        return view("User.Image.CreateImage", compact("Category","Id"));
    }

    public function EditImage($id)
    {
        $category = Category::all();
        $image = Photo::find($id);
        $listcate = $image->category()->where("photo_id",$id)->get();
        $album = $image->album;
        $idUser = $this->find_id();
        $allAlbum = Album::where("user_id",$idUser)->get();
        return view("User.Image.EditImage", compact("image","album","category","listcate","allAlbum"));
    }

    public function UpdateImage(Request $request, $id)
    {
        $request->validate([
            'cover' => 'image|max:4096',
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'album' => 'required|exists:albums,id',
            'categories' => 'required|string',
        ], [
            'cover.image' => 'File phải là ảnh.',
            'cover.max' => 'Dung lượng không quá 4MB.',
            'title.max' => 'Tiêu đề không quá 255 ký tự.',
            'description.max' => 'Mô tả không quá 255 ký tự.',
            'album.required' => 'Chọn album.',
            'album.exists' => 'Album không tồn tại.',
            'categories.required' => 'Chọn ít nhất một thể loại.',
            'categories.string' => 'Thể loại phải là chuỗi.',
            'title.required' => 'Tiêu đề không được để trống.',
            'description.required' => 'Mô tả không được để trống.',
        ]);

        $photo = Photo::findOrFail($id);
        if ($image = $request->file('cover')) {
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $path = "albums/" . Cookie::get("token_account") . "/" . Carbon::now()->format('d_m_Y') . "/{$filename}";
            Storage::disk('r2')->put($path, file_get_contents($image));
            Storage::disk('r2')->delete(str_replace($this->urlR2, "", $photo->url));
            $photo->url = $this->urlR2 . $path;
        }

        $dataToUpdate = $request->only(['title', 'description', 'album']);
        $dataToUpdate = array_filter($dataToUpdate);
        $photo->update($dataToUpdate);
        
        $categories = json_decode($request->input('categories'), true);
        if (is_array($categories)) {
            foreach($categories as $x)
            {
                $cateid = $this->find_id_categorie($x);
                if ($cateid != 0) {
                    $photo->category()->syncWithoutDetaching($cateid);
                }
            }
        }
        return redirect()->route("showimage",["id" => $id]);
    }
    public function DeleteImage($id)
    {
        $photo = Photo::find($id);
        Storage::disk('r2')->delete(str_replace($this->urlR2, "", $photo->url));
        $idAlbum = $photo->album_id;
        $photo->delete();
        return redirect()->route("showalbum",["id" => $idAlbum]);
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
            "url" => $this->urlR2 . "albums/" . $Email . "/" . $folder . "/" . $filename,
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
}
