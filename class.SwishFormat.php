<?php

class SwishFormat {
  var $validation_rule        = '/^(\d{10})$/six';
  var $validation_rule_123    = '/^123(\d{7})$/six';


  var $output_formats = array(

    'digits-short-900' => array(
      're'  =>  '/^(123)(90[0-9])(\d{2})(\d{2})$/six',
      'pat' =>  '$2 $3 $4',
    ),

    /* 10         - 123999999 */
    'digits-10' => array(
      're'  =>  '/^(\d{10})$/six', 
      'pat' =>  '$1',
    ),

    /* 5+5        - 12399 99999 */
    'digits-5-sp-5' => array(
      're'  =>  '/^(\d{5})(\d{5})$/six',
      'pat' =>  '$1 $2',
    ),

    /* 4+3+3  -- 1239 999 999 */
    'digits-4-sp-3-sp-3' => array(
      're'  =>  '/^(\d{4})(\d{3})(\d{3})$/six',
      'pat' =>  '$1 $2 $3',
    ),

    /* 3+2+3+2    - 123 99 999 99 */
    'digits-3-sp-2-sp-3-sp-2' => array(
      're'  =>  '/^(\d{3})(\d{2})(\d{3})(\d{2})$/six',
      'pat' =>  '$1 $2 $3 $4',
    ),

    /* 3 + 3 + 2 + 2    - 123 999 99 99 */
    'digits-3-sp-3-sp-2-sp-2' => array(
      're'  =>  '/^(\d{3})(\d{3})(\d{2})(\d{2})$/six',
      'pat' =>  '$1 $2 $3 $4',
    ),

    /* 3 + 3 + 4    - 123 999 9999 */
    'digits-3-sp-3-sp-4' => array(
      're'  =>  '/^(\d{3})(\d{3})(\d{4})$/six',
      'pat' =>  '$1 $2 $3',
    ),

    /* 3 + 4 + 3      123 9999 999 */
    'digits-3-sp-4-sp-3' => array(
      're'  =>  '/^(\d{3})(\d{4})(\d{3})$/six',
      'pat' =>  '$1 $2 $3'
    ),

    /* 3+3+2+2    - 123 999 99 99 */
    'digits-3-mi-3-sp-2-sp-2' => array(
      're'  =>  '/^(\d{3})(\d{3})(\d{2})(\d{2})$/six',
      'pat' =>  '$1-$2 $3 $4',
    ),

    /* 3+2+2+2+1  - 123 99 99 99 9 */
    'digits-3-sp-2-sp-2-sp-2-sp-1' => array(
      're'  =>  '/^(\d{3})(\d{2})(\d{2})(\d{2})(\d{1})$/six',
      'pat' =>  '$1 $2 $3 $4 $5',
    ),

    /* 3+2+2+2+1  - 123 99 99 99 9 */
    'digits-3-mi-2-sp-2-sp-2-sp-1' => array(
      're'  =>  '/^(\d{3})(\d{2})(\d{2})(\d{2})(\d{1})$/six',
      'pat' =>  '$1-$2 $3 $4 $5',
    ),

    /* 3+7  -  123-9999999 */
    'digits-3-mi-7' => array(
      're'  => '/^(\d{3})(\d{7})$/six',
      'pat' => '$1-$2'
    ),

  );




  public function __construct() {

  }


  public function trimSwishNumber($swishNumber) {
    $result = array();
    $test = preg_replace('/[^0-9]/six', "", $swishNumber);
    if(preg_match($this->validation_rule, $test)) {
      $result[] = $test;
    }
    return $result;
  }


  public function getSwishAllFormats($swishNumber) {
    $result = array();
    if(preg_match($this->validation_rule, $swishNumber)) {
      foreach($this->output_formats as $key => $format) {
        if (preg_match($format['re'], $swishNumber)) {
          $formatted = preg_replace($format['re'], $format['pat'], $swishNumber);
          $result[] = $formatted;
        }
      }
    }
    return $result;
  }


  public function getSwishSpecificFormat($swishNumber, $pattern) {
    $result = array();

    if ($pattern == "common") {
      $pattern = "digits-3-sp-3-sp-2-sp-2";
    }

    if(preg_match($this->validation_rule, $swishNumber)) {
      if (isset($this->output_formats[$pattern])) {
        $format = $this->output_formats[$pattern];
        if (preg_match($format['re'], $swishNumber)) {
          $formatted = preg_replace($format['re'], $format['pat'], $swishNumber);
          $result[] = $formatted;
        }
      }
    }
    return $result;
  }


}