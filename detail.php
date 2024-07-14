<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors','On');

include_once "site.config.php";

// include_once "class.SqliteDB.php";
include_once "class.MySQLDB.php";
include_once "class.SwishFormat.php";
include_once "class.SwishKatalogen.php";

$sf = new SwishFormat();
$db = new MySQLDB();
$ui = new SwishKatalogen();

$dbparam = $config["db"]["mysql"];

$db->connectDB(
  $dbparam["hostname"],
  $dbparam["port"],
  $dbparam["username"],
  $dbparam["password"],
  $dbparam["database"]
);

$siteparam = $config["site"];

$cat_route = $ui->getCategoryRouting();

// $formatted_title_entry = $sf->getSwishSpecificFormat(strval($cat_route), "common");

if(isset($cat_route)) {
  if($cat_route != null) {
    if(preg_match("/^123(\d{7})$/six", strval($cat_route))) {

      $entry = $db->getEntryByID($cat_route);
      if(sizeof($entry) > 0) {

        $entry_json = $ui->EntryJSON($entry);

        $orgName = $entry['orgName'];
      } else {
        ob_clean();
        header("HTTP/1.1 410 Gone");
        die("<!DOCTYPE html>");
      }
    } else {
      ob_clean();
      header("HTTP/1.1 400 Bad Request");
      die("<!DOCTYPE html>");
    }
  }
}
?><!doctype html>
<html lang="sv">
  <head>
    <?php echo($ui->renderHTMLHeadMetas($config["content"]["html"]["header"]["meta"]) . "\n"); ?>
    <?php echo($ui->renderHTMLHeadLinks($config["content"]["html"]["header"]["link"]) . "\n"); ?>
    <title><?php echo($cat_route . ' - ' . $orgName); ?> - Swish-Katalogen - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer</title>
    <link rel="stylesheet" href="/swish-katalogen/css/screen.css?nocache=<?php echo(time()); ?>">
    <script src="js/jquery/jquery-3.6.0.min.js"></script>
  </head>
  <body>

<?php include_once "include.pageheader.php"; ?>

<?php // include_once "include.pagesearch.php"; ?>


    <section id="pagebody">

<?php include_once "include.pagebody.detail.organization.details.php"; ?>

<?php include_once "include.pagebody.detail.swish.number.swisha.php"; ?>

<?php include_once "include.pagebody.detail.swish.number.variants.php"; ?>

    </section>

    <section id="pagefooter">
      <?php include_once "include.pagefooter.php"; ?>
    </section>


  </body>
</html>
