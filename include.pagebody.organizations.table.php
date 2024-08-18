<?php

if($db && $ui) {
  // $category_items = array();
  // $category_item_listing = "";

  $org_route = $ui->getOrgNumberRouting();
  // $cat_ranked = $db->getCategoriesAll();


  if($org_route != null) {
    // $category_list = $ui->getCategoriesTagCloud($cat_ranked, $cat_route);

    // $category_items = $db->getEntriesByCategory($cat_route);
    // $category_item_listing = $ui->getEntriesCategoryListing($category_items);

  } else {
    // $category_list = $ui->getCategoriesTagCloud($cat_ranked, "non-selected");
  }
}

?>

      <div id="pagebody-organizations-table">
        <h2>Swishnummer som hör till organisationsnummer '<?php echo($org_route); ?>'</h2>
        <table>
<?php // echo($category_item_listing); ?>
        </table>
      </div>

