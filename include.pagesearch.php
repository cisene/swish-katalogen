<?php
$placeholder_text = null;
$search_term = null;

?>

    <script type="application/javascript">
      $( document ).ready(function() {
        console.log( "ready!" );
      });

      $( "#searchbox" ).submit(function( event ) {
        console.log(event);
        alert( "Handler for .submit() called." );
        event.preventDefault();
      });

      $( "#pagesearch-searchbox-searchbutton" ).on( "click", function() {
        console.log(this);
      });


    </script>
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "WebSite",
        "url": "https://b19.se/swish-katalogen/s/",
        "potentialAction": {
          "@type": "SearchAction",
          "target": "https://b19.se/swish-katalogen/s/{search_term_string}",
          "query-input": "required name=search_term_string"
        }
      }
    </script>

    <section id="pagesearch">

      <div id="pagesearch-breadcrumbs">
      </div>

      <div id="pagesearch-searchbox">
        <!-- 
        <form id="searchbox" action="#">
          <input placeholder="<?php if($placeholder_text) { echo($placeholder_text); } ?>" id="pagesearch-searchbox-input" type="text" value="<?php echo($search_term); ?>">
          <button id="pagesearch-searchbox-searchbutton" title="Sök">Sök</button>
        </form>
        -->
      </div>

    </section>
