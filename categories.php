<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors','On');

include_once "class.SqliteDB.php";
include_once "class.SwishFormat.php";
include_once "class.SwishKatalogen.php";

$sf = new SwishFormat();
$db = new SqliteDB();
$ui = new SwishKatalogen();

$db->connectDB('./__database/swish-123-data.sqlite');

$cat_route = $ui->getCategoryRouting();
$cat_ranked = $db->getCategoriesAll();

$category_items = array();
$category_item_listing = "";

if($cat_route != null) {
  $category_list = $ui->getCategoriesTagCloud($cat_ranked, $cat_route);

  $category_items = $db->getEntriesByCategory($cat_route);
  $category_item_listing = $ui->getEntriesCategoryListing($category_items);

} else {
  $category_list = $ui->getCategoriesTagCloud($cat_ranked, "non-selected");
}

if(sizeof($category_items) < 1) {
  $category_list = $ui->getCategoriesTagCloud($cat_ranked, "non-selected");
}

// if(sizeof($category_items) < 1) {
//   header("HTTP/1.1 404 NOT FOUND");
//   die("");
// }




















?><!doctype html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php if($cat_route != null) { ?>Swish-Katalogen - Kategori '<?php echo($cat_route); ?>' - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer<?php } else { ?>Swish-Katalogen - Kategorier - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer<?php } ?></title>

    <!-- meta name="theme-color" content="#f0f" -->
    <!-- meta name="theme-color" content="#f0f" -->
    <!--  meta name="msapplication-TileColor" content="#f0f" -->

    <meta name="msapplication-TileImage" content="/favicon/favicon_150x150.jpg?v=1">
    <link rel="apple-touch-icon" href="/favicon/favicon_192x192.jpg?v=1">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon_32x32.jpg?v=1">

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
        <?php if($cat_route != null) { ?>
        <h2>Organisationer i kategorin '<?php echo($cat_route); ?>'</h2>
        <table>
          <?php echo($category_item_listing); ?>
        </table>
        <?php } ?>
      </div>

      <div id="categories">
        <h2>Kategorier</h2>
        <ul id="categories-list"><?php echo($category_list); ?></ul>
      </div>

    </section>

    <script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Kategorier Swish-nummer","dateCreated":"2022-03-24","breadcrumb":"Swish-Katalogen - Kategorier Swish-nummer"}</script>


    <section id="pagefooter">
      <?php include_once "include.pagefooter.php"; ?>
    </section>
    <?php include_once "include.analytics.php"; ?>
  </body>
</html>
