<?php

namespace App\Http\Controllers\Board;

use App\AI_Create_Image;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class Board extends Controller
{
    use AI_Create_Image;
    public function ShowBoard()
    {
        $cookie = request()->cookie("token_account");
        $tab = request()->query('tab', 'saved');
        $photos = DB::table('users')->join('albums','users.id', '=' , 'albums.user_id')->join('photos','albums.id','=','photos.album_id')->where('users.id',$this->find_id())->paginate(8);
        $albums = Album::where('user_id',$this->find_id())->paginate(8);
        return view('User.Board.Board', ['tab' => $tab], compact('photos','albums'));
    }
    public function ShowAlbum($id)
    {
        $album = Album::find($id);
        $user = $album->user;
        $photo = Photo::where("album_id",$album->id)->paginate(8);
        return view('User.Board.Album', compact('album','photo','user'));
    }
    public function CreateAlbum()
    {
        return view('User.Board.CreateAlbum');
    }
    public function EditAlbum($id)
    {
        $album = Album::find($id);  
        return view('User.Board.EditAlbum', compact('album'));
    }
    public function UpdateAlbum(Request $request, $id)
    {
        $Email = Cookie::get("token_account");
        $request->validate([
            'title' => 'max:255',
            'description' => 'max:255',
            'cover' => 'image|max:4096',
        ],
        [
            'title.max' => 'Tiêu đề không được quá 255 ký tự',
            'description.max' => 'Mô tả không được quá 255 ký tự',
            'cover.image' => 'Ảnh phải là ảnh',
            'cover.max' => 'Dung lượng ảnh không được vượt quá 4MB',
        ]);
        $title = $request->input('title');
        $description = $request->input('description');
        $private = $request->input('private');
        $image = $request->file('cover');

        $album = Album::find($id);

        if($image && $title && $description)
        {
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('r2')->put("albums/" . $Email . "/" . "ImageCoverAlbum/" . $filename, file_get_contents($image));
            $album->title = $title;
            $album->description = $description;
            $album->cover_image = $this->urlR2 . "albums/" . $Email . "/" . "ImageCoverAlbum/" . $filename; 
        }
        else if($title)
        {
            $album->title = $title;
        }
        else if($description)
        {
            $album->description = $description;
        }
        else if($image)
        {
            $filename = time() . '.' . $image->getClientOriginalExtension();
            Storage::disk('r2')->put("albums/" . $Email . "/" . "ImageCoverAlbum/" . $filename, file_get_contents($image));
            $album->cover_image = $this->urlR2 . "albums/" . $Email . "/" . "ImageCoverAlbum/" . $filename; 
        }
        if($private)
        {
            $album->is_private = 1;
        }
        else
        {
            $album->is_private = 0;
        }
        $album->save();
        return redirect()->route("showboard");
    }
    public function DeleteAlbum($id)
    {
        $album = Album::find($id);
        foreach($album->photos as $x)
        {
            $urlRemove = str_replace("https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/","",$x->url);
            Storage::disk('r2')->delete($urlRemove);
        }
        $urlRemove = str_replace("https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/","",$album->cover_image);
        Storage::disk('r2')->delete($urlRemove);
        $album->delete();
        return redirect()->route("showboard");
    }
    public function AddAlbum(Request $request)
    {
        $request->validate([
            'cover' => 'required|image|max:4096',
        ],
        [
            'image.required' => 'Vui lòng chọn một file ảnh.',
            'image.image' => 'File được chọn phải là ảnh (jpeg, png, bmp, gif, svg, webp).',
            'image.max' => 'Dung lượng file không được vượt quá 4MB.',
        ]);

        $Email = Cookie::get("token_account");
        
        $image = $request->file('cover');
        $title = $request->input('title');
        $description = $request->input('description');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        Storage::disk('r2')->put("albums/" . $Email . "/" . "ImageCoverAlbum/" . $filename, file_get_contents($image));

        if($request->has('private'))
        {
            $private = 1;
        }
        else
        {
            $private = 0;
        }

        $id = $this->find_id();

        Album::create(
            [
                "user_id" => $id,
                "title" => $title,
                "description" =>  $description,
                "cover_image" =>  "https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/albums/" . $Email . "/" . "ImageCoverAlbum/" . $filename,
                "created_at" => now(),
                "updated_at" => now(),
                "is_private" => $private,
            ]);

        return redirect()->route("showboard");
    }

    private function find_id()
    {
        $email = request()->cookie("token_account");
        $id = User::where("email",$email)->first();
        return $id->id;
    }
}
