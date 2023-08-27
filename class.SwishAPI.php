<?php

class SwishAPI {

  var $cache_dir = null;
  var $route = null;

  var $domain_prefix = 'https://b19.se';
  // var $url_prefix = '/swish-katalogen/';
  // var $cat_prefix = '/swish-katalogen/k/';
  // var $search_prefix = '/swish-katalogen/s/';
  var $api_prefix  = '/swish-katalogen/api/';

  var $routes = array(
    'ping',
    'search',
  );

  var $not_words = array(
    'från',
    'i',
    'med',
    'och',
    'oss',
    'till',
    'vi',
  );

  public function __destruct() {}

  public function __construct() {}


  public function setCacheDir($dir) {
    if(is_dir($dir)) {
      $this->cache_dir = $dir;
    } else {
      mkdir($dir);
      $this->cache_dir = $dir;
    }

  }

  public function getRoutingElements() {
    $result = null;
    if(isset($_SERVER['REQUEST_URI'])) {
      $uri = urldecode($_SERVER['REQUEST_URI']);

      /* Strip off trailing slash - blindly */
      $uri = preg_replace('/\x2f$/six', "", strval($uri));

      /* RE mask to remove beginning of URI */
      $mask = $this->_regexify($this->api_prefix);
      
      /* Assemble RE */
      $re_cut = "/^" . $mask . "(.*)$/six";

      if(preg_match($re_cut, strval($uri))) {
        
        /* Cut the URI */
        $uri_cut = preg_replace($re_cut, "$1", strval($uri));
        
        /* Clean up the URI -- Decode URLEncoding */
        $uri_clean = $this->_unrollEncoding($uri_cut);
        
        /* Prepare RE from $routes - joined with pipes */
        $re_route = "/^(" . strval(join("|", $this->routes)) . ")\\x2f(.*)/six";
        // echo($re_route);

        /* Generated RE will prepare for split */
        $prep_split = preg_replace($re_route, "$1|$2", strval($uri_clean));

        /* First part is always route, */
        /* Everything after first slash is arguments separated by slash */
        $result = preg_split('/\x7c/six', strval($prep_split));

        /* Set route */
        $this->_setRoute($result[0]);

      } else {
        print("Did not match<br>");
      }

    }
    return $result;
  }

  public function purgeCache() {
    if(is_dir($this->cache_dir)) {
      $files = (new AdvancedFilesystemIterator($this->cache_dir))->sortByMTime()->limit(0, 10);
      foreach($files as $file) {
        echo($file . "<br>");
      }
    }
  }

  public function setCacheObject($cache_key, $contents) {
    $cache_file = $this->cache_dir . $cache_key;
    if(is_file($cache_file) == false) {
      file_put_contents($cache_file, $contents);
    }
    return;
  }

  public function getCacheObject($cache_key) {
    $result = null;
    $cache_file = $this->cache_dir . $cache_key;
    if(is_file($cache_file) == true) {
      $result = file_get_contents($cache_file);
    }
    return $result;
  }

  public function checkCache($cache_key) {
    $result = array('status' => false);
    $cache_file = $this->cache_dir . $cache_key;
    if(is_file($cache_file)) {
      $result['status'] = true;
    }

    return $result;
  }

  public function getCacheKey($route_object) {
    $result = null;

    if(is_array($route_object)) {
      $cache_prep = array();
      if($route_object[0] == $this->route) {
        $cache_prep[] = $this->route;
        $cache_prep[] = sha1($route_object[1], false);
      }
      $result = join("-", $cache_prep) . ".json";
    }
    return $result;
  }

  public function splitSearchTerms($data) {
    $result = null;
    // Remove all double quotes
    $data = preg_replace('/\x22/six', "", strval($data));

    // Remove all single quotes
    $data = preg_replace('/\x27/six', "", strval($data));

    /* Split on [SPACE] */
    $parts = preg_split('/\x20/six', strval($data));

    if(is_array($parts)) {
      if(sizeof($parts) >= 1) {
        $result = $parts;
      }
    }

    /* Apply the NOT-words array here to filter out non-wanted words */
    if(is_array($result)) {
      $result_cleaned = array();
      foreach($result as $term) {
        $term = strtolower($term);
        if (in_array($term, $this->not_words, false) == false) {
          $result_cleaned[] = $term;
        }
      }
      $result = $result_cleaned;
    }
    return $result;
  }

  public function arrayResultSort($result_array) {
    $result = null;

    // Gather Entry as keys
    $entries = array_column($result_array, 'entry');
    
    // Sort on key Entrey with ASCending and NUMERIC
    array_multisort($entries, SORT_ASC, SORT_NUMERIC, $result_array);

    return $result_array;
  }

  private function _setRoute($data) {
    $this->route = $data;
  }

  private function _unrollEncoding($data) {
    while (preg_match('/\x25/six', strval($data))) {
      $data = urldecode($data);
    }
    return $data;
  }

  private function _regexify($data) {
    $data = preg_replace('/\x2d/six', "\\x2d", strval($data));
    $data = preg_replace('/\x2e/six', "\\x2e", strval($data));
    $data = preg_replace('/\x2f/six', "\\x2f", strval($data));
    $data = preg_replace('/\x3a/six', "\\x3a", strval($data));
    return $data;
  }
}