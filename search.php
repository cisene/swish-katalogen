<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors','On');

include_once "class.SqliteDB.php";
include_once "class.SwishFormat.php";
include_once "class.SwishKatalogen.php";

$sf = new SwishFormat();
$db = new SqliteDB();
$ui = new SwishKatalogen();

$recent = new SqliteDB();

$db->connectDB('./__database/swish-123-data.sqlite');

$recent->connectDB('./__database/recent.sqlite');


$cat_route = $ui->getCategoryRouting();
$cat_ranked = $db->getCategoriesAll();

$category_items = array();

$category_list = "";
$search_item_listing = "";

if($cat_route != null) {

  $search_items = $db->getItemsByTerm($cat_route);
  if(sizeof($search_items) > 0) {
    $search_item_listing = $ui->getItemListing($search_items);
  } else {
    $search_item_listing = "Inget matchade '" . $cat_route . "'";
  }

  $category_list = $ui->getCategoriesTagCloud($cat_ranked, "non-selected");
}

if(sizeof($category_items) < 1) {
  
  // header("Location: /swish-katalogen/404");
  // header("HTTP/1.1 404 NOT FOUND");
  // die("");
}




















?><!doctype html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Swish-Katalogen - Sökning efter '<?php echo($cat_route); ?>' - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer</title>

    <!-- meta name="theme-color" content="#f0f" -->
    <!-- meta name="theme-color" content="#f0f" -->
    <!--  meta name="msapplication-TileColor" content="#f0f" -->

    <meta name="msapplication-TileImage" content="/favicon/favicon_150x150.jpg?v=1">
    <link rel="apple-touch-icon" href="/favicon/favicon_192x192.jpg?v=1">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon_32x32.jpg?v=1">

    <link rel="search" type="application/opensearchdescription+xml" title="Swish-Katalogen" href="/opensearch.xml">

    <meta name="description" content="Swish-Katalogen - Sök och hitta Swish-nummer">

    <meta property="og:locale" content="sv_SE">
    <meta property="og:title" content="Swish-Katalogen">
    <meta property="og:description" content="Swish-Katalogen, kategori '<?php echo($cat_route); ?>'">
    <meta property="og:image" content="/favicon/favicon_512x512.jpg">
    <meta property="og:url" content="https://b19.se/swish-katalogen/">
    <meta property="og:site_name" content="Swish-Katalogen">

    <meta name="twitter:card" content="summary" />
    <meta name="twitter:creator" content="@cisene" />

    <meta name="apple-mobile-web-app-capable" content="no">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="swish-katalogen">

    <link rel="stylesheet" href="/swish-katalogen/css/screen.css?nocache=<?php echo(time()); ?>">

    <link rel="manifest" href="manifest/manifest.json?v=1">
  </head>
  <body>

    <section id="pageheader">
      <a href="/swish-katalogen/"><h1>Swish-Katalogen</h1></a>
    </section>

    <section id="pagebody">
      
      <div id="blurb">
        <h2>Sökträffar för '<?php echo($cat_route); ?>'</h2>
        <table>
          <?php echo($search_item_listing); ?>
        </table>
      </div>

      <div id="categories">
        <h2>Kategorier</h2>
        <ul id="categories-list"><?php echo($category_list); ?></ul>
      </div>

    </section>

    <section id="pagefooter">
      <?php include_once "include.pagefooter.php"; ?>
    </section>

  </body>
</html>
