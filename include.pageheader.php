<?php
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

$items = array();
foreach($breadcrumbs['itemListElement'] as $item) {
  $elem = array();
  $elem[] = "<li>";
  $elem[] = "<a href=\"" . strval($item['item']['@id']) . "\" title=\"" . strval($item['item']['name']) . "\">";
  $elem[] = strval($item['item']['name']);
  $elem[] = "</a>";
  $elem[] = "</li>";

  $row = join($elem);
  $items[] = $row . "\n";
}
$navLinks = join($items);
?>
    <section id="pageheader">
      <a href="/swish-katalogen/"><h1>Swish-Katalogen</h1></a>
    </section>

    <script type="application/ld+json"><?php echo(json_encode($breadcrumbs)); ?></script>

    <nav>
      <ul>
        <?php echo($navLinks); ?>
      </ul>
    </nav>
