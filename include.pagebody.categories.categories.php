<?php

// $cat_ranked = $db->getCategoriesAll();
$cat_ranked = $db->getCategoriesAscending();
$category_list = $ui->getCategoriesTagCloud($cat_ranked, "non-selected");

?>

      <div id="pagebody-categories">
        <a href="/swish-katalogen/k/"><h2>Kategorier</h2></a>
        <ul role="navigation" aria-label="Webdev tag cloud">
          <?php echo($category_list); ?>
        </ul>
      </div>
