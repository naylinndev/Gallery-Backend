<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\Api\ApiController;
use App\Models\Category;
use App\Models\Photo;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class PhotoController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('backend.photo.index', compact('categories'));
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
            $data = Photo::orderBy('created_at', 'asc')->paginate(5);
            $arr = [];


            foreach ($data as $photo) {
                $res = Category::whereIn('id', json_decode($photo->category_ids))->get();
                $category_names = [];
                foreach ($res as $obj) {
                    array_push($category_names, ['category_id' => $obj->id, 'category_name' => $obj->category_name,'category_image' => $obj->category_image]);
                }

                array_push($arr, [
                    'id' => $photo->id,
                    'title' => $photo->title,
                    'description' => $photo->description,
                    'make' => $photo->make,
                    'model' => $photo->model,
                    'image' => $photo->image,
                    'updated_at' => date('d-m-Y h:i A', strtotime($photo->updated_at)),
                    'categories' => $category_names

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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getPhotosByCateogry(Request $request)
    {
        $validate = Validator::make($request->only('app_secret', 'category_id'), [
            'app_secret'   => 'required',
            'category_id'   => 'required',
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
            $data = Photo::where('category_ids', 'LIKE', '%"' . $request['category_id'] . '"%')->orderBy('created_at', 'asc')->paginate(5);
            $arr = [];


            foreach ($data as $photo) {
                $res = Category::whereIn('id', json_decode($photo->category_ids))->get();
                $category_names = [];
                foreach ($res as $obj) {
                    array_push($category_names, ['category_id' => $obj->id, 'category_name' => $obj->category_name,'category_image' => $obj->category_image]);
                }

                array_push($arr, [
                    'id' => $photo->id,
                    'title' => $photo->title,
                    'description' => $photo->description,
                    'make' => $photo->make,
                    'model' => $photo->model,
                    'image' => $photo->image,
                    'updated_at' => date('d-m-Y h:i A', strtotime($photo->updated_at)),
                    'categories' => $category_names
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

        return Datatables::of(Photo::query())
            ->addIndexColumn()
            ->editColumn('created_at', function ($data) {
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

        $validate = Validator::make($request->only('title', 'description', 'make', 'model', 'image', 'category_ids'), [
            'title' => 'required',
            'description' => 'required',
            'make' => 'required',
            'model' => 'required',
            'category_ids' => 'required',
            'image' => 'required',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048',

        ]);

        if ($validate->fails()) {
            return Response::json(array(
                'status' => 'fail',
                'msg'    => implode(",", $validate->messages()->all()),
            ));
        } else {
            $image = "";
            if ($request->hasfile('image')) {
                $storagePath = Storage::disk('s3')->put('NToon/' . env('APP_STATUS', 'dev') . '/Gallery/Photos', $request->image, 'public');
                $image = $this->S3URL . $storagePath;
            }

            $inserted = DB::table('photo')->insert(
                [
                    'title' => $request['title'],
                    'description' => $request['description'],
                    'make' => $request['make'],
                    'model' => $request['model'],
                    'image' => $image,
                    'category_ids' => json_encode($request['category_ids']),
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            if ($inserted) {
                return Response::json(array(
                    'status' => 'success',
                    'msg'    => 'Add Photo Successfully',
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
        $photo = Photo::where('id', $id)->first();
        return Response::json(array(
            'status' => 'success',
            'data'   => [
                'title' => $photo->title,
                'description' => $photo->description,
                'make' => $photo->make,
                'model' => $photo->model,
                'image' => $photo->image,
                'category_ids' => json_decode($photo->category_ids),

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

        $validate = Validator::make($request->only('title', 'description', 'make', 'model', 'category_ids'), [
            'title' => 'required',
            'description' => 'required',
            'make' => 'required',
            'model' => 'required',
            'category_ids' => 'required'
        ]);


        if ($validate->fails()) {
            return Response::json(array(
                'status' => 'fail',
                'msg'    => implode(",", $validate->messages()->all()),
            ));
        } else {
            $data = Db::table('photo')->where('id', $id)->first();


            $image = $data->image;
            if ($request->hasfile('image')) {
                $storagePath = Storage::disk('s3')->put('NToon/' . env('APP_STATUS', 'dev') . '/Gallery/Photos', $request->image, 'public');
                $image = $this->S3URL . $storagePath;
            }

            $update = DB::table('photo')->where('id', $id)
                ->update(
                    [
                        'title' => $request['title'],
                        'description' => $request['description'],
                        'make' => $request['make'],
                        'model' => $request['model'],
                        'image' => $image,
                        'category_ids' => json_encode($request['category_ids']),
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

        $delete = Db::table('photo')->where('id', $id)->delete();
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
