<?php
$cat_route = $ui->getCategoryRouting();
$cat_ranked = $db->getCategoriesAll();

if($cat_route != null) {
  if(preg_match("/^123(\d{7})$/six", strval($cat_route))) {

    $db->LogVisitHistory($cat_route);
    $entry = $db->getEntryByID($cat_route);

    if(sizeof($entry) > 0) {

      $entry_json = $ui->EntryJSON($entry);

      $orgName = $entry['orgName'];

      $entry_categories = $ui->getEntryCategories($entry['categories']);
      $other_categories = $ui->getOtherCategories($cat_ranked, $entry['categories']);

    } else {
      ob_clean();
      header("HTTP/1.1 404 NOT FOUND");
      die("");
    }
  } else {
    ob_clean();
    header("HTTP/1.1 404 NOT FOUND");
    die("");
  }
}


// https://www.ratsit.se/sok/foretag?vem=882601-2240
// https://www.bankgirot.se/sok-bankgironummer/?bgnr=&orgnr=882601-2240&company=&city=
// https://www.upplysning.se/8820005075


// swish://1239004490


?>
      <div id="pagebody-organization-details">
        <div itemscope itemtype="https://schema.org/Organization">
          <table>
          <tr><td>Swish-nummer:</td><td><a href="swish://<?php echo($cat_route); ?>"><?php echo($cat_route); ?></a></td></tr>
          <tr><td>Organisation:</td><td itemprop="name"><?php echo($entry['orgName']); ?></td></tr>
          <tr><td>Organisationsnummer:</span><td itemprop="taxID"><?php echo($entry['orgNumber']); ?></td></tr>
          <tr><td>Hemsida:</span><td><a itemprop="url" href="<?php echo($entry['web']); ?>" target="_blank"><?php echo($entry['web']); ?></a></td></tr>
          <tr><td>Kommentar:</td><td><?php echo($ui->_entryPrettify($entry['comment'])); ?></td></tr>
          <tr><td>Kategorier:</td><td><ul><?php echo($entry_categories); ?></ul></td></tr>
          </table>
        </div>
      </div>

      <script type="application/ld+json"><?php echo($entry_json); ?></script>
