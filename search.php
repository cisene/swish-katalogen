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

?><!DOCTYPE html>
<html lang="sv" dir="ltr" xml:lang="sv" xmlns="http://www.w3.org/1999/xhtml">
  <head prefix="dc: http://purl.org/dc/elements/1.1/; og: http://ogp.me/ns#">
    <?php echo($ui->renderHTMLHeadMetas($config["content"]["html"]["header"]["meta"]) . "\n"); ?>
    <?php echo($ui->renderHTMLHeadLinks($config["content"]["html"]["header"]["link"]) . "\n"); ?>
    <title>Swish-Katalogen - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer</title>
    <link rel="stylesheet" href="/swish-katalogen/css/screen.css?nocache=<?php echo(time()); ?>">
    <script type="application/javascript" src="js/jquery/jquery-3.6.0.min.js"></script>
  </head>
  <body>
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "WebPage",
        "name": "<?php echo($config["site"]["title"]); ?>",
        "url": "<?php echo($config["site"]["url"]); ?>",
        "isBasedOn": "https://github.com/cisene/swish-123",
        "breadcrumb": "Swish-Katalogen - Sök Swish-nummer",
        "dateCreated": "<?php echo($config["site"]["dateCreated"]); ?>",
        "datePublished": "<?php echo($config["site"]["dateCreated"]); ?>",
        "dateModified": "<?php echo($config["site"]["dateModified"]); ?>"
      }
    </script>

<?php include_once "include.pageheader.php"; ?>

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
