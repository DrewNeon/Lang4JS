<?php

namespace DrewNeon\Lang4JS;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class Lang4JSController extends Controller
{

  function getViewLangKeys($content, $keys=array(), $starts = array("@lang('", "trans('", "trans_choice('", "__('"), $end = "'"){
    $ranges = [
      "@lang('" => "'",
      "trans('" => "'",
      "trans_choice('" => "'",
      "__('" => "'",
      '@lang("' => '"',
      'trans("' => '"',
      'trans_choice("' => '"',
      '__("' => '"',
    ];

    foreach ($ranges as $start => $end) {
      $rs = explode($start, $content);
      array_shift($rs);
      array_values($rs);
      foreach ($rs as $r) {
        array_push($keys, explode($end,$r)[0]);
      }
    }
    $keys = array_values(array_unique($keys));
    return $keys;
  }

  function textBetween($str, $start, $end) {
    $parts = explode($start,$str);
    foreach ($parts as $part) {
      if (strpos($part,$end)!==false) {
        $str = explode($end,$part)[0];
      }
    }
    return $str;
  }

  function getJSContent($html, $js_full='') {
    // make an array with all contents between <script and </script>
    $html_split = explode('<script', $html);
    array_shift($html_split);
    array_values($html_split);
    $js_parts = array();
    // find all scripts in html
    foreach ($html_split as $html_part) array_push($js_parts, explode('</script',$html_part)[0]);

    $js_files = array();
    // seperate <script>s into and embedded script external files but not remotely hosted ones, which are very unlikely to have the locale patterns.
    foreach ($js_parts as $js_part) (strpos($js_part,'src="')!==false && strpos($js_part,'http')===false) ? array_push($js_files, self::textBetween($js_part,'src="','"')) : $js_full .= $js_part;
    // if there are external js, get their contents and append to $js_full;
    if (count($js_files)>0) foreach ($js_files as $js_file) $js_full .= \File::get(public_path($js_file));
    return $js_full;
  }

  public function lang4js(Request $htmlcontent) {

    $js_full = self::getJSContent($htmlcontent);
    // find trans(' and trans_choice(' in the full js script
    $js_keys = self::getViewLangKeys($js_full);
    // loop through $js_keys to get lang strings respectively
    if (count($js_keys)>0) {
      $lang_arr = array();
      // loop through each js key to get locale strings and prepare $lang_arr
      foreach ($js_keys as $js_key) {
        $lang_arr = array_add($lang_arr, str_replace("::", ".", str_replace("/",".",$js_key)), \Lang::get($js_key));
      }
    }

    return response()->json($lang_arr);

  }

}
