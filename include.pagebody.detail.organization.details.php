<?php
$cat_route = $ui->getCategoryRouting();
$cat_ranked = $db->getCategoriesAll();

if($cat_route != null) {
  if(preg_match("/^123(\d{7})$/six", strval($cat_route))) {

    $entry = $db->getEntryByID($cat_route);
    if(sizeof($entry) > 0) {

      $entry_json = $ui->EntryJSON($entry);

      $orgName = $entry['orgName'];

      $entry_categories = $ui->getEntryCategories($entry['categories']);
      $other_categories = $ui->getOtherCategories($cat_ranked, $entry['categories']);


    } else {
      header("HTTP/1.1 404 NOT FOUND");
      die("");
    }
  } else {
    header("HTTP/1.1 404 NOT FOUND");
    die("");
  }
}


// swish://1239004490


?>
      <div id="pagebody-organization-details">
        <h2>Swish-nummer: <?php echo($cat_route); ?></h2>
        <p></p>
        <div itemscope itemtype="https://schema.org/Organization">
          <table>
          <tr><td>Swish-nummer:</td><td><?php echo($cat_route); ?></td></tr>
          <tr><td>Organisation:</td><td itemprop="name"><?php echo($entry['orgName']); ?></td></tr>
          <tr><td>Organisationsnummer:</span><td itemprop="taxID"><?php echo($entry['orgNumber']); ?></td></tr>
          <tr><td>Hemsida:</span><td><a itemprop="url" href="<?php echo($entry['web']); ?>" target="_blank"><?php echo($entry['web']); ?></a></td></tr>
          <tr><td>Kategorier:</td><td><ul><?php echo($entry_categories); ?></ul></td></tr>
          </table>
        </div>
      </div>

      <script type="application/ld+json"><?php echo($entry_json); ?></script>
