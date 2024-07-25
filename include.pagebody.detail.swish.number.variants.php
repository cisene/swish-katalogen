<?php
$number_variants = $sf->getSwishAllFormats($cat_route);
$variants = $ui->getLIFormattedSwishNumberList($number_variants);

?>
      <div id="pagebody-swish-number-variants">
        <h3>Variationer på Swish-nummer</h3>
        <ul>
<?php echo($variants); ?>
        </ul>
      </div>