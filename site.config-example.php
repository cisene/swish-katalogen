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

define("PAGE_START_TITLE",          SITE_NAME . " - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer");
define("PAGE_START_DESC",           SITE_NAME . " - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer");

define("PAGE_CATEGORIES_ALL_TITLE", "Alla Kategorier i bokstavsordning - " . SITE_NAME);
define("PAGE_CATEGORIES_ALL_DESC",  "Alla Kategorier i bokstavsordning - " . SITE_NAME);

define("PAGE_CATEGORY_TITLE",       "Kategori '%category%' - " . SITE_NAME);
define("PAGE_CATEGORY_DESC",        "Organisationer i kategorin '%category%' - " . SITE_NAME);

define("PAGE_DETAIL_TITLE",         "%orgName% - %entry% - " . SITE_NAME);
define("PAGE_DETAIL_DESC",          "Information om %orgName% - %entry% - " . SITE_NAME);

define("PAGE_ORGANISATION_TITLE",   "Swishnummer som hör till organisationsnummer '%orgNumber%' - " . SITE_NAME);
define("PAGE_ORGANISATION_DESC",    "Swishnummer som hör till organisationsnummer '%orgNumber%' - " . SITE_NAME);


$config = array(

  "site" => array(
    "name"          => "Swish-Katalogen",
    // "url"           => $protocol . "://" . $http_host . "/swish-katalogen/",
    "url"           => URL_ROOT,
    "title"         => "Swish-Katalogen",
    "description"   => "Swish-Katalogen - Sök och hitta Swish-nummer",
    "dateCreated"   => $date_created,
    "dateModified"  => $date_modified,
    "host"          => $_SERVER['HTTP_HOST'],
    "protocol"      => $_SERVER['REQUEST_SCHEME'],
    "uri"           => $_SERVER['REQUEST_URI'],
  ),

  "db" => array(
    "mysql" => array(
      "hostname"    => "<fill in hostname>",
      "port"        => "3306",
      "username"    => "<username>",
      "password"    => "<password>",
      "database"    => "<databasename>",
    )
  ),

  "urls" => array(
    "main"              => URL_ROOT,
    "categories"        => URL_ROOT . "/k/",
    "orgNumberToplist"  => URL_ROOT . "/o/",
    "search"            => URL_ROOT . "/s/",
  ),

  "content" => array(
    "html" => array(
      "header" => array(

        "title"         =>  "Swish-Katalogen - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer",

        "link" => array(

          // <link rel="icon" href="data:,"/>
          array(
            "rel"       =>  "icon",
            "href"      =>  "data:,"
          ),

          "rel_canonical" => array(
            "rel"       =>  "canonical",
            "itemProp"  =>  "url",
            "href"      =>  $protocol ."://" . $http_host . $http_uri,
          ),

          // <link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.xml">
          array(
            "rel"       =>  "sitemap",
            "type"      =>  "application/xml",
            "title"     =>  "Sitemap",
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
            "href"      =>  URL_ICON_32x32,
          ),

          array(
            "rel"       =>  "index",
            "title"     =>  "Index",
            "href"      =>  URL_ROOT,
          ),

          array(
            "rel"       =>  "categories",
            "title"     =>  "Kategorier",
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
            "href"      =>  URL_OPENSEARCH,
          ),

        ),

        "meta" => array(

          array(
            "charset"       =>  "UTF-8",
          ),

          array(
            "name"          =>  "robots",
            "content"       =>  "index,follow",
          ),

          // <meta name="viewport" content="width=device-width,initial-scale=1"/>
          array(
            "name"          =>  "viewport",
            "content"       =>  "width=device-width,initial-scale=1",
          ),


          // <meta name="country" content="SE">
          array(
            "name"          => "country",
            "content"       => "SE",
          ),

          "description" => array(
            "name"          =>  "description",
            "content"       =>  "Swish-Katalogen - Sök Swish-nummer i katalogen, Hitta företag, föreningar och församlingar.",
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
            "itepProp"        =>  "dateModified",
            "content"         =>  $date_modified,
          ),

          array(
            "name"            =>  "Creation-Date",
            "itemProp"        =>  "dateCreated",
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

          // <meta name="dcterms.identifier" content="https://pro.se">
          array(
            "name"            =>  "dcterms.identifier",
            "content"         =>  URL_ROOT,
          ),

          // <meta name="dcterms.language" content="sv">
          array(
            "name"            =>  "dcterms.language",
            "content"         =>  "sv",
          ),

          // <meta name="dcterms.format" content="text/html">
          array(
            "name"            =>  "dcterms.format",
            "content"         =>  "text/html",
          ),

          // <meta name="dcterms.type" content="text">
          array(
            "name"            =>  "dcterms.type",
            "content"         =>  "text",
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
            "property"  =>  "dc:Date.Modified",
            "content"   =>  date('c', strtotime($date_modified)),
          ),

          array(
            "property"  =>  "DC.Date.Modified",
            "content"   =>  date('Y-m-d', strtotime($date_modified)),
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

  "external" => array(

    "infoservices" => array(
      array(
        "name"    => "Bolagsfakta",
        "url"     => "https://www.bolagsfakta.se/sok?vad={flattenedOrgNumber}",
        "enabled" => true,
        "when"    => "^(\d{6})\x2d(\d{4})$",
      ),
      array(
        "name"    => "Ratsit",
        "url"     => "https://www.ratsit.se/{flattenedOrgNumber}",
        "enabled" => true,
        "when"    => "^(\d{6})\x2d(\d{4})$",
      ),
      array(
        "name"    => "AllaBolag",
        "url"     => "https://www.allabolag.se/{flattenedOrgNumber}",
        "enabled" => true,
        "when"    => "^(\d{6})\x2d(\d{4})$",
      ),
      array(
        "name"    => "Syna",
        "url"     => "https://upplysningar.syna.se/foretag/{flattenedOrgNumber}",
        "enabled" => true,
        "when"    => "^5(\d{5})\x2d(\d{4})$",
      ),
      array(
        "name"    => "Bolagsverket",
        "url"     => "https://foretagsinfo.bolagsverket.se/sok-foretagsinformation-web/foretag?sokord={OrgNumber}",
        "enabled" => true,
        "when"    => "^5(\d{5})\x2d(\d{4})$",
      ),
      array(
        "name"    => "MerInfo",
        "url"     => "https://www.merinfo.se/search?q={OrgNumber}",
        "enabled" => true,
        "when"    => "^(\d{6})\x2d(\d{4})$",
      ),
      array(
        "name"    => "Upplysning",
        "url"     => "https://www.upplysning.se/{flattenedOrgNumber}",
        "enabled" => true,
        "when"    => "^(\d{6})\x2d(\d{4})$",
      ),
      array(
        "name"    => "Hitta.se",
        "url"     => "https://www.hitta.se/s%C3%B6k?vad={OrgNumber}",
        "enabled" => true,
        "when"    => "^(\d{6})\x2d(\d{4})$",
      ),
      array(
        "name"    => "Eniro",
        "url"     => "https://www.eniro.se/{OrgNumber}/f%C3%B6retag",
        "enabled" => true,
        "when"    => "^(\d{6})\x2d(\d{4})$",
      ),

    ),

  ),

  "static" => array(
    "statistics" => "./static/statistics.json",
  ),
);


