<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\Api\ApiController;
use App\Models\Category;
use App\Models\Comic;
use App\Models\ComicDetail;
use App\Models\Device;
use App\Models\Favorite;
use App\Models\History;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;

class DashboardController extends ApiController
{
  /**
   * To check status 
   */
  public function status()
  {
    return $this->respond([
      'status'  => 'success',
      'msg'     => 'Status is working',
    ]);
  }


  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    $users = number_format(DB::table('users')->count());
    $photos = number_format(DB::table('photo')->count());
    $category = number_format(DB::table('category')->count());
   
    return view('backend.dashboard.index', compact('users', 'photos','category'));
  }
}
