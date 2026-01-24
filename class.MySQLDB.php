<?php

class MySQLDB {

  var $mysql_module_loaded = false;

  var $db_connection = null;

  var $db_hostname = null;
  var $db_username = null;
  var $db_database = null;
  /* there is no $db_password for a reason */

  public function __construct() {
    foreach(get_loaded_extensions() as $key => $value) {
      if (preg_match('/^mysqli$/six', $value)) {
        $this->mysql_module_loaded = true;
        break;
      }
    }
  }

  public function connectDB($hostname, $port, $username, $password, $database) {
    if ($this->mysql_module_loaded == true) {
      $this->db_connection = mysqli_connect(
        $hostname,
        $username,
        $password,
        $database
      );

      /* Save during session */
      $this->db_hostname = $hostname;
      $this->db_username = $username;
      $this->db_database = $database;

      /* Set up connection to handle UTF8MB4 (Multibyte UTF-8) */
      $this->db_connection->query("SET NAMES utf8mb4");
      $this->db_connection->query("SET CHARACTER SET utf8mb4");
      $this->db_connection->query("SET character_set_connection=utf8mb4");
      $this->db_connection->query("SET autocommit=0;");
    }
  }

  public function disconnectDB() {
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        mysqli_close($this->db_connection);
        $this->db_connection = null;

        $this->db_hostname = null;
        $this->db_username = null;
        $this->db_database = null;
      }
    }
  }

  public function getHistoryLatest() {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        $result = array();
        $query = "SELECT DISTINCT s.entry, CASE WHEN s.entry LIKE '1239%' THEN '*' ELSE '' END AS hightlight, s.orgName, s.comment, h.path FROM b19_se.history AS h JOIN b19_se.swish as s ON s.entry = h.entry WHERE s.entry IS NOT NULL AND h.dt > date_sub(NOW(), INTERVAL (24*7) HOUR) GROUP BY h.entry ORDER BY h.dt DESC LIMIT 25;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
          $result[] = array(
            'entry'       => strval($row['entry']),
            'hightlight'  => strval($row['hightlight']),
            "orgName"     => strval($row['orgName']),
            "comment"     => strval($row['comment']),
            "path"        => strval($row['path']),
          );
        }
      }
    }
    return $result;
  }

  public function getHistoryToplist() {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        $query = "SELECT s.entry, CASE WHEN s.entry LIKE '1239%' THEN '*' ELSE '' END AS hightlight, s.orgName, s.comment, h.path, COUNT(h.entry) AS cnt FROM b19_se.history AS h JOIN b19_se.swish as s ON s.entry = h.entry WHERE s.entry IS NOT NULL AND h.dt > date_sub(NOW(), INTERVAL (24*7) HOUR) GROUP BY h.entry HAVING cnt > 1 ORDER BY cnt DESC, s.entry ASC LIMIT 25;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
          $result[] = array(
            'entry'       => strval($row['entry']),
            'hightlight'  => strval($row['hightlight']),
            "orgName"     => strval($row['orgName']),
            "comment"     => strval($row['comment']),
            "path"        => strval($row['path']),
          );
        }
      }
    }
    return $result;
  }

  public function getSingleRandomFromAll() {
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        // Pick ONE random entry where Swish 123 number is under Insamlingskontroll (123900 - 123909)
        $query = "SELECT * FROM " . $this->db_database . ".swish WHERE entry BETWEEN 1239000000 AND 1239099999 ORDER BY RANDOM() ASC LIMIT 1;";
        // echo($query . "\n");

        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
            var_dump($row);
        }
      }
    }
  }

  public function getEntriesByOrgNumber($orgNumber) {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        $query = "SELECT s.entry, s.orgName, s.comment FROM " . $this->db_database . ".swish s WHERE s.orgNumber = '" . strval($orgNumber) . "' ORDER BY s.entry ASC;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
          $result[] = array(
            'entry'       => strval($row['entry']),
            'orgName'     => strval($row['orgName']),
            'comment'     => strval($row['comment']),
          );
        }
      }
    }
    return $result;
  }

  public function getCountByOrgNumber($orgNumber) {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        $query = "SELECT COUNT(*) AS cnt FROM " . $this->db_database . ".swish s WHERE s.orgNumber = '" . strval($orgNumber) . "';";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
          $result = array(
            'count'       => strval($row['cnt'])
          );
        }
      }
    }
    return $result;
  }

  public function getToplistOrgNumber($limit = 100) {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        // $query = "SELECT s.orgNumber, COUNT(*) as cnt FROM b19_se.swish s WHERE s.orgNumber NOT LIKE '%-XXXX' GROUP BY s.orgNumber HAVING cnt >= 2 ORDER BY cnt DESC, s.orgNumber ASC LIMIT " . $limit . ";";
        $query = "SELECT s.orgName, s.orgNumber, COUNT(*) as cnt FROM " . $this->db_database . ".swish s WHERE s.orgNumber NOT LIKE '%-XXXX' GROUP BY s.orgNumber HAVING cnt >= 2 ORDER BY cnt DESC, s.orgNumber ASC LIMIT " . $limit . ";";
        // echo("\n<!-- " . $query . "-->\n");
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
          $result[] = array(
            'orgName'     => strval($row['orgName']),
            'orgNumber'   => strval($row['orgNumber']),
            'count'       => strval($row['cnt'])
          );
        }
      }
    }
    return $result;
  }

  public function getEntryByID($entry_id) {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {

        $entry = null;

        $query = "SELECT entry, orgName, orgNumber, comment, web FROM " . $this->db_database . ".swish WHERE entry = " . $entry_id . ";";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
          $entry = array(
            'entry'       => strval($row['entry']),
            'orgName'     => strval($row['orgName']),
            'orgNumber'   => strval($row['orgNumber']),
            'comment'     => strval($row['comment']),
            'web'         => strval($row['web']),
            'categories'  => array()
          );
        }

        if($entry) {
          $query = "SELECT category FROM " . $this->db_database . ".categories WHERE entry = " . $entry_id . " ORDER BY category ASC;";
          $results = $this->db_connection->query($query);
          while ($row = $results->fetch_assoc()) {
            $entry['categories'][] = $row['category'];
          }
          $result = $entry;
        }
      }
    }
    return $result;
  }

  public function getSingleRandomFromCategories($category) {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        $category_clean = $this->_sqlsafe($category);
        $query = "SELECT * FROM " . $this->db_database . ".swish s LEFT JOIN " . $this->db_database . ".categories c ON c.entry = s.entry WHERE c.category = '" . $category_clean . "' ORDER BY RANDOM() ASC LIMIT 1;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
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
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        $query = "SELECT category, COUNT(*) AS cnt FROM " . $this->db_database . ".categories GROUP BY category HAVING cnt >= 10 ORDER BY cnt DESC, category ASC LIMIT 50;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
            $result[] = array('category' => $row['category'], 'quantity' => $row['cnt']);
        }
      }
    }
    return $result;
  }

  public function getCategoriesAll() {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        $query = "SELECT category, COUNT(*) AS cnt FROM " . $this->db_database . ".categories GROUP BY category ORDER BY cnt DESC, category ASC;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
            $result[] = array('category' => $row['category'], 'quantity' => $row['cnt']);
        }
      }
    }
    return $result;
  }

  public function getCategoriesLimited($limit) {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        $query = "SELECT category, COUNT(*) AS cnt FROM " . $this->db_database . ".categories GROUP BY category ORDER BY cnt DESC, category ASC LIMIT " . strval($limit) . ";";
        // echo($query . "<br>");
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
          $result[] = array('category' => $row['category'], 'quantity' => $row['cnt']);
        }
      }
    }
    return $result;
  }

  public function getCategoriesAscending() {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        // $query = "SELECT category, COUNT(*) AS cnt FROM categories GROUP BY category ORDER BY category ASC;";
        $query = "SELECT category, COUNT(*) AS cnt FROM " . $this->db_database . ".categories GROUP BY category ORDER BY category ASC LIMIT 5000;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
            $result[] = array('category' => $row['category'], 'quantity' => $row['cnt']);
        }
      }
    }
    return $result;
  }

  public function getCategoriesRelated($category) {
    $result = array();
    if($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        // $query = "SELECT DISTINCT category FROM categories WHERE entry IN (SELECT DISTINCT entry FROM categories WHERE category = '" . mysqli_real_escape_string($this->db_connection, $category) . "') ORDER BY category ASC;";
        $query = "SELECT DISTINCT category FROM " . $this->db_database . ".categories WHERE entry IN (SELECT DISTINCT entry FROM categories WHERE category = '" . $this->_sqlsafe($category) . "') ORDER BY category ASC;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
            $result[] = array('category' => $row['category']);
        }
      }
    }
    return $result;
  }

  public function getCategoriesForSections() {
    $result = array();
    if($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        $query = "SELECT UPPER(LEFT(category,1)) AS letter, category, COUNT(*) AS cnt FROM " . $this->db_database . ".categories WHERE category != '' GROUP BY category ORDER BY category ASC;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
            $result[] = array('category' => $row['category']);
        }
      }
    }
    return $result;
  }

  public function getSitemapOrganisationsTop() {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        // $query = "SELECT s.orgNumber, COUNT(*) as cnt FROM b19_se.swish s WHERE s.orgNumber NOT LIKE '%-XXXX' GROUP BY s.orgNumber HAVING cnt >= 2 ORDER BY cnt DESC, s.orgNumber ASC LIMIT 100;";
        $query = "SELECT s.orgName, s.orgNumber, COUNT(*) as cnt FROM " . $this->db_database . ".swish s WHERE s.orgNumber NOT LIKE '%-XXXX' GROUP BY s.orgNumber HAVING cnt >= 2 ORDER BY cnt DESC, s.orgNumber ASC LIMIT 100;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
          // $result[] = array('orgNumber' => $row['orgNumber']);
          $result[] = array('orgName' => $row['orgName'], 'orgNumber' => $row['orgNumber'], 'count' => $row['cnt']);
        }
      }
    }
    return $result;
  }



  public function getSitemapEntriesAll() {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        $query = "SELECT DISTINCT entry FROM " . $this->db_database . ".swish ORDER BY entry ASC;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
            $result[] = array('entry' => $row['entry']);
        }
      }
    }
    return $result;
  }

  public function getSitemapCategoriesAll() {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        $query = "SELECT DISTINCT category FROM " . $this->db_database . ".categories ORDER BY category ASC;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
            $result[] = array('category' => $row['category']);
        }
      }
    }
    return $result;
  }

  // $query = "SELECT * FROM swish s LEFT JOIN categories c ON c.entry = s.entry WHERE c.category = '" . $category_clean . "' ORDER BY RANDOM() ASC LIMIT 1;";


  public function getItemsByTerm($term) {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        if (strlen($term) >= 2) {
          $query = "SELECT entry, orgName, orgNumber, web, comment FROM " . $this->db_database . ".swish ";
          $query .= "WHERE ";
          $query .= "(";
          $query .= "entry LIKE '%:term%' ";
          $query .= "OR ";
          $query .= "orgName LIKE '%:term%' ";
          $query .= "OR ";
          $query .= "orgNumber LIKE '%:term%' ";
          $query .= "OR ";
          $query .= "web LIKE '%:term%' ";
          $query .= "OR ";
          $query .= "comment LIKE '%:term%' ";
          $query .= ") ";
          $query .= "ORDER BY entry ASC;";

          $query = preg_replace('/\x3aterm/six', strval($this->_sqlsafe($term)), strval($query));

          $results = $this->db_connection->query($query);
          while ($row = $results->fetch_assoc()) {
            
            $entry = strval($row['entry']);
            $comment = strval($row['comment']);

            if ($comment == "None") {
              $comment = "";
            }

            $categories = array();
            
            $query = "SELECT category FROM " . $this->db_database . ".categories WHERE entry = '" . $entry . "' ORDER BY category ASC;";
            $category_results = $this->db_connection->query($query);
            while ($row = $results->fetch_assoc()) {
              $categories[] = strval($category_row['category']);
            }

            $result[] = array(
              'entry'       => strval($row['entry']),
              'orgName'     => strval($row['orgName']),
              'orgNumber'   => strval($row['orgNumber']),
              'comment'     => strval($comment),
              'web'         => strval($row['web']),
              'categories'  => $categories,
            );
          }
        }
      }
    }

    return $result;
  }


  public function getEntriesByCategory($category) {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {
        $query = "SELECT entry, orgName, orgNumber, web, comment FROM " . $this->db_database . ".swish WHERE entry IN (SELECT entry FROM categories WHERE category = '" . $category . "') ORDER BY entry ASC;";
        $results = $this->db_connection->query($query);
        while ($row = $results->fetch_assoc()) {
            $result[] = array(
              'entry'       => strval($row['entry']),
              'orgName'     => strval($row['orgName']),
              'orgNumber'   => strval($row['orgNumber']),
              'comment'     => strval($row['comment']),
              'web'         => strval($row['web']),
            );
        }
      }
    }
    return $result;
  }

  public function LogVisitHistory($entry) {
    $result = array();
    if ($this->mysql_module_loaded == true) {
      if ($this->db_connection != null) {

        $client_ip = "";
        if(isset($_SERVER['REMOTE_ADDR'])) {
          $client_ip = $_SERVER['REMOTE_ADDR'];
        }

        $path = "";
        if(isset($_SERVER['REQUEST_URI'])) {
          $path = $_SERVER['REQUEST_URI'];
        }

        $query = "INSERT INTO ";
        $query .= $this->db_database . ".history ";
        $query .= "(";
        $query .= "dt,";
        $query .= "ip,";
        $query .= "entry,";
        $query .= "path";
        $query .= ") ";
        $query .= "VALUES(";
        $query .= "NOW(),";
        $query .= "'" . strval($client_ip) . "',";
        $query .= "'" . strval($entry) . "',";
        $query .= "'" . strval($path) . "'";
        $query .= ");";
        // echo("\n<!-- " . $query . " -->\n");
        $this->db_connection->query($query);
        $this->db_connection->commit();
      }
    }
    return $result;
  }




  private function _sqlsafe($data) {
    if(!is_null($data)) {
      $data = strtolower($data);
      $data = preg_replace("/[^a-z0-9åäö]/six", "", $data);
    } else {
      $data = "";
    }
    return $data;
  }

}