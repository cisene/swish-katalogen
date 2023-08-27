<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors','On');

include_once "site.config.php";

include_once "class.SqliteDB.php";
include_once "class.SwishFormat.php";
include_once "class.SwishKatalogen.php";

$sf = new SwishFormat();
$db = new SqliteDB();
$ui = new SwishKatalogen();

$db->connectDB($config["db"]["sqlite"]["filepath"]);

$cat_route = $ui->getCategoryRouting();
// $cat_ranked = $db->getCategoriesAll();

if($cat_route != null) {
  if(preg_match("/^123(\d{7})$/six", strval($cat_route))) {

    $entry = $db->getEntryByID($cat_route);
    if(sizeof($entry) > 0) {

      $entry_json = $ui->EntryJSON($entry);

      $orgName = $entry['orgName'];
    }
  }
}

?><!doctype html>
<html lang="sv">
  <head>
    <?php echo($ui->renderHTMLHeadMetas($config["content"]["html"]["header"]["meta"]) . "\n"); ?>
    <?php echo($ui->renderHTMLHeadLinks($config["content"]["html"]["header"]["link"]) . "\n"); ?>
    <title><?php echo($orgName . ' - ' . $cat_route); ?> - Swish-Katalogen - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer</title>
    <link rel="stylesheet" href="/swish-katalogen/css/screen.css?nocache=<?php echo(time()); ?>">
    <script type="application/javascript" src="js/jquery/jquery-3.6.0.min.js"></script>
  </head>
  <body>

<?php include_once "include.pageheader.php"; ?>

<?php include_once "include.pagesearch.php"; ?>


    <section id="pagebody">

<?php include_once "include.pagebody.detail.organization.details.php"; ?>

<?php include_once "include.pagebody.detail.swish.number.swisha.php"; ?>

<?php include_once "include.pagebody.detail.swish.number.variants.php"; ?>

    </section>

    <section id="pagefooter">
      <?php include_once "include.pagefooter.php"; ?>
    </section>
    <?php include_once "include.analytics.php"; ?>
  </body>
</html>
