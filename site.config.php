<?php

$protocol = $_SERVER['REQUEST_SCHEME'];
$http_host = $_SERVER['HTTP_HOST'];
$http_uri = $_SERVER['REQUEST_URI'];

$config = array(

  "site" => array(
    "url" => $protocol . "://" . $http_host . "/swish-katalogen/",
    "title" => "Swish-Katalogen",
    "description" => "Swish-Katalogen - Sök och hitta Swish-nummer",
    "dateCreated" => "2022-03-24",
    "dateModified" => date("Y-m-d", time()),
  ),

  "db" => array(
    "sqlite" => array(
      "filepath" => "./__database/swish-123-data.sqlite",
    ),
  ),

  "content" => array(
    "html" => array(
      "header" => array(
        "title" => "Swish-Katalogen - Sök och hitta Swish-nummer, en enkel söktjänst för Swish-nummer",
        "description" => "Swish-Katalogen - Sök och hitta Swish-nummer",

        "link" => array(

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
          )
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

          // Explicit declaration no longer needed
          // array(
          //   "http-equiv"  =>  "content-type",
          //   "content"     =>  "text/html; charset=utf-8",
          // ),

          // Explicit declaration no longer needed
          // array(
          //   "http-equiv"  =>  "content-language",
          //   "content"     =>  "sv",
          // ),

          array(
            "http-equiv"  =>  "pragma",
            "content"     =>  "no-cache",
          ),

          array(
            "http-equiv"  =>  "X-UA-Compatible",
            "content"     =>  "IE=edge",
          ),

          array(
            "http-equiv"  =>  "refresh",
            "content"     =>  "600",
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

          // Nope, because fuck twitter
          // array(
          //   "name"      =>  "twitter:card",
          //   "content"   =>  "summary",
          // ),

          // Nope, because fuck twitter
          // array(
          //   "name"      =>  "twitter:creator",
          //   "content"   =>  "@cisene",
          // ),

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

          // array(
          //   "name"      =>  "color-scheme",
          //   "content"   =>  "dark light",
          // ),

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

          // array(
          //   "name"      =>  "theme-color",
          //   "content"   =>  "#1e2327",
          // ),

          array(
            "name"      =>  "dc.description",
            "content"   =>  "Swish-Katalogen - Sök Swish-nummer",
          ),
          
          array(
            "name"      =>  "description",
            "content"   =>  "Swish-Katalogen - Sök Swish-nummer",
          ),

          // array(
          //   "name"      =>  "msapplication-starturl",
          //   "content"   =>  $protocol ."://" . $http_host . "/swish-katalogen/",
          // ),

          // array(
          //   "name"      =>  "msapplication-task",
          //   "content"   =>  "name=Swish-Katalogen;action-uri=" . $protocol ."://" . $http_host . "/swish-katalogen/;icon-uri=" . $protocol ."://" . $http_host . "/favicon/favicon.ico",
          // ),


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


