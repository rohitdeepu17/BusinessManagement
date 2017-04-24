<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
?>

<!doctype html>
<html lang = "en">
   <head>
      <meta charset = "utf-8">
      <title>jQuery UI Autocomplete functionality</title>
      <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
      <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
      
      <style>
         #project-label {
            display: block;
            font-weight: bold;
            margin-bottom: 1em;
         }
         #project-description {
            margin: 0;
            padding: 0;
         }
      </style>
      
      <!-- Javascript -->
      <script>
         $(function() {
            var projects;
    		$.get( "get_customers.php", function( data ) {
      		//$('#input').val( data );
      		alert("data = "+data);
      		projects = JSON.parse(data);
      		alert("Projects = "+ projects);
    		});
            /*var projects = [
               {
                  "label": "Java",
                  "desc": "write once run anywhere"
               },
               {
                  "label": "Java",
                  "desc": "rohit here"
               },
               {
                  "label": "jQuery UI",
                  "desc": "the official user interface library for jQuery"
               },
               {
                  "label": "Twitter Bootstrap",
                  "desc": "popular front end frameworks "
               }
            ];*/
            $( "#project" ).autocomplete({
               minLength: 0,
               //source: projects,
               source: "get_customers.php",
               focus: function( event, ui ) {
                  $( "#project" ).val( ui.item.label );
                     return false;
               },
               select: function( event, ui ) {
                  $( "#project" ).val( ui.item.label );
                  $( "#project-description" ).html( ui.item.desc );
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
