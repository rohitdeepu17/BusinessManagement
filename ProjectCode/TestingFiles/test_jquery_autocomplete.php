<!doctype html>
<html lang = "en">
   <head>
      <meta charset = "utf-8">
      <title>jQuery UI Autocomplete functionality</title>
      <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
      <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
      
      <!-- Javascript -->
      <script>
         $(function() {
            $( "#project" ).autocomplete({
               minLength: 0,
               source: "get_customers.php",
               focus: function( event, ui ) {
                  $( "#project" ).val( ui.item.label );
                     return false;
               },
               select: function( event, ui ) {
                  $( "#project" ).val( ui.item.label );
                  $( "#project-description" ).val( ui.item.desc );
                  return false;
               }
            })
				
            .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
               return $( "<li>" )
               .append( "<a>" + item.label + "<br>" + item.desc + "</a>" )
               .appendTo( ul );
            };
         });
      </script>
   </head>
   
   <body>
   	<form action="test_autocomplete.php" class="subform" method="post">
      <div id = "project-label">Select a project (type "a" for a start):</div>
      <input id = "project">
      <input id = "project-description" name="projectdescription">
      
      <button type="submit">SUBMIT</button>
    </form>
   </body>
</html>
