<?php
include_once "class.SwishFormat.php";

$sf = new SwishFormat();

$url = "https://b19.se/swish-katalogen/api/getHistoryToplist";
$json = file_get_contents("$url");
$data = json_decode($json, true);

$lines = array();
foreach($data as $item) {

  // Todo: do something with $item['highlight']

  $line = array();
  $entry_friendly = $sf->getSwishSpecificFormat($item['entry'], "common")[0];
  $line[] = "<li>";

  $line[] = '<a href="' . $item['path'] . '" title="' . $item['orgName'] . '">';
  $line[] = $entry_friendly;
  $line[] = '</a>';

  $line[] = " ";
  $line[] = $item['orgName'];

  if(strlen($item['comment']) > 0) {
    $line[] = "<br>";
    $lint[] = $item['comment'];
  }

  $line[] = "</li>";

  $lines[] = implode("", $line);
}
$li_list = implode("\n", $lines);


?>
      <div id="pagebody-history-toplist">
        <p>Mest besökta sidor;</p>
        <ul>
<?php echo($li_list); ?>
        </ul>
      </div>
