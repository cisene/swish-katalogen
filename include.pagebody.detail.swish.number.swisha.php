<?php
$number_variants = $sf->getSwishAllFormats($cat_route);
$variants = $ui->getLIFormattedSwishNumberList($number_variants);

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
$data = json_encode($payload);

?>
      <div id="pagebody-swish-number-swisha" class="mobile-enabled" style="display:none">
        <a href="swish://payment?data=%7B%22message%22%3A%7B%22value%22%3A%22G%C3%A5va%20till%20de%20som%20drabbats%20i%20jordb%C3%A4vningen.%22%2C%22editable%22%3Atrue%7D%2C%22payee%22%3A%7B%22value%22%3A%22900%2080%2004%22%2C%22editable%22%3Afalse%7D%2C%22version%22%3A1%7D&amp;source=charity">Swisha</a>
      </div>