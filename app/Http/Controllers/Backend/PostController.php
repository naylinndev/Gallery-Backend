<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\Api\ApiController;
use App\Models\Post;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.post.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
        $validate = Validator::make($request->only('app_secret'), [
            'app_secret'   => 'required',
        ]);

        if ($validate->fails()) {
            return $this->respond([
                'status' => 'fail',
                'msg'    => implode(",", $validate->messages()->all()),
            ]);
        } else {
            if ($request['app_secret'] != env('APP_SECRECT', '')) {
                return $this->respond([
                    'status' => 'exception',
                    'msg'    => 'Something Wrong',
                ]);
            }
            $data = Post::orderBy('created_at', 'asc')->paginate(20);
            $arr = [];


            foreach ($data as $event) {
                array_push($arr, [
                    'id' => $event->id,
                    'title' => $event->title,
                    'description' => $event->description,
                    'post_images' => json_decode($event->images),
                    'video' => $event->video,
                    'thumbnail' => $event->thumbnail,
                    'is_video' => $event->is_video,
                    'sent_noti' => $event->sent_noti,
                ]);
            }

            return $this->respond([
                'status'  => 'success',
                'msg'     => 'OK',
                'current_page' => $data->currentPage(),
                'has_more_pages'   => $data->hasMorePages(),
                'data'    => $arr,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return Datatables::of(Post::query())
            ->addIndexColumn()
            ->editColumn('updated_at', function ($data) {
                return date('d-m-Y h:i A', strtotime($data->updated_at));
            })
            ->addColumn('action', function ($data) {
                return '
                <a href="#" class="btn btn-xs btn-info edit-link" id="edit-' . $data->id . '"><i class="icon md-edit"></i>  Edit</a>
                <a href="#" class="btn btn-xs btn-danger del-link" id="del-' . $data->id . '"><i class="icon md-delete"></i> Delete</a>';
            })->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validate = Validator::make($request->only('title', 'description', 'is_video', 'sent_noti'), [
            'title' => 'required',
            'description' => 'required',
            'is_video' => 'required',
            'sent_noti' => 'required',
        ]);

        if ($validate->fails()) {
            return Response::json(array(
                'status' => 'fail',
                'msg'    => implode(",", $validate->messages()->all()),
            ));
        } else {
            $images = [];
            $thumbnail_image = '';
            $youtube_id = '';

            if ($request->hasfile('post_images')) {

                foreach ($request->file('post_images') as $image) {
                    $storagePath = Storage::disk('s3')->put('HKY/' . env('APP_STATUS', 'dev') . '/Post', $image, 'public');

                    array_push($images,$this->S3URL . $storagePath);
                }
                $thumbnail_image = $images[0];
            }

            if($request['is_video']){
                $youtube_id = $this->getYoutubeIdFromUrl($request['video']);
                $thumbnail_image = 'https://img.youtube.com/vi/'.$youtube_id.'/0.jpg';

            }

            $inserted = DB::table('post')->insert(
                [
                    'title' => $request['title'],
                    'description' => $request['description'],
                    'images' => json_encode($images),
                    'video' => $youtube_id,
                    'thumbnail' => $thumbnail_image,
                    'sent_noti' => $request['sent_noti'],
                    'is_video' => $request['is_video'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            if ($inserted) {
                return Response::json(array(
                    'status' => 'success',
                    'msg'    => 'Add Post Successfully',
                ));
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::where('id', $id)->first();
        return Response::json(array(
            'status' => 'success',
            'data'   => [
                'title' => $post->title,
                'description' => $post->description,
                'post_images' => json_decode($post->images),
                'video' => $post->video,
                'thumbnail' => $post->thumbnail,
                'is_video' => $post->is_video,
                'sent_noti' => $post->sent_noti
            ]
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validate = Validator::make($request->only('title', 'description', 'is_video', 'sent_noti'), [
            'title' => 'required',
            'description' => 'required',
            'is_video' => 'required',
            'sent_noti' => 'required',
        ]);


        if ($validate->fails()) {
            return Response::json(array(
                'status' => 'fail',
                'msg'    => implode(",", $validate->messages()->all()),
            ));
        } else {
            $images = [];
            $thumbnail_image = '';
            $youtube_id = '';

            if ($request->hasfile('post_images')) {

                foreach ($request->file('post_images') as $image) {
                    $storagePath = Storage::disk('s3')->put('HKY/' . env('APP_STATUS', 'dev') . '/Post', $image, 'public');

                    array_push($images,$this->S3URL . $storagePath);
                }
                $thumbnail_image = $images[0];
            }

            if($request['is_video']){
                $youtube_id = $this->getYoutubeIdFromUrl($request['video']);
                $thumbnail_image = 'https://img.youtube.com/vi/'.$youtube_id.'/0.jpg';

            }

            $update = DB::table('post')->where('id', $id)
            ->update(
                [
                    'title' => $request['title'],
                    'description' => $request['description'],
                    'images' => json_encode($images),
                    'video' => $youtube_id,
                    'thumbnail' => $thumbnail_image,
                    'sent_noti' => $request['sent_noti'],
                    'is_video' => $request['is_video'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            if ($update) {
                return Response::json(array(
                    'status' => 'success',
                    'msg'    => 'Update Successfully',
                ));
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $delete = Db::table('post')->where('id', $id)->delete();
        if ($delete) {
            return Response::json(array(
                'status' => 'success',
                'msg'    => 'Delete Successfully',
            ));
        } else {
            return Response::json(array(
                'status' => 'fail',
                'msg'    => 'Error!!!',
            ));
        }
    }
}
