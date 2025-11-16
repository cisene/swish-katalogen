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

$cat_route = $ui->getCategoryRouting();

$orgName = "";
$entry_json = "";

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
        // die("<!DOCTYPE html>");
        $html = file_get_contents("./410.html");
        die($html);
      }
    } else {
      ob_clean();
      header("HTTP/1.1 400 Bad Request");
      // die("<!DOCTYPE html>");
      $html = file_get_contents("./400.html");
      die($html);
    }
  }
}

$entry_pritty = $ui->getSwishSpecificFormat($cat_route, "digits-3-sp-3-sp-2-sp-2");


$detail_title = preg_replace('/\x25orgName\x25/six', $orgName, strval(PAGE_DETAIL_TITLE));
$detail_desc = preg_replace('/\x25orgName\x25/six', $orgName, strval(PAGE_DETAIL_DESC));

$detail_title = preg_replace('/\x25entry\x25/six', $entry_pritty, strval($detail_title));
$detail_desc = preg_replace('/\x25entry\x25/six', $entry_pritty, strval($detail_desc));


$config["content"]["html"]["header"]["title"] = $detail_title;
$config["content"]["html"]["header"]["meta"]["description"]["content"] = $detail_desc;

$config["content"]["html"]["header"]["meta"]["og_title"]["content"] = $detail_title;
$config["content"]["html"]["header"]["meta"]["og_description"]["content"] = $detail_desc;

$config["content"]["html"]["header"]["meta"]["dc_title"]["content"] = $detail_title;
$config["content"]["html"]["header"]["meta"]["dc_description"]["content"] = $detail_desc;

$webpage = array(
  "@context"        => "https://schema.org",
  "@type"           => "WebPage",
  // "name"          => $config["site"]["title"],
  "name"            => $detail_title,
  // "url"           => $config["site"]["url"],
  "url"             => $config["content"]["html"]["header"]["link"]["rel_canonical"]["href"],
  "isBasedOn"       => "https://github.com/cisene/swish-123",
  "breadcrumb"      => "Swish-Katalogen - Sök Swish-nummer",
  "dateCreated"     => $config["site"]["dateCreated"],
  "datePublished"   => $config["site"]["dateCreated"],
  "dateModified"    => $config["site"]["dateModified"],
);


?><!DOCTYPE html>
<html translate="no" lang="sv" xml:lang="sv" dir="ltr" xmlns="http://www.w3.org/1999/xhtml">
  <head itemScope itemType="https://schema.org/WebSite" prefix="dc: http://purl.org/dc/elements/1.1/; og: http://ogp.me/ns#">
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

<?php include_once "include.pagebody.detail.organization.details.php"; ?>

<?php include_once "include.pagebody.detail.swish.number.variants.php"; ?>

    </section>

    <section id="pagefooter">
<?php include_once "include.pagefooter.php"; ?>
    </section>


  </body>
</html>
<?php $db->disconnectDB(); ?>