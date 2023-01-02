<?php

namespace App\Http\Controllers\Backend;

use App\Models\Notification;
use App\Http\Controllers\Backend\Api\ApiController;
use App\Models\Device;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class NotificationController extends ApiController
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $systems = $this->systems;
        return view('backend.notification.index',compact('systems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Datatables::of(Notification::query())
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                $date = now()->format('Y-m-d');
                if ($date > $data->expired_date) {
                    $status = 'expired';
                } else {
                    $status = 'valid';
                }
                return $status;
            })
            ->editColumn('created_at', function ($data) {
                return date('d-m-Y h:i A', strtotime($data->created_at));
            })
            ->addColumn('action', function ($category) {
                return '<a href="#" class="btn btn-xs btn-info edit-link" id="edit-' . $category->id . '"><i class="icon md-edit"></i>  Edit</a>
                <a href="#" class="btn btn-xs btn-danger del-link" id="del-' . $category->id . '"><i class="icon md-delete"></i> Delete</a>';
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
        $validate = Validator::make($request->only(
            'title',
            'description',
            'redirect_url',
            'expired_date',
            'min_point',
            'notification_image',
            'type',
            'system'
        ), [
            'notification_image' => 'required',
            'notification_image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title'  => 'required',
            'description'  => 'required',
            'redirect_url'  => 'required',
            'min_point'  => 'required',
            'expired_date'  => 'required',
            'type'  => 'required',
            'system'  => 'required',
        ]);

        if ($validate->fails()) {
            return Response::json(array(
                'status' => 'fail',
                'msg'    => implode(",", $validate->messages()->all()),
            ));
        } else {

            if ($request->hasfile('notification_image')) {
                $storagePath = Storage::disk('s3')->put('NToon/' . env('APP_STATUS', 'dev') . '/Notification', $request->notification_image, 'public');
                $notification_image = $this->S3URL . $storagePath;
            }

            $inserted = DB::table('notification')->insert(
                [
                    'title' => $request['title'],
                    'description' => $request['description'],
                    'redirect_url' => $request['redirect_url'],
                    'expired_date' => $request['expired_date'],
                    'min_point' => $request['min_point'],
                    'notification_image' => $notification_image,
                    'type' => $request['type'],
                    'system' => $request['system'],
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            );

            if ($inserted) {
                return Response::json(array(
                    'status' => 'success',
                    'msg'    => 'Add Notification Successfully',
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
        $data = DB::table('notification')->where('id', $id)->first();

        return Response::json(array(
            'status' => 'success',
            'data'   => [
                'id' => $data->id,
                'title' => $data->title,
                'description' => $data->description,
                'redirect_url' => $data->redirect_url,
                'min_point' => $data->min_point,
                'expired_date' => $data->expired_date,
                'notification_image' => $data->notification_image,
                'type' => $data->type,
                'system' => $data->system,
            ],
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
        $validate = Validator::make($request->only(
            'title',
            'description',
            'redirect_url',
            'expired_date',
            'min_point',
            'type',
            'system'
        ), [
            'title'  => 'required',
            'description'  => 'required',
            'redirect_url'  => 'required',
            'min_point'  => 'required',
            'expired_date'  => 'required',
            'type'  => 'required',
            'system'  => 'required',

        ]);
        if ($validate->fails()) {
            return Response::json(array(
                'status' => 'fail',
                'msg'    => implode(",", $validate->messages()->all()),
            ));
        } else {
            $data = Db::table('notification')->where('id', $id)->first();
            Db::table('activity_logs')->insert(['admin_id' => Auth::user()->id, 'admin_name' => Auth::user()->name, 'type' => 'Update Notification', 'content' => json_encode($data)]);

            if ($request->hasfile('notification_image')) {
                $storagePath = Storage::disk('s3')->put('NToon/' . env('APP_STATUS', 'dev') . '/Notification', $request->notification_image, 'public');
                $notification_image = $this->S3URL . $storagePath;

                $update = DB::table('notification')->where('id', $id)->update(
                    [
                        'title' => $request['title'],
                        'description' => $request['description'],
                        'redirect_url' => $request['redirect_url'],
                        'expired_date' => $request['expired_date'],
                        'min_point' => $request['min_point'],
                        'notification_image' => $notification_image,
                        'type' => $request['type'],
                        'system' => $request['system'],
                        'updated_at' => now()
                    ]
                );
            } else {

                $update = DB::table('notification')->where('id', $id)->update(
                    [
                        'title' => $request['title'],
                        'description' => $request['description'],
                        'redirect_url' => $request['redirect_url'],
                        'expired_date' => $request['expired_date'],
                        'min_point' => $request['min_point'],
                        'type' => $request['type'],
                        'system' => $request['system'],
                        'updated_at' => now()
                    ]
                );
            }

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
        $data = Db::table('notification')->where('id', $id)->first();
        Db::table('activity_logs')->insert(['admin_id' => Auth::user()->id, 'admin_name' => Auth::user()->name, 'type' => 'Delete Notification', 'content' => json_encode($data)]);

        $delete = Db::table('notification')->where('id', $id)->delete();
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
