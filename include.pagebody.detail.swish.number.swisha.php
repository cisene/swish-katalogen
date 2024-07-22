<?php
// $number_variants = $sf->getSwishAllFormats($cat_route);
// $variants = $ui->getLIFormattedSwishNumberList($number_variants);

$payload = array(
  "message" => array(
    "value" => "Gåva genom Swish Katalogen.",
    "editable" => true
  ),
  "payee" => array(
    "value" => $cat_route,
    "editable" => false
  ),
  "version" => 1
);
$data = urlencode(json_encode($payload));

?>
      <div id="pagebody-swish-number-swisha" class="mobile-enabled">
        <a href="swish://payment?data=<?php echo($data); ?>&amp;source=swish-katalogen">Swisha</a>
      </div>