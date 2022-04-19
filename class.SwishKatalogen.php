<?php

class SwishKatalogen {
  
  var $domain_prefix = 'https://b19.se';

  var $url_prefix = '/swish-katalogen/';
  var $cat_prefix = '/swish-katalogen/k/';


  public function getCategoryRouting() {
    $result = null;
    if(isset($_SERVER['REQUEST_URI'])) {
      $uri = urldecode($_SERVER['REQUEST_URI']);

      /* Strip off trailing slash - blindly */
      $uri = preg_replace('/\x2f$/six', "", strval($uri));

      $mask = $this->_regexify($this->cat_prefix);
      $re = "/^" . $mask . "/six";
      if(preg_match($re, strval($uri))) {
        $result = preg_replace($re, "", strval($uri));
      }

      $mask = $this->_regexify($this->url_prefix);
      $re = "/^" . $mask . "(123(\d{7}))$/six";
      if(preg_match($re, strval($uri))) {
        $result = preg_replace($re, "$1", strval($uri));
      }

    }
    return $result;
  }

  public function getEntriesCategoryListing($items) {
    $result = null;
    $table_rows = array();
    $table_rows[] = "<tr><th>Nummer</th><th>Organisation</th></tr>";
    foreach($items as $item) {
      $row = array();
      $entry = $item['entry'];
      $orgName = $item['orgName'];
      $row[] = "<tr>";
      $row[] = "<td>";
      $row[] = '<a href="' . $this->url_prefix . $entry . '" title="Swish-nummer ' . $entry . ' för ' . $orgName . '">';
      $row[] = strval($entry);
      $row[] = '</a>';
      $row[] = "</td>";
      $row[] = "<td>";
      $row[] = '<a href="' . $this->url_prefix . $entry . '" title="Swish-nummer ' . $entry . ' för ' . $orgName . '">';
      $row[] = strval($orgName);
      $row[] = '</a>';
      $row[] = "</td>";
      $row[] = "</tr>";
      $row_fragment = join($row);
      $table_rows[] = $row_fragment;
    }
    $result = join($table_rows);
    return $result;
  }

  public function getEntryCategories($list) {
    $result = null;
    $elem = array();
    foreach($list as $item) {
      $elem[] = '<li><a itemprop="keywords" href="' . $this->cat_prefix . strval($item) . '">' . strval($item) . '</a></li>';
    }
    $result = join($elem);
    return $result;
  }

  public function getOtherCategories($categories, $exclude) {
    $result = null;
    $elem = array();
    foreach($categories as $item) {
      $category = $item['category'];
      if(!in_array($category, $exclude)) {
        $elem[] = '<li><a href="' . $this->cat_prefix . strval($category) . '">' . strval($category) . '</a></li>';
      }
    }
    $result = join($elem);
    return $result;
  }


  public function getCategoriesTagCloud($ranked_array, $selected) {
    $rank_low = 9999;
    $rank_high = 0;

    /* Just get high and low quantities */
    foreach($ranked_array as $item) {
      if(isset($item['quantity'])) {
        $quantity = intval($item['quantity']);
        if($quantity <= $rank_low) {
          $rank_low = $quantity;
        }

        if($quantity >= $rank_high) {
          $rank_high = $quantity;
        }
      }
    }

    $rank_diff = ($rank_high - $rank_low);

    /* Render some html for in-page inclusion */
    $cat_list = array();
    foreach($ranked_array as $item) {
      $quantity = intval($item['quantity']);
      $category = strval($item['category']);

      $elem = array();

      if($category == $selected) {
        $elem[] = '<li class="li-category-selected">';
      } else {
        $elem[] = '<li>';
      }
      $elem[] = '<a href="' . $this->cat_prefix . strval($category) . '" title="' . $quantity . ' förekomster i kategorin - ' . $category . ' -">';
      $elem[] = strval($category);
      $elem[] = '</a>';
      $elem[] = '</li>';

      $entry = join($elem);
      $cat_list[] = $entry;
    }
    $category_list = join($cat_list);
    return $category_list;
  }

  // array(10) { [0]=> string(10) "1234197026" [1]=> string(11) "12341 97026" [2]=> string(13) "123 41 970 26" [3]=> string(13) "123 419 70 26" [4]=> string(12) "123 419 7026" [5]=> string(12) "123 4197 026" [6]=> string(13) "123-419 70 26" [7]=> string(14) "123 41 97 02 6" [8]=> string(14) "123-41 97 02 6" [9]=> string(11) "123-4197026" }

  public function getFormattedSwishNumberList($list) {
    $result = null;
    $elem = array();
    foreach($list as $item) {
      $elem[] = '<span class="swish-number-variant">' . $item . '</span><br>';
    }
    $result = join($elem);
    return $result;
  }


  public function EntryJSON($obj) {
    $result = null;
    $temp = array();

    $taxid = $this->getTaxID($obj['orgNumber']);
    if ($taxid != null) {
      $obj['orgNumber'] = $taxid;
    }

    $temp['@context'] = strval('https://schema.org');
    $temp['@type'] = strval('Organization');

    $temp['name'] = strval($obj['orgName']);
    $temp['taxid'] = strval($obj['orgNumber']);
    $temp['url'] = strval($obj['web']);

    $temp['dateCreated'] = strval("2022-03-24");
    $temp['breadcrumb'] = strval("Swish-Katalogen - Sök Swish-nummer - " . $obj['orgName']);

    $temp['keywords'] = array();

    foreach($obj['categories'] as $cat) {
      $temp['keywords'][] = strval($cat);
    }

    $result = $this->_jsonPrettify(json_encode($temp));
    return $result;
  }

  public function getTaxID($data) {
    $result = null;
    if(preg_match('/^(\d{6})\x2d(\d{4})$/six', strval($data))) {
      $result = preg_replace('/^(\d{6})\x2d(\d{4})$/six', "SE $1 $2 01", strval($data));
      $result = preg_replace('/\x20/six', "", strval($result));
    }
    return $result;
  }


  public function getSitemapCatURL($data) {
    return strval($this->domain_prefix) . strval($this->cat_prefix) . strval($data);
  }

  public function getSitemapEntryURL($data) {
    return strval($this->domain_prefix) . strval($this->url_prefix) . strval($data);
  }


  private function _jsonPrettify($json) {
    $json = preg_replace('/\x7b\x22/six', "{ \"", strval($json));
    $json = preg_replace('/\x22\x7d/six', "\" }", strval($json));

    $json = preg_replace('/\x5b\x22/six', "[ \"", strval($json));
    $json = preg_replace('/\x22\x5d/six', "\" ]", strval($json));

    $json = preg_replace('/\x5d\x7d/six', "] }", strval($json));


    $json = preg_replace('/\x22\x2c\x22/six', "\", \"", strval($json));

    $json = preg_replace('/\x22\x3a\x22/six', "\": \"", strval($json));


    return $json;
  }

  private function _calculateTagFontSize($rank_diff, $quantity) {

  }


  private function _regexify($data) {
    $data = preg_replace('/\x2d/six', "\\x2d", strval($data));
    $data = preg_replace('/\x2f/six', "\\x2f", strval($data));

    return $data;
  }

}