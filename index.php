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

$config["content"]["html"]["header"]["title"] = PAGE_START_TITLE;
$config["content"]["html"]["header"]["meta"]["description"]["content"] = PAGE_START_DESC;

$config["content"]["html"]["header"]["meta"]["og_title"]["content"] = PAGE_START_TITLE;
$config["content"]["html"]["header"]["meta"]["og_description"]["content"] = PAGE_START_DESC;

$config["content"]["html"]["header"]["meta"]["dc_title"]["content"] = PAGE_START_TITLE;
$config["content"]["html"]["header"]["meta"]["dc_description"]["content"] = PAGE_START_DESC;

$webpage = array(
  "@context"        => "https://schema.org",
  "@type"           => "WebPage",
  "name"            => $config["site"]["title"],
  "url"             => $config["site"]["url"],
  "isBasedOn"       => "https://github.com/cisene/swish-123",
  "breadcrumb"      => "Swish-Katalogen - Sök Swish-nummer",
  "dateCreated"     => $config["site"]["dateCreated"],
  "datePublished"   => $config["site"]["dateCreated"],
  "dateModified"    => $config["site"]["dateModified"],
);

?><!DOCTYPE html>
<html translate="no" lang="sv" xml:lang="sv" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
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
      
<?php include_once "include.pagebody.index.intro.php"; ?>

<?php // include_once "include.pagebody.index.statistics.php"; ?>

<?php include_once "include.pagebody.index.seo-fodder.php"; ?>

<?php include_once "include.pagebody.index.categories.php"; ?>

    </section>

    <footer id="pagefooter" role="contentinfo">
<?php include_once "include.pagefooter.php"; ?>
    </footer>


  </body>
</html>
<?php $db->disconnectDB(); ?>
