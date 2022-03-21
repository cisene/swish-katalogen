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

// header("Content-Type: text/plain");

$cat_route = $ui->getCategoryRouting();
$cat_ranked = $db->getCategoriesAll();

if($cat_route != null) {
  if(preg_match("/^123(\d{7})$/six", strval($cat_route))) {

    $entry = $db->getEntryByID($cat_route);
    $entry_json = $ui->EntryJSON($entry);

    $orgName = $entry['orgName'];

    $entry_categories = $ui->getEntryCategories($entry['categories']);
    $other_categories = $ui->getOtherCategories($cat_ranked, $entry['categories']);


    $number_variants = $sf->getSwishAllFormats($cat_route);
    $variants = $ui->getFormattedSwishNumberList($number_variants);

  } else {
    header("HTTP/1.1 404 NOT FOUND");
    die("");
  }


}

?><!doctype html>
<html lang="sv">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Swish-Katalogen - <?php echo($cat_route . ' - ' . $orgName); ?></title>

    <meta name="theme-color" content="#f0f">
    <meta name="theme-color" content="#f0f">
    <meta name="msapplication-TileColor" content="#f0f">

    <meta name="msapplication-TileImage" content="/favicon/favicon_150x150.jpg?v=1">
    <link rel="apple-touch-icon" href="/favicon/favicon_192x192.jpg?v=1">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon_32x32.jpg?v=1">

    <meta name="description" content="Swish-Katalogen - Sök och hitta Swish-nummer">

    <meta property="og:title" content="Swish-Katalogen">
    <meta property="og:description" content="Swish-Katalog">
    <meta property="og:image" content="/favicon/favicon_512x512.jpg">
    <meta property="og:url" content="https://b19.local/swish-katalogen/">
    <meta property="og:site_name" content="Swish-Katalogen">

    <meta name="apple-mobile-web-app-capable" content="no">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="swish-katalogen">

    <link href="css/screen.css?nocache=<?php echo(time()); ?>" rel="prefetch">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- script src="js/app.js?nocache=<?php echo(time()); ?>"></script -->
    <link rel="manifest" href="manifest/manifest.json?v=1">
  </head>
  <body>

    <script type="application/ld+json"><?php echo($entry_json); ?></script>

    <section id="pageheader">
      <a href="/swish-katalogen/"><h1>Swish-Katalogen</h1></a>
    </section>

    <section id="pagebody">
      
      <aside class="blurb">
        <div itemscope itemtype="https://schema.org/Organization">
          <span class="kv-pair">
            <span class="kv-pair-key">Organisation:</span>
            <span class="kv-pair-value" itemprop="name"><?php echo($entry['orgName']); ?></span>
          </span>
          <br>
          <span class="kv-pair">
            <span class="kv-pair-key">Organisationsnummer:</span>
            <span class="kv-pair-value" itemprop="taxID"><?php echo($entry['orgNumber']); ?></span>
          </span>
          <br>
          <span class="kv-pair">
            <span class="kv-pair-key">Hemsida:</span>
            <span class="kv-pair-value"><a itemprop="url" href="<?php echo($entry['web']); ?>"><?php echo($entry['web']); ?></a></span>
          </span>
          <br>
          <span class="kv-pair">
            <span class="kv-pair-key">Kategorier:</span>
            <span class="kv-pair-value"><ul><?php echo($entry_categories); ?></ul></span>
          </span>

        </div>

        <div class="swish-number-variants">
          <h2>Swish-nummer: <?php echo($cat_route); ?></h2>
          <div><?php echo($variants); ?></div>
        </div>

        <div class="other-categories">
          <h3>Övriga kategorier:</h3>
          <ul><?php echo($other_categories); ?></ul>
        </div>

      </aside>

    </section>

    <section id="pagefooter">
      <?php include_once "include.pagefooter.php"; ?>
    </section>

  </body>
</html>
