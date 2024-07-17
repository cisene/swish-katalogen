<?php

// $cat_ranked = $db->getCategoriesAll();
$cat_ranked = $db->getCategoriesAscending();
$category_list = $ui->getCategoriesTagCloud($cat_ranked, "non-selected");

?>

      <div id="pagebody-categories">
        <a href="/swish-katalogen/k/"><h2>Alla kategorier i alfabetisk ordning</h2></a>
        <ul>
<?php echo($category_list); ?>
        </ul>
      </div>
