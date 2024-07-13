<?php

// $cat_ranked = $db->getCategoriesAll();
// $cat_ranked = $db->getCategoriesAscending();
// $category_list = $ui->getCategoriesTagCloud($cat_ranked, "non-selected");

$cat_related = $db->getCategoriesRelated($cat_route);
$category_list = $ui->getCategoriesTagCloud($cat_related, "non-selected");


?>

      <div id="pagebody-categories">
        <a href="/swish-katalogen/k/"><h2>Relaterade Kategorier</h2></a>
        <ul>
          <?php echo($category_list); ?>
        </ul>
      </div>
