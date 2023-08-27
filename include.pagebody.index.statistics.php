<?php
// Declare a template string with tokens to replace with values from JSON
$template = "Databasen uppdaterades <span class=\"updated\">{{statistics.updated}}</span> och innehåller <span class=\"entries\">{{statistics.entries}}</span> Swish-nummer fördelade över <span class=\"categories\">{{statistics.categories}}</span> kategorier.";

// Point at resource in the config structure and load it into a variable/array
$data = $ui->LoadJson($config["static"]["statistics"]);

// Regex replace values into the templated string
$text = preg_replace("/\x7b\x7bstatistics\x2eupdated\x7d\x7d/six", $data["updated"], $template);
$text = preg_replace("/\x7b\x7bstatistics\x2eentries\x7d\x7d/six", $data["entries"], $text);
$text = preg_replace("/\x7b\x7bstatistics\x2ecategories\x7d\x7d/six", $data["categories"], $text);

?>

      <div id="pagebody-statistics">
        <div id="pagebody-statistics-text"><?php echo($text); ?></div>
      </div>
