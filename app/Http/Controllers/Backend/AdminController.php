<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\Api\ApiController;
use App\Models\User;
use Auth;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Auth::user()->isAdmin()) {
            return view('backend.admin.index');
        } else {
            return redirect('/dashboard');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->isAdmin()) {
            $users = DB::table('users')
                ->select(['users.*'])->get();

            return Datatables::of($users)
                ->addIndexColumn()
                ->removeColumn('password')
                ->editColumn('updated_at', function ($data) {
                    return date('d-m-Y h:i A', strtotime($data->updated_at));
                })
                ->addColumn('action', function ($data) {
                    return '
                    <a href="#" class="btn btn-xs btn-warning reset-link" id="reset-' . $data->id . '"><i class="icon wb-power"></i>  Reset Password</a>
                    <a href="#" class="btn btn-xs btn-info edit-link" id="edit-' . $data->id . '"><i class="icon md-edit"></i>  Edit</a>
                    <a href="#" class="btn btn-xs btn-danger del-link" id="del-' . $data->id . '"><i class="icon md-delete"></i> Delete</a>';
                })
                ->make(true);

        }
    }

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
    public function store(Request $request)
    {
        //dd($request['password']);
        if (Auth::user()->isAdmin()) {

            $validate = Validator::make($request->only('name', 'email', 'password', 'password_confirmation','admin'), [
                'name'             => 'required',
                'email'            => 'required|unique:users',
                'password'         => 'required|confirmed|min:6',
                'password_confirmation' => 'sometimes|required_with:password',
                'admin'          => 'required',
            ]);

            if ($validate->fails()) {
                return $this->respond([
                    'status' => 'fail',
                    'msg'    => implode(",", $validate->messages()->all()),
                ]);
            } else {
                $data                   = new User;
                $data->name             = $request['name'];
                $data->email            = $request['email'];
                $data->administrator    = $request['admin'];
                $data->password         = Hash::make($request['password']);
                $data->save();

                return $this->respond([
                    'status' => 'success',
                    'msg'    => 'Add Account Successfully',
                ]);
            }
        } else {
            return redirect('/dashboard');
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
      $data = DB::table('users')->where('id', $id)->first();
      return Response::json(array(
          'status' => 'success',
          'name' => $data->name,
          'email' => $data->email,
          'administrator' => $data->administrator,
      ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
        public function adminUpdate(Request $request, $id)
        {
          if (Auth::user()->isAdmin()) {

              $validate = Validator::make($request->only('name', 'email', 'password', 'password_confirmation','admin'), [
                        'name'             => 'required',
                        'email'            => 'required',
                        'admin'          => 'required',
                      ]);

                if ($validate->fails()) {
                    return $this->respond([
                        'status' => 'fail',
                        'msg'    => implode(",", $validate->messages()->all()),
                    ]);
                } else {
                    $update = DB::table('users')
                      ->where('id', $id)
                      ->update(['name' => $request['name'],
                                'email' => $request['email'],
                                'administrator' => $request['admin'],
                                'updated_at' => now()
                                ]);

                    $user = User::where('id', $id)->first();

                    return $this->respond([
                      'status' => 'success',
                      'msg'    => 'Update Successfully',
                    ]);
                }

              } else {
                  return redirect('/dashboard');
              }

        }

/**
 * Show the form for editing the specified resource.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
    public function edit($id)
    {
      if (Auth::user()->isAdmin()) {
          $password = Str::random(10);
          $update   = DB::table('users')
                        ->where('id', $id)
                        ->update(['password' => Hash::make($password),
                         'updated_at' => now()]);

          if ($update) {
            $data = DB::table('users')->where('id', $id)->first();
            return Response::json(array(
                'status'   => 'success',
                'msg'      => 'Reset Password Successfully',
                'password' => $password,
                'username'    => $data->email,
              ));
          } else {
            return Response::json(array(
                'status' => 'fail',
                'msg'    => 'Error!!!',
              ));
            }
      }else {
        return redirect('/dashboard');
      }
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
            $validate = Validator::make($request->only('old_password', 'change_password', 'change_password_confirmation'), [
                'old_password'                 => 'required|min:6',
                'change_password'              => 'required|confirmed|min:6',
                'change_password_confirmation' => 'sometimes|required_with:change_password',
            ]);

            if ($validate->fails()) {
                return $this->respond([
                    'status' => 'fail',
                    'msg'    => implode(",", $validate->messages()->all()),
                ]);
            } else {
                $data = User::where('id', $id)->first();
                if (Hash::check($request['old_password'], $data->password)) {

                    $update = DB::table('users')
                        ->where('id', $id)
                        ->update(['password' => Hash::make($request['change_password']),
                        'updated_at' => now()]);

                    $user = User::where('id', $id)->first();

                    return $this->respond([
                        'status' => 'success',
                        'msg'    => 'Change Password Successfully',
                    ]);
                } else {
                    return $this->respond([
                        'status' => 'fail',
                        'msg'    => 'Incorect Password',
                    ]);
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
        if (Auth::user()->isAdmin()) {
            $delete = Db::table('users')->where('id', $id)->delete();
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

        } else {
            return redirect('/dashboard');
        }
    }
}
