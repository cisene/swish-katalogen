<?php

if($db && $ui) {
  $category_items = array();
  $category_item_listing = "";

  $cat_route = $ui->getCategoryRouting();
  $cat_ranked = $db->getCategoriesAll();


  if($cat_route != null) {
    $category_list = $ui->getCategoriesTagCloud($cat_ranked, $cat_route);

    $category_items = $db->getEntriesByCategory($cat_route);
    $category_item_listing = $ui->getEntriesCategoryListing($category_items);

  } else {
    $category_list = $ui->getCategoriesTagCloud($cat_ranked, "non-selected");
  }

  if(sizeof($category_items) < 1) {
    $category_list = $ui->getCategoriesTagCloud($cat_ranked, "non-selected");
  }

}

?>

      <div id="pagebody-categories-table">
        <?php if($cat_route != null) { ?>
        <h2>Organisationer i kategorin '<?php echo($cat_route); ?>'</h2>
        <table>
          <?php echo($category_item_listing); ?>
        </table>
        <?php } ?>
      </div>

