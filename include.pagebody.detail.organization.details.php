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

      if(preg_match("/^(\d{6})\x2d(\d{4})$/six", strval($entry['orgNumber']))) {
        // TODO: call getCountByOrgNumber() with orgNumber
        // count > 1 should yield a link through /swish-katalogen/o/{orgNumber}
      } else {
        // TODO: handle non-organisation numbers such as persons with enskild firma
      }

      /* Build swish payment blob */
      $payload = array(
        "message" => array(
          "value" => "Gåva genom Swish Katalogen.",
          "editable" => true
        ),
        "payee" => array(
          "value" => $cat_route,
          "editable" => false
        ),
        "version" => 1
      );
      $paymentdata = urlencode(json_encode($payload));

    } else {
      ob_clean();
      header("HTTP/1.1 410 Gone");
      die("<!DOCTYPE html>");
    }
  } else {
    ob_clean();
    header("HTTP/1.1 400 Bad Request");
    die("<!DOCTYPE html>");
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
          <tr>
            <td>Swish-nummer:</td>
            <td><a href="swish://payment?data=<?php echo($paymentdata); ?>&amp;source=swish-katalogen"><?php echo($cat_route); ?></a></td>
          </tr>
          <tr>
            <td>Organisation:</td>
            <td itemprop="name"><?php echo($entry['orgName']); ?></td>
          </tr>
          <tr>
            <td>Organisationsnummer:</td>
            <td itemprop="taxID"><?php echo($entry['orgNumber']); ?></td>
          </tr>
          <tr>
            <td>Hemsida:</td>
            <td><a itemprop="url" href="<?php echo($entry['web']); ?>" target="_blank"><?php echo($entry['web']); ?></a></td>
          </tr>
          <tr>
            <td>Kommentar:</td>
            <td><?php echo($ui->_entryPrettify($entry['comment'])); ?></td>
          </tr>
          <tr>
            <td>Kategorier:</td>
            <td>
              <ul>
                <?php echo($entry_categories); ?>
                  
              </ul>
            </td>
          </tr>
          </table>
        </div>
      </div>

      <div id="pagebody-swish-number-swisha" class="mobile-enabled">
        <a href="swish://payment?data=<?php echo($paymentdata); ?>&amp;source=swish-katalogen">Swisha</a>
      </div>

      <script type="application/ld+json"><?php echo($entry_json); ?></script>
