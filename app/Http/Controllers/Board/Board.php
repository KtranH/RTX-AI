<?php

namespace App\Http\Controllers\Board;

use App\AI_Create_Image;
use App\Events\PushNotification;
use App\Models\Notification;
use App\QueryDatabase;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\HistoryImageAI;
use App\Models\Photo;
use App\Models\SavedImage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class Board extends Controller
{
    use AI_Create_Image;
    use QueryDatabase;
    public function FeatureImage(Request $request)
    {
        $id = $request->get('photo_id');
        $checkCount = Photo::where('is_feature', true)->whereHas('album', function ($query) {
            $query->where('user_id', Auth::user()->id);
        })->count();
        if ($checkCount > 10) {
            return response()->json(['success' => false]);
        }
        $photo = Photo::findOrFail($id);
        if ($photo->is_feature == 0) {
            $photo->is_feature = 1;
            $photo->updated_at = Carbon::now();
            $photo->save();
            return response()->json(['success' => true, 'is_feature' => true]);
        } else {
            $photo->is_feature = 0;
            $photo->updated_at = Carbon::now();
            $photo->save();
            return response()->json(['success' => true, 'is_feature' => false]);
        }
    }
    public function ShowBoard(Request $request, $id = null)
    {
        $isFollowing = false;
        if ($id == null) {
            $userId = Auth::user()->id;
        } else {
            $userId = $id;
        }
        if (Auth::check()) {
            $isFollowing = Auth::user()->isFollowing($userId);
        }
        $user = User::findOrFail($userId);
        $tab = $request->route('tab');
        $albums = Album::where('user_id', $userId)->paginate(8);
        $feature = Photo::where('is_feature', true)->whereHas('album', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->orderBy('updated_at', 'desc')->get();
        return view('User.Board.Board', ['tab' => $tab], compact('albums', 'feature', 'user', 'isFollowing'));
    }
    public function ShowBoardApi(Request $request)
    {
        $imagesPerPage = 2;
        $page = $request->get('page', 1);
        $id = $request->get('userId', null);
        if ($id == null) {
            $userId = Auth::user()->id;
        } else {
            $userId = $id;
        }
        if (Auth::user()->id == $userId) {
            $photos = Photo::whereHas('album.user', function ($query) use ($userId) {
                $query->where('id', $userId);
            })->paginate($imagesPerPage, ['*'], 'page', $page);
        } else {
            $photos = Photo::whereHas('album', function ($query) use ($userId) {
                $query->where('is_private', 0)
                    ->whereHas('user', function ($query) use ($userId) {
                        $query->where('id', $userId);
                    });
            })->paginate($imagesPerPage, ['*'], 'page', $page);
        }

        return response()->json([
            'photos' => $photos->items(),
            'hasMorePages' => $photos->hasMorePages(),
        ]);
    }
    public function ShowAiImageApi(Request $request)
    {
        $imagesPerPage = 2;
        $page = $request->get('pageAI', 1);
        $id = $request->get('userId', null);
        if ($id == null) {
            $userId = Auth::user()->id;
        } else {
            $userId = $id;
        }
        $photos = HistoryImageAI::where('user_id', $userId)->paginate($imagesPerPage, ['*'], 'page', $page);
        return response()->json([
            'photos' => $photos->items(),
            'hasMorePages' => $photos->hasMorePages(),
        ]);
    }
    public function ShowSavedImageApi(Request $request)
    {
        $imagesPerPage = 2;
        $page = $request->get('pageSaved', 1);
        $id = $request->get('userId', null);
        if ($id == null) {
            $userId = Auth::user()->id;
        } else {
            $userId = $id;
        }
        $photos = SavedImage::where('user_id', $userId)->with('photo')->paginate($imagesPerPage, ['*'], 'page', $page);
        return response()->json([
            'photos' => $photos->items(),
            'hasMorePages' => $photos->hasMorePages(),
        ]);
    }
    /*public function ShowBoardApi()
    {
        $userId = $this->find_id();
        $photos = DB::table('users')
            ->join('albums', 'users.id', '=', 'albums.user_id')
            ->join('photos', 'albums.id', '=', 'photos.album_id')
            ->where('users.id', $userId)->paginate(8);
        return response()->json([
            'photos' => $photos,
        ]);
    }*/

    public function ShowAlbum($id)
    {
        $album = Album::findOrFail($id);
        $user = $album->user;
        if (Auth::user()->id != $user->id && $album->is_private == 1) {
            return view('errors.404');
        }
        $photo = Photo::where("album_id", $album->id)->paginate(8);
        $countPhoto = Photo::where("album_id", $album->id)->count();
        return view('User.Board.Album', compact('album', 'photo', 'user', 'countPhoto'));
    }

    public function ShowAlbumApi($id)
    {
        $album = Album::findOrFail($id);
        $photos = Photo::where("album_id", $album->id)->with('album.user')->paginate(8);
        return response()->json([
            'photos' => $photos->items(),
            'current_page' => $photos->currentPage(),
            'last_page' => $photos->lastPage(),
        ]);
    }

    public function CreateAlbum()
    {
        return view('User.Board.CreateAlbum');
    }
    public function EditAlbum($id)
    {
        $album = Album::findOrFail($id);
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
        Alert::toast('Đã cập nhật mới Album!', 'success')->position('bottom-left')->autoClose(3000);
        return redirect()->route("showboard");
    }
    public function DeleteAlbum($id)
    {
        $album = Album::findOrFail($id);
        foreach ($album->photos as $x) {
            $urlRemove = str_replace($this->urlR2, "", $x->url);
            Storage::disk('r2')->delete($urlRemove);
        }
        $urlRemove = str_replace($this->urlR2, "", $album->cover_image);
        Storage::disk('r2')->delete($urlRemove);
        $album->delete();
        Alert::toast('Đã xoá Album!', 'success')->position('bottom-left')->autoClose(3000);
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
        $coverPath = "albums/{$email}/ImageCoverAlbum/{$filename}";

        Storage::disk('r2')->put($coverPath, file_get_contents($image));

        $private = $request->has('private') ? 1 : 0;
        $userId = $this->find_id();

        Album::create([
            "user_id" => $userId,
            "title" => $request->input('title'),
            "description" => $request->input('description'),
            "cover_image" => $this->urlR2 . $coverPath,
            "created_at" => now(),
            "updated_at" => now(),
            "is_private" => $private,
        ]);

        Alert::toast('Thêm Album thành công!', 'success')->position('bottom-left')->autoClose(3000);
        return redirect()->route("showboard");
    }
    public function UpdateCountFollowers($id)
    {
        $user = User::findOrFail($id);
        $user->followers_count = $user->followers()->count();
        $user->save();
    }
    public function UpdateCountFollowing($id)
    {
        $user = User::findOrFail($id);
        $user->following_count = $user->following()->count();
        $user->save();
    }
    public function FollowUser(Request $request)
    {
        $id = $request->get('user_id');
        $user = User::findOrFail($id);
        $userFollow = Auth::user();
        $user->followers()->attach(Auth::user()->id);
        $this->UpdateCountFollowing(Auth::user()->id);
        $this->UpdateCountFollowers($id);
        Notification::create([
            'user_id' => $id,
            'type' => 'follow',
            'data' => json_encode([
                'url' => $userFollow->avatar_url,
                'message' => "{$userFollow->username} vừa mới theo dõi bạn <3",
            ]),
            'is_read' => 0,
        ]);
        broadcast(new PushNotification("{$userFollow->username} vừa mới theo dõi bạn <3", $id, "http://127.0.0.1:8000/board/{$userFollow->id}",$userFollow->avatar_url));
        return response()->json(['success' => true]);
    }
    public function UnFollowUser(Request $request)
    {
        $id = $request->get('user_id');
        $user = User::findOrFail($id);
        $user->followers()->detach(Auth::user()->id);
        $this->UpdateCountFollowing(Auth::user()->id);
        $this->UpdateCountFollowers($id);
        return response()->json(['success' => true]);
    }
    public function PrivateAlbum(Request $request)
    {
        $id = $request->get('album_id');
        $album = Album::findOrFail($id);
        if ($album->is_private == 0) {
            $album->is_private = 1;
            $album->save();
            return response()->json(['success' => true, 'is_private' => true]);
        } else {
            $album->is_private = 0;
            $album->save();
            return response()->json(['success' => true, 'is_private' => false]);
        }
    }
}
