<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors','On');

include_once "site.config.php";

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
  $dbparam["database"],
);

$siteparam = $config["site"];

// $cat_route = $ui->getCategoryRouting();
// $category_title = preg_replace('/\x25category\x25/six', $cat_route, strval(PAGE_CATEGORY_TITLE));
// $category_desc = preg_replace('/\x25category\x25/six', $cat_route, strval(PAGE_CATEGORY_DESC));


// $config["content"]["html"]["header"]["title"] = $category_title;
// $config["content"]["html"]["header"]["meta"]["description"]["content"] = $category_desc;

// $config["content"]["html"]["header"]["meta"]["og_title"]["content"] = $category_title;
// $config["content"]["html"]["header"]["meta"]["og_description"]["content"] = $category_desc;

// $config["content"]["html"]["header"]["meta"]["dc_title"]["content"] = $category_title;
// $config["content"]["html"]["header"]["meta"]["dc_description"]["content"] = $category_desc;

$webpage = array(
  "@context"      => "https://schema.org",
  "@type"         => "WebPage",
  "name"          => $config["site"]["title"],
  "url"           => $config["site"]["url"],
  "isBasedOn"     => "https://github.com/cisene/swish-123",
  "breadcrumb"    => "Swish-Katalogen - Sök Swish-nummer",
  "dateCreated"   => $config["site"]["dateCreated"],
  "datePublished" => $config["site"]["dateCreated"],
  "dateModified"  => $config["site"]["dateModified"],
);


?><!DOCTYPE html>
<html lang="sv" dir="ltr" xml:lang="sv" xmlns="http://www.w3.org/1999/xhtml">
  <head prefix="dc: http://purl.org/dc/elements/1.1/; og: http://ogp.me/ns#">
<?php echo($ui->renderHTMLHeadMisc($config)); ?>
<?php echo($ui->renderHTMLHeadMetas($config["content"]["html"]["header"]["meta"]) . "\n"); ?>
<?php echo($ui->renderHTMLHeadLinks($config["content"]["html"]["header"]["link"]) . "\n"); ?>
    <link rel="stylesheet" href="/swish-katalogen/css/screen.css?nocache=<?php echo(time()); ?>">
    <script src="js/jquery/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <script type="application/ld+json"><?php echo(json_encode($webpage)); ?></script>

<?php include_once "include.pageheader.php"; ?>

<?php // include_once "include.pagesearch.php"; ?>

    <section id="pagebody">
<?php include_once "include.pagebody.organizations.table.toplist.php"; ?>
    </section>

    <section id="pagefooter">
<?php include_once "include.pagefooter.php"; ?>
    </section>

  </body>
</html>
