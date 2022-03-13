<?php

class SqliteDB {

  var $sqlite_module_loaded = false;

  var $db_connection = null;

  public function __construct() {
    foreach(get_loaded_extensions() as $key => $value) {
      if (preg_match('/^sqlite3$/six', $value)) {
        $this->sqlite_module_loaded = true;
        break;
      }
    }
  }


  public function connectDB($filepath) {
    if ($this->sqlite_module_loaded == true) {
      if (file_exists($filepath)) {
        // echo("file exists!\n");
        $this->db_connection = new SQLite3($filepath, SQLITE3_OPEN_READONLY);
      }
    }
  }

  public function disconnectDB() {
    if ($this->sqlite_module_loaded == true) {
      if ($this->db_connection != null) {
        $this->db_connection = null;
      }
    }
  }


  public function getSingleRandomFromAll() {
    if ($this->sqlite_module_loaded == true) {
      if ($this->db_connection != null) {
        // Pick ONE random entry where Swish 123 number is under Insamlingskontroll (123900 - 123909)
        $query = "SELECT * FROM swish WHERE entry BETWEEN 1239000000 AND 1239099999 ORDER BY RANDOM() ASC LIMIT 1;";
        echo($query . "\n");

        $results = $this->db_connection->query($query);
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            var_dump($row);
        }


      }
    }


  }

  public function getSingleRandomFromCategories($category) {
    $result = array();
    if ($this->sqlite_module_loaded == true) {
      if ($this->db_connection != null) {
        $category_clean = $this->_sqlsafe($category);
        $query = "SELECT * FROM swish s LEFT JOIN categories c ON c.entry = s.entry WHERE c.category = '" . $category_clean . "' ORDER BY RANDOM() ASC LIMIT 1;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
          $result[] = array(
            'entry'     => strval($row['entry']),
            'orgName'   => strval($row['orgName']),
            'orgNumber' => strval($row['orgNumber']),
            'web'       => strval($row['web']),
            'category'  => strval($row['category']),
          );
        }
      }
    }
    return $result;
  }

  public function getCategoriesRanked() {
    $result = array();
    if ($this->sqlite_module_loaded == true) {
      if ($this->db_connection != null) {
        $query = "SELECT category, COUNT(*) AS cnt FROM categories GROUP BY category HAVING cnt >= 25 ORDER BY cnt DESC, category ASC;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetchArray(SQLITE3_ASSOC)) {
            $result[] = array('category' => $row['category'], 'quantity' => $row['cnt']);
        }
      }
    }
    return $result;
  }



  private function _sqlsafe($data) {
    $data = strtolower($data);
    $data = preg_replace("/[^a-z0-9åäö]/six", "", $data);
    return $data;
  }

}