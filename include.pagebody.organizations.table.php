<?php

if($db && $ui) {
  // $category_items = array();
  // $category_item_listing = "";
  $org_items = array();
  $org_items_listing = "";

  $org_route = $ui->getOrgNumberRouting();
  // $cat_ranked = $db->getCategoriesAll();


  if($org_route != null) {
    // $category_items = $db->getEntriesByCategory($cat_route);
    $org_items = $db->getEntriesByOrgNumber($org_route);

    echo("<pre>"); var_dump($org_items); echo("</pre>");

    $org_items_listing = $ui->getEntriesOrgNumberListing($org_items);
    // $category_item_listing = $ui->getEntriesCategoryListing($category_items);

  }
}

?>

      <div id="pagebody-organizations-table">
        <h2>Swishnummer som hör till organisationsnummer '<?php echo($org_route); ?>'</h2>
        <table>
<?php echo($org_items_listing); ?>
        </table>
      </div>

