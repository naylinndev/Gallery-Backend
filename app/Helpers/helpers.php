<?php

use Ramsey\Uuid\Uuid;
use Illuminate\Http\Request;

function generateUUID5()
{
    try {
        // Generate a version 5 (name-based and hashed with SHA1) UUID object
        $uuid5 = Uuid::uuid5(Uuid::NAMESPACE_DNS, 'moha.net');

        return $uuid5->toString();
    } catch (\Exception $e) {
        throw $e;
    }
}

/**
 * This method is required by generateUniqueToken
 *
 * @param $min
 * @param $max
 *
 * @return mixed
 */
function cryptoRandSecure($min, $max)
{
    $range = $max - $min;
    if ($range < 1) {
        return $min;
    } // not so random...
    $log = ceil(log($range, 2));
    $bytes = (int) ($log / 8) + 1; // length in bytes
    $bits = (int) $log + 1; // length in bits
    $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
    do {
        $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
        $rnd = $rnd & $filter; // discard irrelevant bits
    } while ($rnd > $range);

    return $min + $rnd;
}

function generateUniqueToken($length = 20)
{
    $token = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet); // edited

    for ($i = 0; $i < $length; $i++) {
        $token .= $codeAlphabet[cryptoRandSecure(0, $max - 1)];
    }

    return $token;
}

/**
 * JavaScripts shortcut
 */
if ( ! function_exists('js')) {
    function js($scripts, $default)
    {
        $html = '';
        foreach ($scripts as $script) {
            $html .= Html::script($default.$script.'.js');
        }

        return $html;
    }
}

/*
 * CSS shortcut
 */
if ( ! function_exists('css')) {
    function css($styles, $default)
    {
        $html = '';
        foreach ($styles as $style) {
            $html .= Html::style($default.$style.'.css');
        }

        return $html;
    }
}



if (! function_exists('isActive')) {
   function isActive($slug)
   {  
      $curentSlug = request()->segment(3);
      if($curentSlug === trim($slug))
      {
        return 'active';
      }
      return false;
   }
 } 
