<?php

namespace App\Http\Controllers\Image;

use App\AI_Create_Image;
use App\Events\PushNotification;
use App\Models\Notification;
use App\QueryDatabase;
use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Photo;
use App\Models\PostReview;
use App\Models\Reply;
use App\Models\SavedImage;
use App\Models\User;
use App\Models\WorkFlow;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class Image extends Controller
{
    use QueryDatabase;
    use AI_Create_Image;

    public function ShowWorkFlow()
    {
        $workflow = WorkFlow::paginate(6);
        //return view("User.Image.Creativity", compact("workflow"));
    }

    public function ShowImage($id)
    {
        $image = Photo::where("id", $id)->where("is_deleted", 0)->firstOrFail();
        $countComment = Comment::where("photo_id", $id)->count();
        $photos = Photo::query()
            ->limit(4)
            ->inRandomOrder()
            ->get();

        if (Auth::check()) {
            $idUser = Auth::user()->id;
            $checkUserLikedImage = $this->checkLike($id, $idUser);
        } else {
            $checkUserLikedImage = null;
        }
        $listcate = $image->category()->where("photo_id", $id)->get();
        $listUserLiked = Like::where("photo_id", $id)->get();
        return view('User.Image.Image', compact('image', 'photos', 'listcate', 'listUserLiked', 'checkUserLikedImage', 'countComment'));
    }
    public function ShowCommentAPI(Request $request, $idImage)
    {
        $comments = Comment::with('user')
            ->where('photo_id', $idImage)
            ->orderBy('created_at', 'desc')
            ->skip($request->skip)
            ->take(3)
            ->withCount('replies')
            ->get();

        $comments->map(function ($comment) {
            $comment->time_ago = $comment->created_at->diffForHumans(['locale' => 'vi']);
            return $comment;
        });
        return response()->json([
            'success' => true,
            'comments' => $comments
        ]);
    }

    public function CreateImage($id)
    {
        $Category = Category::all();
        $Id = $id;
        return view("User.Image.CreateImage", compact("Category", "Id"));
    }

    public function EditImage($id)
    {
        $category = Category::all();
        $image = Photo::findOrFail($id);
        $listcate = $image->category()->where("photo_id", $id)->get();
        $idUser = Auth::user()->id;
        $allAlbum = Album::where("user_id", $idUser)->get();
        return view("User.Image.EditImage", compact("image", "category", "listcate", "allAlbum"));
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
            foreach ($categories as $x) {
                $cateid = $this->find_id_categorie($x);
                if ($cateid != 0) {
                    $photo->category()->syncWithoutDetaching($cateid);
                }
            }
        }
        Alert::toast('Đã thay đổi hình ảnh!', 'success')->position('bottom-left')->autoClose(3000);
        return redirect()->route("showimage", ["id" => $id]);
    }
    public function DeleteImage($id)
    {
        $photo = Photo::findOrFail($id);
        Storage::disk('r2')->delete(str_replace($this->urlR2, "", $photo->url));
        $idAlbum = $photo->album_id;
        $photo->delete();
        Alert::toast('Đã xoá hình ảnh!', 'success')->position('bottom-left')->autoClose(3000);
        return redirect()->route("showalbum", ["id" => $idAlbum]);
    }
    public function AddImage2Album(Request $request, $id)
    {
        $request->validate(
            [
                'cover' => 'required|image|max:4096',
            ],
            [
                'cover.required' => 'Vui lòng chọn một file ảnh.',
                'cover.image' => 'File được chọn phải là ảnh (jpeg, png, bmp, gif, svg, webp).',
                'cover.max' => 'Dung lượng file không được vượt quá 4MB.',
            ]
        );

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
        if ($description == null) {
            $description = $title;
        }
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = "albums/" . $Email . "/" . $folder . "/" . $filename;
        Storage::disk('r2')->put($path, file_get_contents($image));
        $photos = Photo::create([
            "album_id" => $id,
            "title" => $title,
            "description" => $description,
            "url" => $this->urlR2 . $path,
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        $categories = json_decode($request->input('categories'), true);
        foreach ($categories as $x) {
            $cateid = $this->find_id_categorie($x);
            if ($cateid != 0) {
                $photos->category()->attach($cateid);
            }
        }

        Alert::toast('Đã thêm hình ảnh vào album!', 'success')->position('bottom-left')->autoClose(3000);
        return redirect()->route("showalbum", ["id" => $id]);
    }
    public function LikeImage($idImage)
    {
        try {
            $userAuth = Auth::user();
            $UserID = $userAuth->id;
            $check = $this->checkLike($idImage, $UserID);
            if ($check) {
                $check->delete();
                return response()->json(['success' => true]);
            } else {
                $like = Like::insert([
                    "user_id" => $UserID,
                    "photo_id" => $idImage,
                    "created_at" => now(),
                    "updated_at" => now(),
                ]);

                $image = Photo::findOrFail($idImage);

                $userIdPN = $image->album->user->id;
                if($userIdPN != $UserID){
                    $tmp = Notification::create([
                        'user_id' => $userIdPN,
                        'type' => 'like',
                        'data' => json_encode([
                            'avatar_url' => $userAuth->avatar_url,
                            'message' => "{$userAuth->username} vừa mới thích ảnh của bạn <3",
                            'url' => "/image/{$idImage}"
                        ]),
                        'is_read' => 0,
                    ]);
    
                    broadcast(new PushNotification(
                        "{$userAuth->username} Vừa mới thích ảnh của bạn <3",
                        $userIdPN,
                        "/image/{$idImage}",
                        $userAuth->avatar_url,
                        $tmp->id
                    ));
                }
                return response()->json(['success' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function AddCommentInImage($idImage, Request $request)
    {
        $request->validate([
            'comment' => 'required|max:100',
        ], [
            'comment.required' => 'Vui lòng để lại bình luận trước khi hoàn thành',
            'comment.max' => 'Bình luận không quá 100 kí tự',
        ]);

        try {
            $comment = Comment::create([
                "user_id" => Auth::user()->id,
                "photo_id" => $idImage,
                "content" => $request->input('comment'),
                "created_at" => now(),
                "updated_at" => now(),
            ]);
            $comment = Comment::withCount('replies')->find($comment->id);
            $comment->load('user');
            $comment->time_ago = $comment->created_at->diffForHumans(['locale' => 'vi']);

            $userAuth = Auth::user();
            if($userAuth->id != $comment->photo->album->user->id){
                $tmp = Notification::create([
                    'user_id' => $comment->photo->album->user->id,
                    'type' => 'comment',
                    'data' => json_encode([
                        'avatar_url' => $userAuth->avatar_url,
                        'message' => "{$userAuth->username} vừa mới bình luận ảnh bạn <3",
                        'url' => "/image/{$idImage}"
                    ])
                ]);
    
                broadcast(new PushNotification(
                    "{$userAuth->username} Vừa mới bình luận ảnh bạn <3",
                    $comment->photo->album->user->id,
                    "/image/{$idImage}",
                    $userAuth->avatar_url,
                    $tmp->id
                ));
    
            }
            return response()->json([
                'success' => true,
                'comment' => $comment
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], $e->getMessage());
        }
    }
    public function UpdateComment(Request $request, $id)
    {
        $comment = Comment::find($id);
        if (!$comment || $comment->user_id != Auth::id()) {
            return response()->json(['success' => false]);
        }

        $comment->content = $request->content;
        $comment->save();

        return response()->json(['success' => true]);
    }
    public function DeleteComment($idComment)
    {
        $comment = Comment::findOrFail($idComment);
        $comment->delete();
        return response()->json([
            'success' => true,
            'message' => 'Xóa thành công',
        ]);
    }
    public function ReplyComment(Request $request, $parentId)
    {
        $reply = Reply::create([
            "user_id" => Auth::user()->id,
            "comment_id" => $parentId,
            "content" => $request->input('content'),
            "parent_id" => null,
            "created_at" => now(),
            "updated_at" => now(),
        ]);
        $reply->load('user');
        $reply->load('comment.user');
        $reply->time_ago = $reply->created_at->diffForHumans(['locale' => 'vi']);
        $reply->comment_id = [
            'id' => $reply->comment->user->id,
            'username' => $reply->comment->user->username
        ];
        $reply->reply_reply = [
            'id' => $this->findParentId($reply->parent_id),
            'username' => $this->findParentName($reply->parent_id)
        ];

        $userAuth = Auth::user();
        if($userAuth->id != $reply->comment->user_id)
        {
            $tmp = Notification::create([
                'user_id' => $reply->comment->user->id,
                'type' => 'reply',
                'data' => json_encode([
                    'avatar_url' => $userAuth->avatar_url,
                    'message' => $userAuth->username . ' Đã phản hồi bình luận của bạn ',
                    'url' => "/image/{$reply->comment->photo_id}"
                ])
            ]);
    
            broadcast(new PushNotification(
                "{$userAuth->username} Vừa phản hồi bình luận của bạn <3",
                $reply->comment->user->id,
                "/image/{$reply->comment->photo_id} ",
                $userAuth->avatar_url,
                $tmp->id
            ));
        }

        return response()->json(['success' => true, 'reply' => $reply]);
    }
    public function getReplies($commentId, Request $request)
    {
        $skip = $request->input('skip', 0);
        $limit = 3;
        $totalReplies = Reply::where('comment_id', $commentId)->count();

        $replies = Reply::where('comment_id', $commentId)
            ->with(['user', 'replies.user', 'comment.user'])
            ->orderBy('created_at', 'asc')
            ->skip($skip)
            ->take($limit)
            ->get()
            ->map(function ($reply) {
                return [
                    'id' => $reply->id,
                    'content' => $reply->content,
                    'comment_id' => [
                        'id' => $reply->comment->user->id,
                        'username' => $reply->comment->user->username
                    ],
                    'reply_reply' => [
                        'id' => $this->findParentId($reply->parent_id),
                        'username' => $this->findParentName($reply->parent_id)
                    ],
                    'user' => [
                        'id' => $reply->user->id,
                        'username' => $reply->user->username,
                        'avatar_url' => $reply->user->avatar_url
                    ],
                    'time_ago' => $reply->created_at->diffForHumans(['locale' => 'vi']),
                    'parent_id' => $reply->parent_id,
                    'original_comment_id' => $reply->comment_id,
                    'updated_at' => $reply->updated_at,
                    'created_at' => $reply->created_at
                ];
            });
        return response()->json([
            'success' => true,
            'replies' => $replies,
            'hasMore' => ($skip + $limit) < $totalReplies
        ]);
    }
    public function DeleteReply($id)
    {
        try {
            $reply = Reply::findOrFail($id);

            if (Auth::user()->id !== $reply->user_id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }

            $reply->delete();
            Alert::toast('Đã xoá phản hồi!', 'success')->position('bottom-left')->autoClose(3000);
            return response()->json([
                'success' => true,
                'message' => 'Reply deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting reply'
            ], 500);
        }
    }
    public function UpdateReply(Request $request, $id)
    {
        $reply = Reply::findOrFail($id);
        if (!$reply || $reply->user_id != Auth::id()) {
            return response()->json(['success' => false]);
        }

        $reply->content = $request->content;
        $reply->save();

        return response()->json(['success' => true]);
    }
    public function ReplyReply(Request $request, $parentId)
    {
        $reply = Reply::findOrFail($parentId);
        $reply = Reply::create([
            "user_id" => Auth::user()->id,
            "comment_id" => $reply->comment_id,
            "content" => $request->input('content'),
            "parent_id" => $parentId,
            "created_at" => now(),
            "updated_at" => now(),
        ]);
        $reply->load('user');
        $reply->load('comment.user');
        $reply->time_ago = $reply->created_at->diffForHumans(['locale' => 'vi']);
        $reply->comment_id = [
            'id' => $reply->parent->user->id,
            'username' => $reply->parent->user->username
        ];
        $reply->reply_reply = [
            'id' => $this->findParentId($reply->parent_id),
            'username' => $this->findParentName($reply->parent_id)
        ];

        $userAuth = Auth::user();
        if($userAuth->id != $reply->parent->user->id){
            $tmp = Notification::create([
                'user_id' => $reply->parent->user->id,
                'type' => 'reply',
                'data' => json_encode([
                    'avatar_url' => $userAuth->avatar_url,
                    'message' => $userAuth->username . ' Đã phản hồi bình luận của bạn',
                    'url' => "/image/{$reply->comment->photo_id}"
                ])
            ]);
    
            broadcast(new PushNotification(
                "{$userAuth->username} Vừa phản hồi bình luận của bạn <3",
                $reply->parent->user,
                "/image/{$reply->comment->photo_id}",
                $userAuth,
                $tmp->id
            ))->toOthers();
        }

        return response()->json(['success' => true, 'reply' => $reply]);
    }
    public function SavedImage(Request $request)
    {
        $checkSavedImg = SavedImage::where('user_id', Auth::user()->id)->where('photo_id', $request->get('image_id'))->first();
        if ($checkSavedImg) {
            $checkSavedImg->delete();
            return response()->json(['success' => true, 'saved' => false]);
        }
        $savedImage = SavedImage::create([
            'user_id' => Auth::user()->id,
            'photo_id' => $request->get('image_id')
        ]);
        return response()->json(['success' => true, 'saved' => true]);
    }
    public function ShareImage($id)
    {
        $post = Photo::findOrFail($id);
        return response()->json([
            'title' => $post->title,
            'image' => $post->url,
            'url' => route('showimage', $post->id),
            'user' => $post->album->user->username,
        ]);
    }
    public function ReportImage(Request $request)
    {
        try {
            $postReview = PostReview::where('photo_id', $request->get('image_id'))->first();
            if (!$postReview) {
                $postReview = PostReview::create([
                    'photo_id' => $request->get('image_id'),
                    'review_content' => "Hình ảnh này phản cảm hoặc không hợp lệ",
                    'report_count' => 1,
                ]);
                $postReview->save();
            } else {
                if ($postReview->status == 'pending') {
                    $postReview->report_count = $postReview->report_count + 1;
                    $postReview->save();
                }
            }
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function DeleteCommentByOwner(Request $request)
    {
        try
        {
            $comment = Comment::findOrFail($request->get('comment_id'));
            $comment->delete();
            return response()->json(['success' => true]);
        }
        catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function DeleteReplyByOwner(Request $request)
    {
        try
        {
            $reply = Reply::findOrFail($request->get('reply_id'));
            $reply->delete();
            return response()->json(['success' => true]);
        }
        catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
