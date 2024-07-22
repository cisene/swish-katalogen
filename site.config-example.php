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

define("URL_ROOT",          $protocol . "://" . $http_host . "/swish-katalogen/");

define("URL_SITEMAP",       URL_ROOT . "sitemap.xml");

define("URL_OPENSEARCH",    URL_ROOT . "opensearch.xml")

define("URL_MANIFEST",      URL_ROOT . "manifest.json")

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

define("PAGE_START_TITLE", "");
define("PAGE_START_DESC", "")

define("PAGE_CATEGORIES_ALL_TITLE", "");
define("PAGE_CATEGORIES_ALL_DESC", "")

$config = array(

  "site" => array(
    "name"          => "Swish-Katalogen",
    "url"           => $protocol . "://" . $http_host . "/swish-katalogen/",
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

        "title"         => "Swish-Katalogen - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer",

        "link" => array(

          array(
            "rel"       => "alternate",
            "hreflang"  => "sv",
            "href"      => "/swish-katalogen/"
          ),

          array(
            "rel"       => "sitemap",
            "type"      =>  "application/xml",
            "href"      => $protocol ."://" . $http_host . "/swish-katalogen/sitemap.xml",
          ),

          array(
            "rel"       =>  "apple-touch-icon",
            "href"      =>  $protocol ."://" . $http_host . "/favicon/favicon_192x192.jpg?v=1",
          ),

          array(
            "rel"       =>  "icon",
            "type"      =>  "image/png",
            "sizes"     =>  "32x32",
            "href"      =>  $protocol ."://" . $http_host . "/favicon/favicon_32x32.jpg?v=1",
          ),

          array(
            "rel"       =>  "canonical",
            "href"      =>  $protocol ."://" . $http_host . $http_uri,
          ),

          array(
            "rel"       =>  "categories",
            "title"     =>  "Kategorier",
            "href"      =>  $protocol ."://" . $http_host . "/swish-katalogen/k/",
          ),

          array(
            "rel"       =>  "index",
            "title"     =>  "Index",
            "href"      =>  $protocol ."://" . $http_host . "/swish-katalogen/",
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
            "href"      =>  $protocol ."://" . $http_host . "/swish-katalogen/opensearch.xml",
          ),

        ),

        "meta" => array(

          array(
            "charset"     =>  "utf-8",
          ),

          array(
            "name"        =>  "robots",
            "content"     =>  "index,follow",
          ),

          array(
            "name"        =>  "sitemap",
            "content"     =>  $protocol . "://" . $http_host . "/swish-katalogen/sitemap.xml",
          ),

          array(
            "name"        => "google",
            "content"       => "notranslate",
          ),

          array(
            "name"        =>  "content",
            "content"     =>  "general",
          ),

          array(
            "name"        =>  "distribution",
            "content"     =>  "global",
          ),

          array(
            "name"        =>  "revisit-after",
            "content"     =>  "1 day",
          ),

          array(
            "name"        =>  "last_modified",
            "content"     =>  $date_modified,
          ),

          array(
            "name"        =>  "changed",
            "content"     =>  $date_modified,
          ),

          array(
            "name"        =>  "creation_date",
            "content"     =>  $date_created,
          ),

          array(
            "name"        =>  "category",
            "content"     =>  "site;sv"
          ),

          array(
            "name"        =>  "category",
            "content"     =>  "contexttype;page"
          ),

          array(
            "name"        =>  "application-name",
            "content"     =>  "Swish-Katalogen",
          ),

          array(
            "name"      =>  "viewport",
            "content"   =>  "width=device-width, initial-scale=1.0, shrink-to-fit=no",
          ),

          array(
            "name"      => "apple-mobile-web-app-capable",
            "content"   => "no",
          ),

          array(
            "name"      => "apple-mobile-web-app-status-bar-style",
            "content"   => "default",
          ),

          array(
            "name"      => "apple-mobile-web-app-title",
            "content"   => "Swish-Katalogen",
          ),

          array(
            "name"      => "desciption",
            "content"   => "Swish-Katalogen - Sök och hitta Swish-nummer",
          ),

          array(
            "name"      =>  "msapplication-TileImage",
            "content"   =>  $protocol ."://" . $http_host . "/favicon/favicon_150x150.jpg?v=1",
          ),

          array(
            "property"  =>  "og:description",
            "content"   =>  "Swish-Katalogen, en enkel söktjänst för Swish-nummer. Sök och hitta Swish-nummer.",
          ),

          array(
            "property"  =>  "og:image",
            "content"   =>  $protocol ."://" . $http_host . "/favicon/favicon_512x512.jpg",
          ),

          array(
            "property"  =>  "og:locale",
            "content"   =>  "sv_SE",
          ),

          array(
            "property"  =>  "og:site_name",
            "content"   =>  "Swish-Katalogen",
          ),

          array(
            "property"  =>  "og:title",
            "content"   =>  "Swish-Katalogen",
          ),

          array(
            "property"  =>  "og:url",
            "content"   =>  $protocol ."://" . $http_host . "/swish-katalogen/",
          ),

          array(
            "name"      =>  "expected-hostname",
            "content"   =>  $http_host,
          ),

          array(
            "name"      =>  "hostname",
            "content"   =>  $http_host,
          ),

          array(
            "name"      =>  "HandheldFriendly",
            "content"   =>  "true",
          ),

          array(
            "name"      =>  "referrer",
            "content"   =>  "same-origin",
          ),

          array(
            "name"      =>  "dc.description",
            "content"   =>  "Swish-Katalogen - Sök Swish-nummer",
          ),
          
          array(
            "name"      =>  "description",
            "content"   =>  "Swish-Katalogen - Sök Swish-nummer",
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


