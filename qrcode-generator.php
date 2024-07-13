<?php

include_once "class.SwishQRCode.php";

// const $cache_folder = $_SERVER['DOCUMENT_ROOT'] . "/swish-katalogen/__cache/svg/";

define("SVG_CACHEFOLDER", $_SERVER['DOCUMENT_ROOT'] . "/swish-katalogen/__cache/svg/");

function existsInCache($code) {
  $result = "";
  // $cache_folder = SVG_CACHEFOLDER;
  if(is_dir(SVG_CACHEFOLDER)) {
    $cache_target = SVG_CACHEFOLDER . $code . ".svg";
    if(is_file($cache_target)) {
      // $result = file_get_contents($cache_target);
    }
  } else {
    die("Cache folder structure does not exist");
  }
  return $result;
}

function writeInCache($code, $svg) {
  $result = "";
  // $cache_folder = SVG_CACHEFOLDER;
  if(is_dir(SVG_CACHEFOLDER)) {
    $cache_target = SVG_CACHEFOLDER . $code . ".svg";
    $fh = fopen($cache_target, "w") or die("Unable to open file!");
    fwrite($fh, $svg);
    fclose($fh);
  } else {
    die("Cache folder structure does not exist");
  }
  return $result;
}

function purgeInCache() {
  echo("purgeInCache: start");
  if(is_dir(SVG_CACHEFOLDER)) {
    echo("SVG_CACHEFOLDER");
    if ($handle = opendir(SVG_CACHEFOLDER)) {
      echo "Directory handle: $handle\n";
      echo "Entries:\n";

      /* This is the correct way to loop over the directory. */
      while (false !== ($entry = readdir($handle))) {
        echo "$entry\n";
      }
    }
  }
}

function deflateSVG($data) {

}


if(isset($_SERVER['QUERY_STRING'])) {
  if(isset($_GET['code'])) {

    // purgeInCache();

    /* Get tainted (always presume tainted) input from querystring */
    $querystring_code = $_GET['code'];

    /* Force cleanup, we only want input that LOOKS like a Swish number -- by only allowing digits */
    $code = preg_replace('/[^0-9]/six', "", $querystring_code);

    /* Check that first three digits are "123" */
    if(preg_match('/^123/six', $code)) {

      /* 10 digits */
      if(preg_match('/^(\d{10})$/six', $code)) {

        $cached_result = existsInCache($code);
        $cached_result = "";
        if(strlen($cached_result) != 0) {
          $svg = $cached_result;
        } else {
          $qr_payload = "A" . $code;
          $qrcode = new QRCode($qr_payload);
          $svg = $qrcode->svg($qr_payload);
          // writeInCache($code, $svg);
        }

        header('Content-Type: image/svg+xml');
        //header('Content-Disposition: attachment; filename="swish-katalogen-' . $code . '.svg"');
        die($svg);
      }
    }

    if(preg_match('/^0703852166$/six', $code)) {
      $cached_result = existsInCache($code);
      $cached_result = "";
      if(strlen($cached_result) != 0) {
        $svg = $cached_result;
      } else {
        $amount = "";
        $message = "Swish-Katalogen";
        $status = "6";

        // $qr_payload = "A" . $code;
        $qr_payload = "C" . $code . ";" . $amount . ";" . $message . ";" . $status;

        $qrcode = new QRCode($qr_payload);
        $svg = $qrcode->svg($qr_payload);
        // writeInCache($code, $svg);
      }

      header('Content-Type: image/svg+xml');
      #header('Content-Disposition: attachment; filename="swish-katalogen-donation.svg"');
      die($svg);
    }

  }
  // header('Content-Type: text/html');
  // http_response_code(400);
  // die(null);
}

