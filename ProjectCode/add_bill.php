<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
?>

<!DOCTYPE html>
<html>
<style>
</style>


<body>
<link href="css/my_file.css" rel="stylesheet" type="text/css" />

<nav id="navMenu" class="sidenav"></nav>
<script src="nav_script.js"></script>

<!-- These 3 for autocomplete-->
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
<script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
<script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<form action="db_add_bill.php" class="subform" method="post" id="submit_form_id">
	<fieldset>
	<legend style="font-size:22px">Creating an Invoice:</legend>
  	<div>
  		<div class="sameline">
  			<label class="smalllabel"><b>Customer ID :</b></label>
    		<input class="smallinput" type="text" placeholder="max 20 chars" name="cid" id="cust_id" maxlength="20" value="N.A." readonly="readonly" required>
    	
  			<label class="smalllabel"><b>Customer Name</b></label>
    		<input class="smallinput" type="text" placeholder="max 20 chars" name="cname" id="custname" maxlength="20" list="suggestions" required>
			<datalist id="suggestions">
				<?php 
					include 'connect_my_sql_db.php';
					$qry = "SELECT cust_id, cust_name, father_name FROM customer;";

					$res = mysqli_query($conn, $qry);
					while($data = mysqli_fetch_assoc($res)){
				?>
					<!--<option value="<?php echo $data['cust_name'];?>" data-father="<?php echo $data['father_name'] ?>" data-id="<?php echo $data['cust_id'] ?>"><?php echo $data['father_name'];?></option>-->
					<option value="<?php echo $data['cust_name'];?>" data-father="<?php echo $data['father_name'] ?>" data-custid="<?php echo $data['cust_id'] ?>"><?php echo $data['cust_name']." s/o ".$data['father_name'];?></option>
				<?php
					}
					mysqli_free_result($res);
				?>
			</datalist>
	
    		<label class="smalllabel"><b>Fathers Name</b></label>
    		<input class="smallinput" type="text" placeholder="max 20 chars" name="fname" maxlength="20" id="fathername"required>
    	</div>
    	
    	<div class="sameline">
    		<label class="smalllabel"><b>Address</b></label>
    		<input class="smallinput" type="text" placeholder="village name only" name="caddress" maxlength="20" id="addr" required>
    	
    		<label class="smalllabel"><b>Contact</b></label>
    		<input class="smallinput" type="number" placeholder="phone" name="cphone" id="phone" required>
    	
    		<label class="smalllabel"><b>Other Details</b></label>
    		<!-- <input class="largeinput" type="text" placeholder="" name="cdetails" max-length="50"> -->
    		<textarea class="largeinput" name="cdetails" id="other_details" placeholder="ex : Complete address, C/O, alternate contact number, etc. max 50 chars" cols="40" rows="5" maxlength="50"></textarea>
    	</div>
    	
    	<label class="smalllabel"><b>Invoice Date</b></label>
    	<input class="smallinput" type="date" name="bdate" style="width:150px;" required>
    	
    	<!-- TABLE starts here -->
    	<table id="my_table_id" name="billitems">
    		<tr>
       			<td>Sr. No.</td>
       			<td>Category</td>
       			<td>Product</td>
       			<td>Quantity</td>
       			<td>Unit Price</td>
       			<td>Amount</td>
    		</tr>
    		
    		<tr class="clone_this">
       			<td>1.</td>
       			<td>
       			<select style="width:150px;" class="gr" name="categories[]">
       				<option value="Select Category">Select Category</option>		
    				<?php 
						include 'connect_my_sql_db.php';
						$qry = "SELECT cat_id, cat_name FROM category;";

						$res = mysqli_query($conn, $qry);
						while($data = mysqli_fetch_row($res)){
						echo ("<option value='$data[1]'>$data[1]</option>");
					}
					?></td>
       			<td class="sub_item"><select style="width:150px;" class="it_id" name="products[]">
       				<option value="Select Product">Select Product</option>
				</td>
				<td><input class="qty" type="number" step="0.01" placeholder="ex: 12.50" name="qty[]" value="0.00" required onkeyup="updatePrice(this.value)"></td>
       			<td><input class="unit_price" type="number" step="0.01" placeholder="ex: 56.50" name="unitprice[]" value="0.00" required onkeyup="updatePrice(this.value)"></td>
       			<td><input class="pricecalc" type="number" step="0.01" placeholder="will be calculated" name="calculatedprice[]" value="0.00" required readonly="readonly"></td>
    		</tr>
    		
    		
 		</table>
 		
 		<input type="button" value="Add more items" id="more_items" style="margin-top:10px; margin-bottom:20px"/><br>
 		
 		<span class="sameline">
				<label class="smalllabel" style="width:100px;">Total Amount</label>
				<input class="total_amount" id="total_amount "type="number" step="0.01" placeholder="will be calculated" name="total_amount" value="0.00" required readonly="readonly"></td>
    	</span><br><br>
    	<span class="sameline">
				<label class="smalllabel" style="width:100px;">Discount</label>
				<input class="total_discount" type="number" step="0.01" placeholder="if any" name="total_discount" value="0.00" required>
    	</span><br><br>
    	<span class="sameline">
				<label class="smalllabel" style="width:100px;">Paid Amount</label>
				<input class="paid_amount" type="number" step="0.01" placeholder="if any" name="total_paid" value="0.00" required>
    	</span><br><br>
    	<div class="sameline">
				<label class="smalllabel" style="width:100px;">Balance</label>
				<input class="balance_amount" type="number" step="0.01" placeholder="if any" name="balance_amt" value="0.00" required>
    	</div><br><br>
 		<button type="submit">SUBMIT</button>
  	</div>
  	</fieldset>
</form>

<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

<script>

/*$(".qty").on("keydown", function () {
		alert("onkeydown qty");
		$('#total_amount').val(1);
});*/

$(".qty").on("keyup", function () {
    	var $this = $(this);
		$tr = $this.closest('tr');
		qty_val = $this.val();
		unitprice_val = $tr.find('.unit_price').val();
		amount = qty_val*unitprice_val;
		$(this).closest('tr').find('.pricecalc').attr("value", amount);
		//$('#total_amount').val(amount);
		//$(this).find('.total_amount').attr("value",amount);
		//$(this).find('.total_discount').val(amount);
});

$(".unit_price").on("keyup", function () {
		//alert("jel");
    	var $this = $(this);
		$tr = $this.closest('tr');
		qty_val = $this.val();
		unitprice_val = $tr.find('.qty').val();
		amount = qty_val*unitprice_val;
		$(this).closest('tr').find('.pricecalc').attr("value", amount);
});


$(document).ready(function () {
    $('.gr').change(function () {
        var $this = $(this),
		$tr = $this.closest('tr'),
		gr_id = $this.find('option:selected').val(),
		$subitem = $tr.find('.sub_item'),
		$it_id = $tr.find('.it_id');
		var curRowProduct = $(this).closest('tr').find(".it_id");
		$.ajax({
			type: "POST",
			url: "get_products.php",
			data:'cat_name='+gr_id,
			success: function(data){
				curRowProduct.html(data);
			}
		});
    });
});

$(document).ready(function () {
    $('.it_id').change(function () {
        var $this = $(this),
		$tr = $this.closest('tr'),
		gr_id = $this.find('option:selected').val(),
		$subitem = $tr.find('.sub_item'),
		$it_id = $tr.find('.it_id');
		var curRowUnitPrice = $(this).closest('tr').find(".unit_price");
		var curRowQtyVal = $(this).closest('tr').find(".qty").val();
		var curRowAmount = $(this).closest('tr').find(".pricecalc");
		//alert("qty = "+curRowQtyVal);
		$.ajax({
			type: "POST",
			url: "get_unit_price.php",
			data:'prod_id='+gr_id,
			success: function(data){
				curRowUnitPrice.val(data);
				//curRowAmount.val(data*curRowQtyVal);
			}
		});
    });
});


$("#more_items").on("click", function () {
    //$(".clone_this").clone(true, true).insertBefore("#last_e");
    //$('#my_table_id tr:last').clone(true, true).insertBefore("#last_e");
    //$('#my_table_id tr:last').clone(true, true).insertBefore("#more_items");
    $('#my_table_id tr:last').clone(true, true).insertAfter("#my_table_id tr:last");
    var count = $('#my_table_id tr').length;
    $('#my_table_id tr:last td:first').html(count-1);		//first row is dummy titles row
});

$("#custname").on('input', function () {
	
	//NEED TO LOOK FOR SOLUTION WHEN THERE ARE MANY PEOPLE WITH THE SAME NAME
	var value = this.value;
	var option = $('#suggestions').find("[value='" + value + "']");
	var custid ="N.A";
	if (option.length > 0) {
	  var custid = option.data("custid");
	  
	  	var val = this.value;
		if($('#suggestions').find('option').filter(function(){
			return this.value.toUpperCase() === val.toUpperCase();        
		}).length) {
			//send ajax request
			//alert("Hi"+val);
			$.ajax({
				type: "POST",
				url: "get_cust_details.php",
				data:'cust_id='+custid,
				success: function(data){
					//alert("success"+data);
					data=JSON.parse(data);
					//alert("Hello : "+data.address);
					$('#addr').val(data.address);
					$('#phone').val(data.phone);
					$('#fathername').val(data.father_name);
					$('#other_details').val(data.other_details);
					$('#cust_id').val(data.cust_id);
					//curRowUnitPrice.val(data);
					//curRowAmount.val(data*curRowQtyVal);
				}
			});
		}
	  
	  
	}else{
		//alert("Hi, option length is zero");
	}
	
	

    /*var val = this.value;
    if($('#suggestions').find('option').filter(function(){
        return this.value.toUpperCase() === val.toUpperCase();        
    }).length) {
        //send ajax request
        //alert("Hi"+val);
        $.ajax({
			type: "POST",
			url: "get_cust_details.php",
			data:'cust_id='+custid,
			success: function(data){
				alert("success"+data);
				data=JSON.parse(data);
				//alert("Hello : "+data.address);
				$('#addr').val(data.address);
				$('#phone').val(data.phone);
				$('#fathername').val(data.father_name);
				$('#other_details').val(data.other_details);
				$('#cust_id').val(data.cust_id);
				//curRowUnitPrice.val(data);
				//curRowAmount.val(data*curRowQtyVal);
			}
		});
    }*/
});







 /* (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 		alert("Hi");
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
          	alert("input");
            ui.item.option.selected = true;
            this.element.trigger('change');
            
            this._trigger( "select", event, {
            	alert("select");
              item: ui.item.option
            });
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
      $( "#custname" ).combobox().on('change',function(){
      	  alert("Hey");
          alert($(this).find('option:selected').attr('data-custid')); 
      });
    
  });
*/




//For autocomplete on input customer name
$(function() {
            var projects = [
               {
                  value: "java",
                  label: "Java",
                  desc: "write once run anywhere",
               },
               {
                  value: "java",
                  label: "Java",
                  desc: "rohit here",
               },
               {
                  value: "jquery-ui",
                  label: "jQuery UI",
                  desc: "the official user interface library for jQuery",
               },
               {
                  value: "Bootstrap",
                  label: "Twitter Bootstrap",
                  desc: "popular front end frameworks ",
               }
            ];
            $( "#custname" ).autocomplete({
               minLength: 0,
               source: projects,
               focus: function( event, ui ) {
                  $( "#custname" ).val( ui.item.label );
                     return false;
               },
               select: function( event, ui ) {
                  $( "#custname" ).val( ui.item.label );
                  //$( "#project-id" ).val( ui.item.value );
                  //$( "#project-description" ).html( ui.item.desc );
                  //$( "#project-description" ).val( ui.item.desc );
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

</body>
</html>
