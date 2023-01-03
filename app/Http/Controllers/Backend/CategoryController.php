<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\Api\ApiController;
use App\Models\Category;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.category.index');
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
            $data = Category::orderBy('created_at', 'asc')->paginate(20);
            $arr = [];


            foreach ($data as $category) {
                array_push($arr, [
                    'id' => $category->id,
                    'category_name' => $category->category_name,
                    'category_image' => $category->category_image,
                    'updated_at' => date('d-m-Y h:i A', strtotime($category->updated_at))

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

        return Datatables::of(Category::query())
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

        $validate = Validator::make($request->only('category_name', 'category_image'), [
            'category_name' => 'required|unique:category',
            'category_image' => 'required',
            'category_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4048',

        ]);

        if ($validate->fails()) {
            return Response::json(array(
                'status' => 'fail',
                'msg'    => implode(",", $validate->messages()->all()),
            ));
        } else {
            $category_image = "";
            if ($request->hasfile('category_image')) {
                $storagePath = Storage::disk('s3')->put('NToon/' . env('APP_STATUS', 'dev') . '/Gallery/Category', $request->category_image, 'public');
                $category_image = $this->S3URL . $storagePath;
            }

            $inserted = DB::table('category')->insert(
                [
                    'category_name' => $request['category_name'],
                    'category_image' => $category_image,
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            if ($inserted) {
                return Response::json(array(
                    'status' => 'success',
                    'msg'    => 'Add Category Successfully',
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
        $post = Category::where('id', $id)->first();
        return Response::json(array(
            'status' => 'success',
            'data'   => [
                'category_name' => $post->category_name,
                'category_image' => $post->category_image
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

        $validate = Validator::make($request->only('category_name'), [
            'category_name' => 'required',

        ]);


        if ($validate->fails()) {
            return Response::json(array(
                'status' => 'fail',
                'msg'    => implode(",", $validate->messages()->all()),
            ));
        } else {
            $data = Db::table('category')->where('id', $id)->first();


            $category_image = $data->category_image;
            if ($request->hasfile('category_image')) {
                $storagePath = Storage::disk('s3')->put('NToon/' . env('APP_STATUS', 'dev') . '/Gallery/Category', $request->category_image, 'public');
                $category_image = $this->S3URL . $storagePath;
            }

            $update = DB::table('category')->where('id', $id)
                ->update(
                    [
                        'category_name' => $request['category_name'],
                        'category_image' => $category_image,
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

        $delete = Db::table('category')->where('id', $id)->delete();
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
