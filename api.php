<?php

require_once "./class.SqliteDB.php";
include_once "./class.SwishFormat.php";

$sf = new SwishFormat();
$db = new SqliteDB();

$db->connectDB('./__database/swish-123-data.sqlite');

header("Content-Type: text/plain;charset=UTF-8");


if (isset($_SERVER['REQUEST_METHOD'])) {
  if ($_SERVER['REQUEST_METHOD'] == "GET") {

    $action = "getCategories";
    if (isset($_GET['action'])) {
      $action = $_GET['action'];
    }

    $term = "insamlingskontroll";
    if (isset($_GET['term'])) {
      $term = $_GET['term'];
    }


    switch($action) {
      case "getCategories" :
        $result = $db->getCategoriesRanked();
        $json_response = json_encode($result);
        $response_status = 200;
        break;

      case "getRandomInCategory" :
        $result = $db->getSingleRandomFromCategories($term);
        $json_response = json_encode($result[0]);
        $response_status = 200;
        break;

      case "getFancyPresentation":
        $result = $sf->getSwishAllFormats($term);
        $json_response = json_encode($result);
        $response_status = 200;
        break;

      default :

        $response_status = 400;
        break;
    }
  }

  if ($_SERVER['REQUEST_METHOD'] == "OPTIONS") {
    
    // OPTIONS /doc HTTP/1.1
    // Host: bar.other
    // User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.14; rv:71.0) Gecko/20100101 Firefox/71.0
    // Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
    // Accept-Language: en-us,en;q=0.5
    // Accept-Encoding: gzip,deflate
    // Connection: keep-alive
    // Origin: https://foo.example
    // Access-Control-Request-Method: POST
    // Access-Control-Request-Headers: X-PINGOTHER, Content-Type

    header("Access-Control-Allow-Method: OPTIONS,GET");

    $response_status = 204;
  }
}

switch($response_status) {
  case 200:
    $response_status_header = "HTTP/1.1 200 OK";
    break;

  case 204:
    $response_status_header = "HTTP/1.1 204 No Content";
    break;

  case 400:

  default:
    $response_status_header = "HTTP/1.1 400 BAD REQUEST";
    break;
}

header($response_status_header);
if ($response_status == 200) {
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Origin: *");

  die($json_response);
}

if ($response_status == 204) {
  header("Content-Type: application/json; charset=UTF-8");
  header("Access-Control-Allow-Origin: *");
  die("");
}

header("Content-Type: text/plain");
die("BAD REQUEST");
