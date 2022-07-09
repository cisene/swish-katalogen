<?php
$placeholder_text = null;


?>

    <section id="pagesearch">
      <div id="pagesearch-breadcrumbs">

      </div>
      <div id="pagesearch-searchbox">
        <input placeholder="<?php if($placeholder_text) { echo($placeholder_text); } ?>" id="pagesearch-searchbox-input" type="text" value="">&nbsp;<button id="pagesearch-searchbox-searchbutton" title="Sök">Sök</button>
      </div>
    </section>
