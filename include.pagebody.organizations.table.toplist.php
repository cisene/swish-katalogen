<?php

if($db && $ui) {
  $org_items = array();
  $org_items_listing = "";

  // $org_route = $ui->getOrgNumberRouting();

  $org_items = $db->getToplistOrgNumber(100);

  // echo("<pre>"); var_dump($org_items); echo("</pre>");

  $org_items_toplist = $ui->getOrgNumberTopListing($org_items);
}

?>

      <div id="pagebody-organizations-toplist">
        <h2>Organisationsnummer Top 100</h2>
        <table>
<?php echo($org_items_toplist); ?>
        </table>
      </div>

