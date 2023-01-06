<?php

namespace App\Http\Controllers\Backend\Api;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\FootballDevice;
use App\Models\VpnDevice;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

/**
 * Class ApiController
 *
 * @package \Furetech\Api\Controller
 */
class ApiController extends Controller
{
  /**
   * @var int
   */
  protected $showAppReviewForNtoon = false;
  protected $showAppReview = false;

  protected $staticWebsiteDetailPage = 'https://static.ntoon.app/detail/gameWinner';

  protected $statusCode = 200;
  protected $S3URL = 'https://s3.ap-southeast-1.amazonaws.com/ntoon/';

  /**
 * Get Youtube video ID from URL
 *
 * @param string $url
 * @return mixed Youtube video ID or FALSE if not found
 */
function getYoutubeIdFromUrl($url) {
  $parts = parse_url($url);
  if(isset($parts['query'])){
      parse_str($parts['query'], $qs);
      if(isset($qs['v'])){
          return $qs['v'];
      }else if(isset($qs['vi'])){
          return $qs['vi'];
      }
  }
  if(isset($parts['path'])){
      $path = explode('/', trim($parts['path'], '/'));
      return $path[count($path)-1];
  }
  return false;
}


  function tag_contents($string, $tag_open, $tag_close){
    $result = [];
    foreach (explode($tag_open, $string) as $key => $value) {
        if(strpos($value, $tag_close) !== FALSE){
             $result[] = substr($value, 0, strpos($value, $tag_close));;
        }
    }
    return $result;
 }

  public function getDateByTimezone($date, $timezone)
  {
    $date = Carbon::createFromFormat('Y-m-d', $date, 'Asia/Yangon');
    $date->setTimezone($timezone);

    return $date;
  }

  public static function quickRandom($length = 16)
  {
    $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return substr(str_shuffle(str_repeat($pool, 5)), 0, $length);
  }


  /**
   * @param $statusCode
   *
   * @return $this
   */
  public function setStatusCode($statusCode)
  {
    $this->statusCode = $statusCode;
    return $this;
  }

  public function updateDotEnv($key, $newValue, $delim = '')
  {

    $path = base_path('.env');
    // get old value from current env
    $oldValue = env($key);

    // was there any change?
    if ($oldValue === $newValue) {
      return;
    }

    // rewrite file content with changed data
    if (file_exists($path)) {
      // replace current value with new value
      file_put_contents(
        $path,
        str_replace(
          $key . '=' . $delim . $oldValue . $delim,
          $key . '=' . $delim . $newValue . $delim,
          file_get_contents($path)
        )
      );
    }
  }

  /**
   * @param       $data
   * @param array $headers
   *
   * @return mixed
   */

  public function respondWithStatusCode($data, $statusCode, $headers = [])
  {
    return Response::json($data, $statusCode, $headers);
  }

  public function respond($data, $headers = [])
  {
    return Response::json($data, $this->getStatusCode(), $headers);
  }

   /**
   * @return int
   */
  public function getStatusCode()
  {
    return $this->statusCode;
  }

  /**
   * @param string $message
   *
   * @return mixed
   */
  public function respondNotFound($message = 'Not Found')
  {
    return $this->setStatusCode(404)->respondWithError($message);
  }

  /**
   * @param string $message
   *
   * @return mixed
   */
  public function respondInternalError($message = 'Internal Server Error')
  {
    return $this->setStatusCode(500)->respondWithError($message);
  }

  /**
   * @param $message
   *
   * @return mixed
   */
  public function respondWithError($message)
  {
    return $this->respond([
      'error' => [
        'message'     => $message,
        'status_code' => $this->getStatusCode(),
      ],
    ]);
  }


  public function getTimeAgo($carbonObject)
  {
    return str_ireplace(
      [' seconds', ' second', ' minutes', ' minute', ' hours', ' hour', ' days', ' day', ' weeks', ' week'],
      ['s', 's', 'm', 'm', 'h', 'h', 'd', 'd', 'w', 'w'],
      $carbonObject->diffForHumans()
    );
  }
}
