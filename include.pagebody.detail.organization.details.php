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


      $number_variants = $sf->getSwishAllFormats($cat_route);
      $variants = $ui->getFormattedSwishNumberList($number_variants);

    } else {
      header("HTTP/1.1 404 NOT FOUND");
      die("");
    }
  } else {
    header("HTTP/1.1 404 NOT FOUND");
    die("");
  }
}

?>
      <div id="pagebody-organization-details">
        <div itemscope itemtype="https://schema.org/Organization">
          <span class="kv-pair">
            <span class="kv-pair-key">Organisation:</span>
            <span class="kv-pair-value" itemprop="name"><?php echo($entry['orgName']); ?></span>
          </span>
          <br>
          <span class="kv-pair">
            <span class="kv-pair-key">Organisationsnummer:</span>
            <span class="kv-pair-value" itemprop="taxID"><?php echo($entry['orgNumber']); ?></span>
          </span>
          <br>
          <span class="kv-pair">
            <span class="kv-pair-key">Hemsida:</span>
            <span class="kv-pair-value"><a itemprop="url" href="<?php echo($entry['web']); ?>" target="_blank"><?php echo($entry['web']); ?></a></span>
          </span>
          <br>
          <span class="kv-pair">
            <span class="kv-pair-key">Kategorier:</span>
            <span class="kv-pair-value"><ul><?php echo($entry_categories); ?></ul></span>
          </span>
        </div>
      </div>

      <script type="application/ld+json"><?php echo($entry_json); ?></script>
