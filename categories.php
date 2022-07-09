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


?><!doctype html>
<html lang="sv">
  <head>
    <?php echo($ui->renderHTMLHeadMetas($config["content"]["html"]["header"]["meta"]) . "\n"); ?>
    <?php echo($ui->renderHTMLHeadLinks($config["content"]["html"]["header"]["link"]) . "\n"); ?>
    <title>Swish-Katalogen - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer</title>
    <link rel="stylesheet" href="/swish-katalogen/css/screen.css?nocache=<?php echo(time()); ?>">
    <script type="application/javascript" src="js/jquery/jquery-3.6.0.min.js"></script>
  </head>
  <body>

<?php include_once "include.pageheader.php"; ?>

<?php include_once "include.pagesearch.php"; ?>


    <section id="pagebody">

<?php include_once "include.pagebody.categories.table.php"; ?>

<?php include_once "include.pagebody.categories.categories.php"; ?>

    </section>

    <section id="pagefooter">
<?php include_once "include.pagefooter.php"; ?>
    </section>

    <script type="application/ld+json">{"@context":"https://schema.org","@type":"WebPage","name":"Kategorier Swish-nummer","dateCreated":"2022-03-24","breadcrumb":"Swish-Katalogen - Kategorier Swish-nummer"}</script>

<?php include_once "include.analytics.php"; ?>
  </body>
</html>
