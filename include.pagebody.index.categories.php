<?php

// $cat_ranked = $db->getCategoriesAll();
$cat_ranked = $db->getCategoriesLimited($config["content"]["categories"]["index-categories"]);
$category_list = $ui->getCategoriesTagCloud($cat_ranked, "non-selected");

?>

      <div id="pagebody-categories">
        <a href="/swish-katalogen/k/"><h2>Kategorier</h2></a>
        <ul>
<?php echo($category_list); ?>
        </ul>
        Dessa är de största <?php echo($config["content"]["categories"]["index-categories"]); ?> kategorierna, samtliga finns <a href="/swish-katalogen/k/">här</a>
        <p></p>
      </div>
