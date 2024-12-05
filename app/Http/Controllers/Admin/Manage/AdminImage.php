<?php

namespace App\Http\Controllers\Admin\Manage;

use App\Console\Commands\DeleteImageAI;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Photo;
use App\Models\PostReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminImage extends Controller
{
    //
    public function ShowImage(){
        return view('Admin.Manage.Image');
    }
    public function ImageAPI(Request $request){
        $imagesPerPage = 2;
        $page = $request->get('page', 1);
        $photos = PostReview::where('status', 'pending')->with('photo')->paginate($imagesPerPage, ['*'], 'page', $page);
        return response()->json([
            'photos' => $photos->items(),
            'hasMorePages' => $photos->hasMorePages(),
        ]);
    }
    public function imageAcceptAPI(Request $request)
    {
        $imagesPerPage = 2;
        $page = $request->get('page', 1);
        $photos = PostReview::where('status', 'approved')->with(['photo', 'admin'])->orderBy('report_count', 'desc')->paginate($imagesPerPage, ['*'], 'page', $page);
        return response()->json([
            'photos' => $photos->items(),
            'hasMorePages' => $photos->hasMorePages(),
        ]);
    }
    public function imageRejectAPI(Request $request)
    {
        $imagesPerPage = 2;
        $page = $request->get('page', 1);
        $photos = PostReview::where('status', 'rejected')->with(['photo', 'admin'])->orderBy('report_count', 'desc')->paginate($imagesPerPage, ['*'], 'page', $page);
        return response()->json([
            'photos' => $photos->items(),
            'hasMorePages' => $photos->hasMorePages(),
        ]);
    }
    public function ApprovedReport(Request $request)
    {
        try
        {
            $id = $request->get('image_id');
            $image = PostReview::findOrFail($id);
            $image->status = 'approved';
            $image->admin_id = Auth::guard('admin')->user()->id;
            $image->save();
            $this->ChangeDeletedImageReport($image->photo_id, 1);

            Notification::create([
                'user_id' => $image->photo->album->user_id,
                'type' => 'report',
                'data' => json_encode([
                    'url' => $image->photo->url,
                    'message' => 'Ảnh của bạn đã được đồng ý hiển thị sau khi nhận báo cáo!',
                ]),
                'is_read' => 0, 
            ]);

            return response()->json(['success' => true]);
        }
        catch (\Exception $e)
        {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function RejectReport(Request $request)
    {
        try
        {
            $id = $request->get('image_id');
            $image = PostReview::findOrFail($id);
            $image->status = 'rejected';
            $image->admin_id = Auth::guard('admin')->user()->id;
            $image->save();
            $this->ChangeDeletedImageReport($image->photo_id, 0);

            Notification::create([
                'user_id' => $image->photo->album->user_id,
                'type' => 'report',
                'data' => json_encode([
                    'url' => $image->photo->url,
                    'message' => 'Ảnh của bạn không được đồng ý hiển thị sau khi nhận báo cáo!',
                ]),
                'is_read' => 0, 
            ]);

            return response()->json(['success' => true]);
        }
        catch (\Exception $e)
        {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function ChangeDeletedImageReport($id, $flag)
    {
        $image = Photo::findOrFail($id);
        if($flag == 1)
        {
            $image->is_deleted = 1;
        }
        else
        {
            $image->is_deleted = 0;
        }
        $image->save();
    }
}
