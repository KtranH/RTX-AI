<?php

namespace App\Http\Controllers\Board;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class Board extends Controller
{
    public function ShowBoard()
    {
        $cookie = request()->cookie("token_account");
        $tab = request()->query('tab', 'saved');
        $photos = DB::table('users')->join('albums','users.id', '=' , 'albums.user_id')->join('photos','albums.id','=','photos.album_id')->where('users.id',$this->find_id())->count();
        $albums = Album::where('user_id',$this->find_id())->paginate(8);
        return view('User.Board.Board', ['tab' => $tab], compact('photos','albums'));
    }
    public function CreateAlbum()
    {
        return view('User.Board.CreateAlbum');
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

        $image = $request->file('cover');
        $title = $request->input('title');
        $description = $request->input('description');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        Storage::disk('r2')->put("albums/" . $filename, file_get_contents($image));

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
                "cover_image" =>  "https://pub-d9195d29f33243c7a4d4c49fe887131e.r2.dev/albums/" . $filename,
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
