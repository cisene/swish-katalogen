<?php
$cisene = array(
  "@context"  => "https://schema.org",
  "@type"     => "Person",
  "name"      => "Christopher Isene",
  "url"       => "https://christopherisene.se/",
  "sameAs"    => array(
    "https://github.com/cisene",
    "https://www.linkedin.com/in/christopherisene",
    "https://mastodon.social/@cisene",
    "https://podcastindex.social/@cisene",
    "https://pixelfed.social/@cisene",
    "https://keybase.io/cisene"
  )
);

$breadcrumbs = array(
  "@context"  => "https://schema.org",
  "@type"     => "BreadcrumbList",
  "itemListElement" => array(
    array(
      "@type"     => "ListItem",
      "position"  => 1,
      "item"      => array(
        "@id" => "https://b19.se/swish-katalogen/",
        "name" => "Hem"
      )
    ),
    array(
      "@type"     => "ListItem",
      "position"  => 2,
      "item"      => array(
        "@id" => "https://b19.se/swish-katalogen/k/",
        "name" => "Kategorier"
      )
    ),
    array(
      "@type"     => "ListItem",
      "position"  => 3,
      "item"      => array(
        "@id" => "https://b19.se/swish-katalogen/o/",
        "name" => "Organisationer"
      )
    ),

    // array(
    //   "@type"     => "ListItem",
    //   "position"  => 4,
    //   "item"      => array(
    //     "@id" => "https://b19.se/swish-katalogen/s/",
    //     "name" => "Sök"
    //   )
    // ),

  )
);

// TODO: Dynamic Breadcrumbs .. navigation as input


$items = array();
foreach($breadcrumbs['itemListElement'] as $item) {
  $elem = array();
  $elem[] = "        <li>";
  $elem[] = "<a href=\"" . strval($item['item']['@id']) . "\" title=\"" . strval($item['item']['name']) . "\">";
  $elem[] = strval($item['item']['name']);
  $elem[] = "</a>";
  $elem[] = "</li>\n";

  $row = join($elem);
  $items[] = $row;
}
$navLinks = join($items);
?>
    <section id="pageheader">
      <a href="/swish-katalogen/"><h1>Swish-Katalogen</h1></a>
    </section>

    <script type="application/ld+json"><?php echo(json_encode($cisene)); ?></script>
    <script type="application/ld+json"><?php echo(json_encode($breadcrumbs)); ?></script>

    <nav id="pagenavigation">
      <ul>
<?php echo($navLinks); ?>
      </ul>
    </nav>
