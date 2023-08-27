<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors','On');

include_once "site.config.php";

include_once "class.SqliteDB.php";
include_once "class.SwishKatalogen.php";
include_once "class.SwishAPI.php";

$db = new SqliteDB();
$ui = new SwishKatalogen();
$api = new SwishAPI();

$db->connectDB($config["db"]["sqlite"]["filepath"]);

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
  // echo($cache_key . "<br>");

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
          $http_response_status = 200;
          $http_response_content_type = 'application/json';
          $http_response_body = json_encode($result);
          $api->setCacheObject($cache_key, $http_response_body);
        }
      } else {
        $http_response_status = 200;
        $http_response_content_type = 'application/json';
        $http_response_body = $api->getCacheObject($cache_key);
      }
      break;

    default:
      break;
  }

} else {
  // Here we should return a 400 status
  $http_response_status = 400;
}

header('Content-Type: ' . $http_response_content_type);
http_response_code($http_response_status);
die($http_response_body);