<?php

namespace App\Http\Controllers\Board;

use App\AI_Create_Image;
use App\FindInformation;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\HistoryImageAI;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class Board extends Controller
{
    use AI_Create_Image;
    use FindInformation;
    public function FeatureImage($id)
    {
        $photo = Photo::find($id);
        $photo->is_feature = !$photo->is_feature;
        $photo->save();
        return redirect()->back();
    }
    public function ShowBoard()
    {
        $cookie = request()->cookie("token_account");
        $userId = $this->find_id();
        $imagesAI = HistoryImageAI::where('user_id', $userId)->paginate(12);
        $tab = request()->query('tab', 'saved');
        if ($tab == 'created') {
            return view('User.Board.Board', ['tab' => $tab], compact('imagesAI'));
        }
        $photos = DB::table('users')->join('albums','users.id', '=' , 'albums.user_id')->join('photos','albums.id','=','photos.album_id')->where('users.id',$this->find_id())->paginate(12);
        $albums = Album::where('user_id',$this->find_id())->paginate(8);
        $feature = Photo::where('is_feature', true)
            ->whereHas('album', function($query) {
                $query->where('user_id', $this->find_id());
            })->get();
        return view('User.Board.Board', ['tab' => $tab], compact('photos','albums','feature','imagesAI'));
    }
    public function ShowAlbum($id)              
    {
        $album = Album::find($id);
        $user = $album->user;
        $photo = Photo::where("album_id",$album->id)->paginate(8);
        $countPhoto = Photo::where("album_id",$album->id)->count();
        return view('User.Board.Album', compact('album','photo','user','countPhoto'));
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
        $email = Cookie::get("token_account");
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'cover' => 'image|max:4096',
        ], [
            'title.max' => 'Tiêu đề không được quá 255 ký tự',
            'description.max' => 'Mô tả không được quá 255 ký tự',
            'cover.image' => 'Ảnh phải là ảnh',
            'cover.max' => 'Dung lượng ảnh không được vượt quá 4MB',
            'title.required' => 'Tiêu đề không được để trống',
            'description.required' => 'Mô tả không được để trống',
        ]);

        $album = Album::findOrFail($id);
        
        if ($request->hasFile('cover')) {
            $image = $request->file('cover');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $newCoverPath = "albums/{$email}/ImageCoverAlbum/{$filename}";

            Storage::disk('r2')->put($newCoverPath, file_get_contents($image));
            Storage::disk('r2')->delete(str_replace($this->urlR2, "", $album->cover_image));
            $album->cover_image = $this->urlR2 . $newCoverPath;
        }

        $dataToUpdate = $request->only(['title', 'description']);
        $dataToUpdate['is_private'] = $request->has('private');

        $dataToUpdate = array_filter($dataToUpdate);

        $album->update($dataToUpdate);
        return redirect()->route("showboard");
    }
    public function DeleteAlbum($id)
    {
        $album = Album::find($id);
        foreach($album->photos as $x)
        {
            $urlRemove = str_replace($this->urlR2,"",$x->url);
            Storage::disk('r2')->delete($urlRemove);
        }
        $urlRemove = str_replace($this->urlR2,"",$album->cover_image);
        Storage::disk('r2')->delete($urlRemove);
        $album->delete();
        return redirect()->route("showboard");
    }
    public function AddAlbum(Request $request)
    {
        $request->validate([
            'cover' => 'required|image|max:4096',
        ], [
            'cover.required' => 'Vui lòng chọn một file ảnh.',
            'cover.image' => 'File được chọn phải là ảnh (jpeg, png, bmp, gif, svg, webp).',
            'cover.max' => 'Dung lượng file không được vượt quá 4MB.',
        ]);

        $email = Cookie::get("token_account");
        $image = $request->file('cover');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        Storage::disk('r2')->put("albums/{$email}/ImageCoverAlbum/{$filename}", file_get_contents($image));

        $private = $request->has('private') ? 1 : 0;
        $userId = $this->find_id();

        Album::create([
            "user_id" => $userId,
            "title" => $request->input('title'),
            "description" => $request->input('description'),
            "cover_image" => $this->urlR2 . "albums/{$email}/ImageCoverAlbum/{$filename}",
            "created_at" => now(),
            "updated_at" => now(),
            "is_private" => $private,
        ]);

        return redirect()->route("showboard");
    }
}
