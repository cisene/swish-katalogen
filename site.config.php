<?php

$config = array(
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
            "rel"       =>  "apple-touch-icon",
            "href"      =>  "https://b19.se/favicon/favicon_192x192.jpg?v=1",
          ),
          array(
            "rel"       =>  "icon",
            "type"      =>  "image/png",
            "sizes"     =>  "32x32",
            "href"      =>  "https://b19.se/favicon/favicon_32x32.jpg?v=1",
          ),
          array(
            "rel"       =>  "manifest",
            "href"      =>  "https://b19.se/swish-katalogen/manifest/manifest.json?v=1",
          ),

          // Here we declare a LINK element to enable autodiscovery of OpenSearch capabilities within Swish-Katalogen :)
          array(
            "rel"       =>  "search",
            "type"      =>  "application/opensearchdescription+xml",
            "title"     =>  "Swish-Katalogen",
            "href"      =>  "https://b19.se/swish-katalogen/opensearch.xml",
          )
        ),

        "meta" => array(

          array(
            "charset"   =>  "utf-8",
          ),
          array(
            "http-equiv" => "X-UA-Compatible",
            "content"   =>  "IE=edge",
          ),
          array(
            "name"      =>  "viewport",
            "content"   =>  "width=device-width,initial-scale=1",
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
            "content"   =>  "/favicon/favicon_150x150.jpg?v=1"
          ),
          array(
            "name"      =>  "twitter:card",
            "content"   =>  "summary",
          ),
          array(
            "name"      =>  "twitter:creator",
            "content"   =>  "@cisene",
          ),
          array(
            "property"  =>  "og:description",
            "content"   =>  "Swish-Katalogen, en enkel söktjänst för Swish-nummer. Sök och hitta Swish-nummer.",
          ),
          array(
            "property"  =>  "og:image",
            "content"   =>  "https://b19.se/favicon/favicon_512x512.jpg",
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
            "content"   =>  "https://b19.se/swish-katalogen/",
          ),
        ),
      ),
    ),
  ),
  "static" => array(
    "statistics" => "./static/statistics.json",
  ),
);


