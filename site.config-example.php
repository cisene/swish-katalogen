<?php

date_default_timezone_set('Europe/Stockholm');

$protocol = $_SERVER['REQUEST_SCHEME'];
$http_host = $_SERVER['HTTP_HOST'];
$http_uri = $_SERVER['REQUEST_URI'];

// Hardcode to HTTPS as we're behind a proxy
$protocol = "https";

// Other hardcoded values
$date_created = date('r', strtotime("2022-03-24T10:32:16Z"));
$date_modified = date(DATE_RFC2822);

define("URL_ROOT",                  $protocol . "://" . $http_host . "/swish-katalogen/");

define("URL_CATEGORIES",            URL_ROOT . "k/");

define("URL_SITEMAP",               URL_ROOT . "sitemap.xml");

define("URL_OPENSEARCH",            URL_ROOT . "opensearch.xml");

define("URL_MANIFEST",              URL_ROOT . "manifest.json");

define("URL_GITHUB_SWISH123",       "https://github.com/cisene/swish-123");
define("URL_GITHUB_SWISHKAT",       "https://github.com/cisene/swish-katalogen");

/* Define URLs of Favicons in different sizes */
define("URL_ICON_32x32",    URL_ROOT . "favicon_32x32.jpg?v=1");
define("URL_ICON_150x150",  URL_ROOT . "favicon_150x150.jpg?v=1");
define("URL_ICON_180x180",  URL_ROOT . "favicon_180x180.jpg?v=1");
define("URL_ICON_192x192",  URL_ROOT . "favicon_192x192.jpg?v=1");
define("URL_ICON_270x270",  URL_ROOT . "favicon_270x270.jpg?v=1");
define("URL_ICON_300x300",  URL_ROOT . "favicon_300x300.jpg?v=1");
define("URL_ICON_512x450",  URL_ROOT . "favicon_512x450.jpg?v=1");
define("URL_ICON_512x512",  URL_ROOT . "favicon_512x512.jpg?v=1");

/* Define strings */
define("SITE_NAME",     "Swish-Katalogen");

define("PAGE_START_TITLE",  SITE_NAME . " - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer");
define("PAGE_START_DESC",   SITE_NAME . " - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer");

define("PAGE_CATEGORIES_ALL_TITLE", "");
define("PAGE_CATEGORIES_ALL_DESC", "");

define("PAGE_CATEGORY_TITLE", SITE_NAME . " - Kategori '%category%'");
define("PAGE_CATEGORY_DESC", SITE_NAME . " - Kategori '%category%' med' ");

$config = array(

  "site" => array(
    "name"          => "Swish-Katalogen",
    // "url"           => $protocol . "://" . $http_host . "/swish-katalogen/",
    "url"           => URL_ROOT,
    "title"         => "Swish-Katalogen",
    "description"   => "Swish-Katalogen - Sök och hitta Swish-nummer",
    "dateCreated"   => $date_created,
    "dateModified"  => $date_modified,
  ),

  "db" => array(
    "mysql" => array(
      "hostname" => "<fill in hostname>",
      "port" => "3306",
      "username" => "<username>",
      "password" => "<password>",
      "database" => "<databasename>",
    )
  ),

  "content" => array(
    "html" => array(
      "header" => array(

        "title"         =>  "Swish-Katalogen - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer",

        "link" => array(

          array(
            "rel"       =>  "canonical",
            "href"      =>  $protocol ."://" . $http_host . $http_uri,
          ),

          // <link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.xml">
          array(
            "rel"       =>  "sitemap",
            "type"      =>  "application/xml",
            "title"     =>  "Sitemap",
            // "href"      =>  $protocol ."://" . $http_host . "/swish-katalogen/sitemap.xml",
            "href"      =>  URL_SITEMAP,
          ),

          array(
            "rel"       =>  "alternate",
            "hreflang"  =>  "sv",
            "href"      =>  URL_ROOT,
          ),

          array(
            "rel"       =>  "icon",
            "type"      =>  "image/jpg",
            "sizes"     =>  "32x32",
            // "href"      =>  $protocol ."://" . $http_host . "/favicon/favicon_32x32.jpg?v=1",
            "href"      =>  URL_ICON_32x32,
          ),

          array(
            "rel"       =>  "index",
            "title"     =>  "Index",
            // "href"      =>  $protocol ."://" . $http_host . "/swish-katalogen/",
            "href"      =>  URL_ROOT,
          ),

          array(
            "rel"       =>  "categories",
            "title"     =>  "Kategorier",
            // "href"      =>  $protocol ."://" . $http_host . "/swish-katalogen/k/",
            "href"      =>  URL_CATEGORIES,
          ),

          array(
            "rel"       =>  "manifest",
            "href"      =>  $protocol ."://" . $http_host . "/swish-katalogen/manifest/manifest.json?v=1",
          ),

          // Here we declare a LINK element to enable autodiscovery of OpenSearch capabilities within Swish-Katalogen :)
          array(
            "rel"       =>  "search",
            "type"      =>  "application/opensearchdescription+xml",
            "title"     =>  "Swish-Katalogen",
            // "href"      =>  $protocol ."://" . $http_host . "/swish-katalogen/opensearch.xml",
            "href"      =>  URL_OPENSEARCH,
          ),

        ),

        "meta" => array(

          array(
            "charset"       =>  "utf-8",
          ),

          array(
            "name"          =>  "robots",
            "content"       =>  "index,follow",
          ),

          // <meta name="country" content="SE">
          array(
            "name"          => "country",
            "content"       => "SE",
          ),

          // array(
          //   "name"          =>  "sitemap",
          //   "content"       =>  $protocol . "://" . $http_host . "/swish-katalogen/sitemap.xml",
          // ),

          "description" => array(
            "name"          =>  "description",
            "content"       =>  "Swish-Katalogen - Sök Swish-nummer",
          ),

          array(
            "name"          =>  "keywords",
            "content"       =>  "swish-katalogen, swishnummer, swish-nummer, söka swish företag",
          ),

          // <meta name="google" content="notranslate">
          array(
            "name"          => "google",
            "content"       => "notranslate",
          ),

          array(
            "name"          =>  "content",
            "content"       =>  "general",
          ),

          array(
            "name"            =>  "Last-Modified",
            "content"         =>  $date_modified,
          ),

          array(
            "name"            =>  "Creation-Date",
            "content"         =>  $date_created,
          ),

          array(
            "name"            =>  "category",
            "content"         =>  "site;sv"
          ),

          array(
            "name"            =>  "category",
            "content"         =>  "contexttype;page"
          ),

          array(
            "name"            =>  "application-name",
            "content"         =>  "Swish-Katalogen",
          ),

          array(
            "name"            =>  "viewport",
            "content"         =>  "width=device-width, initial-scale=1.0, shrink-to-fit=no",
          ),

          "og_title" => array(
            "property"        =>  "og:title",
            "content"         =>  "Swish-Katalogen",
          ),

          "og_description" => array(
            "property"        =>  "og:description",
            "content"         =>  "Swish-Katalogen, en enkel söktjänst för Swish-nummer. Sök och hitta Swish-nummer.",
          ),

          "og_site_name" => array(
            "property"        =>  "og:site_name",
            "content"         =>  "Swish-Katalogen",
          ),

          array(
            "property"        =>  "og:image",
            "content"         =>  $protocol ."://" . $http_host . "/favicon/favicon_512x512.jpg",
          ),

          array(
            "property"        =>  "og:locale",
            "content"         =>  "sv_SE",
          ),

          array(
            "property"        =>  "og:url",
            "content"         =>  URL_ROOT,
          ),

          "dc_title" => array(
            "property"  =>  "dc:Title",
            "content"   =>  "Swish-Katalogen - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer",
          ),

          "dc_description" => array(
            "property"  =>  "dc.Description",
            "content"   =>  "Swish-Katalogen - Sök Swish-nummer",
          ),

          array(
            "property"  =>  "dc:Identifier",
            "content"   =>  URL_ROOT,
          ),

          array(
            "property"  =>  "dc:Creator",
            "content"   =>  "Creator",
          ),

          array(
            "property"  =>  "dc:Creator.Address",
            "content"   =>  "christopher.isene@gmail.com",
          ),

          array(
            "property"  =>  "dc:Publisher",
            "content"   =>  "Publisher",
          ),

          array(
            "property"  =>  "dc:Publisher.Address",
            "content"   =>  "christopher.isene@gmail.com",
          ),

          array(
            "property"  =>  "dc:Date.Created",
            "content"   =>  date('c', strtotime($date_created)),
          ),

          array(
            "property"  =>  "DC.Date.Created",
            "content"   =>  date('Y-m-d', strtotime($date_created)),
          ),

          array(
            "property"  =>  "DC.Date.Modified",
            "content"   =>  date('Y-m-d', strtotime($date_modified)),
          ),

          array(
            "property"  =>  "dc:Date.Modified",
            "content"   =>  date('c', strtotime($date_modified)),
          ),

          array(
            "property"  =>  "dc:Type",
            "content"   =>  "Text",
          ),

          array(
            "property"  =>  "dc:Format",
            "content"   =>  "text/html",
          ),

          array(
            "property"  =>  "dc:Language",
            "content"   =>  "sv",
          ),

        ),
      ),
    ),
    "categories" => array(
      "index-categories" => 100,
    ),
  ),
  "static" => array(
    "statistics" => "./static/statistics.json",
  ),
);


