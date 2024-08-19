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
  $dbparam["database"]
);

$cat_all = $db->getSitemapCategoriesAll();
$entries_all = $db->getSitemapEntriesAll();
$org_top = $db->getSitemapOrganisationsTop();

/* Todays date */
$today = date("c");

$xml_template_string = "<?xml version='1.0' encoding='UTF-8'?><urlset xmlns='http://www.sitemaps.org/schemas/sitemap/0.9'></urlset>";
$xml = simplexml_load_string($xml_template_string);

/* Categories */
foreach($cat_all as $cat) {
  $sitemap_cat_url = $ui->getSitemapCatURL($cat['category']);

  $url = $xml->addChild('url');
  $loc = $url->addChild('loc', $sitemap_cat_url);
  $lastmod = $url->addChild('lastmod', $today);
}

/* Organisations */
foreach($org_top as $org) {
  $sitemap_org_url = getSitemapOrgURL($org["orgNumber"]);

  /* Append element */
  $url = $xml->addChild('url');
  $loc = $url->addChild('loc', $sitemap_org_url);
  $lastmod = $url->addChild('lastmod', $today);
}

/* Entries */
foreach($entries_all as $entry) {
  $sitemap_entry_url = $ui->getSitemapEntryURL($entry['entry']);

  $url = $xml->addChild('url');
  $loc = $url->addChild('loc', $sitemap_entry_url);
  $lastmod = $url->addChild('lastmod', $today);
}

$response = $xml->asXML();

header("Content-Type: application/xml");
die($response);
