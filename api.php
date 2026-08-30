<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors','On');

include_once "site.config.php";

include_once "class.MySQLDB.php";
include_once "class.SwishKatalogen.php";
include_once "class.SwishAPI.php";

$db = new MySQLDB();
$ui = new SwishKatalogen();
$api = new SwishAPI();

$dbparam = $config["db"]["mysql"];

$db->connectDB(
  $dbparam["hostname"],
  $dbparam["port"],
  $dbparam["username"],
  $dbparam["password"],
  $dbparam["database"],
);

/* Declare header we want to keep */
$headers_onlykeep = array(
  'cache-control',
  'content-encoding',
  'content-type',
  'date',
  'expires',
  'vary',
);

$headers_cors = array(
  "Access-Control-Allow-Credentials"  => "false",
  "Access-Control-Allow-Headers"      => "*",
  "Access-Control-Allow-Methods"      => "OPTIONS,GET",
  "Access-Control-Allow-Origin"       => "*",
  "Access-Control-Expose-Headers"     => "*",
  "Access-Control-Max-Age"            => "86400",
  "Access-Control-Request-Headers"    => "Content-type",
  "Access-Control-Request-Method"     => "GET"
);


$http_response_status = 400;
$http_response_body = "";
$http_response_content_type = "text/plain";

$cache_json_dir = './__cache/json/';
$api->setCacheDir($cache_json_dir);

/* Fire off purgeCache */
$api->purgeCache();

$routing = $api->getRoutingElements();
if(is_array($routing)) {
  $cache_key = $api->getCacheKey($routing);

  $http_response_status = 200;
  $http_response_content_type = 'application/json';

  switch($routing[0]) {

    case "search":
      $cached = $api->checkCache($cache_key);
      if($cached['status'] == false) {
        $result = array();
        $search_terms = $api->splitSearchTerms($routing[1]);
        if(is_array($search_terms)) {
          foreach($search_terms as $term) {
            $term_result = $db->getItemsByTerm($term);
            foreach($term_result as $word_result) {
              $result[] = $word_result;
            }
          }
          $result = $api->arrayResultSort($result);
          // $http_response_status = 200;
          // $http_response_content_type = 'application/json';
          $http_response_body = json_encode($result);
          $api->setCacheObject($cache_key, $http_response_body);
        }
      } else {
        // $http_response_status = 200;
        // $http_response_content_type = 'application/json';
        $http_response_body = $api->getCacheObject($cache_key);
      }
      break;

    case "getHistoryToplist":
      $cached = $api->checkCache($cache_key);
      if($cached['status'] == false) {
        $toplist = $db->getHistoryToplist();
        // $http_response_status = 200;
        // $http_response_content_type = 'application/json';
        $http_response_body = json_encode($toplist);
        $api->setCacheObject($cache_key, $http_response_body);
      } else {
        // $http_response_status = 200;
        // $http_response_content_type = 'application/json';
        $http_response_body = $api->getCacheObject($cache_key);
      }
      break;

    case "getHistoryLatest":
      $cached = $api->checkCache($cache_key);
      if($cached['status'] == false) {
        $latest = $db->getHistoryLatest();
        // $http_response_status = 200;
        // $http_response_content_type = 'application/json';
        $http_response_body = json_encode($latest);
        $api->setCacheObject($cache_key, $http_response_body);
      } else {
        // $http_response_status = 200;
        // $http_response_content_type = 'application/json';
        $http_response_body = $api->getCacheObject($cache_key);
      }
      break;

    default:
      break;
  }

} else {
  // Here we should return a 400 status
  $http_response_status = 400;
  $http_response_body = "";
  http_response_code($http_response_status);
  die($http_response_body);
}

/* Maintenance - Cleanup */

/* FIXME: headers_sent() */
if (1 == 1) {
  foreach(headers_list() as $headitem) {

    /* split header as key => value on ": " */
    $headkv = preg_split("/\x3a\x20/", strtolower($headitem));
    
    /* Is it not in $headers_onlykeep? */
    if (!in_array(strval($headkv[0]), $headers_onlykeep)) {
      
      /* remove it */
      header_remove(strval($headkv[0]));
    }
  }
}

if (1 == 1) {
  foreach($headers_cors => $key, $value) {
    header(strval($key) . ": " . strval($value));
  }
}

header('Content-Type: ' . $http_response_content_type);
http_response_code($http_response_status);
die($http_response_body);