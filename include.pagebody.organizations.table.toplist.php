<?php

if($db && $ui) {
  $org_items = array();
  $org_items_listing = "";

  $org_items = $db->getToplistOrgNumber(250);
  $org_items_toplist = $ui->getOrgNumberTopListing($org_items);
}

?>

      <div id="pagebody-organizations-toplist">
        <h2>Organisationsnummer Top 250</h2>
        <table>
<?php echo($org_items_toplist); ?>
        </table>
      </div>

