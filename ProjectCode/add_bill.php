<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
?>

<!DOCTYPE html>
<html>
<head>
	<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
      <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
      
      <!-- Javascript -->
      <script>
         $(function() {
            $( "#custname" ).autocomplete({
               minLength: 2,
               source: "get_customers.php",
               focus: function( event, ui ) {
                  $( "#custname" ).val( ui.item.name );
                     return false;
               },
               select: function( event, ui ) {
                  $( "#custname" ).val( ui.item.name );
                  $( "#fathername" ).val( ui.item.fname );
                  $("#cust_id").val(ui.item.custid);
                  $("#addr").val(ui.item.address);
                  $("#phone").val(ui.item.phone);
                  $("#other_details").val(ui.item.details);
                  return false;
               }
            })
				
            .data( "ui-autocomplete" )._renderItem = function( ul, item ) {
               return $( "<li>" )
               .append( "<a>" + item.name + " s/o " + item.fname + "</a>" )
               .appendTo( ul );
            };
         });
      </script>
</head>
<style>
</style>


<body>
<link href="css/my_file1.css" rel="stylesheet" type="text/css" />

<nav id="navMenu" class="sidenav"></nav>
<script src="nav_script.js"></script>

<form action="db_add_bill.php" class="subform" method="post" id="submit_form_id">
	<fieldset>
	<legend style="font-size:22px">Creating an Invoice:</legend>
  	<div>
  		<div class="sameline">
  			<label class="smalllabel"><b>Customer ID :</b></label>
    		<input class="smallinputreadonly" type="text" placeholder="max 20 chars" name="cid" id="cust_id" maxlength="20" value="N.A." readonly="readonly" required>
    	
  			<label class="smalllabel"><b>Customer Name</b></label>
  			<input class="smallinput" type="text" placeholder="max 20 chars" name="cname" id="custname" maxlength="20" required>
	
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
    	<input class="smallinput" type="date" name="bdate" required>
    	
    	<!-- TABLE starts here -->
    	<table id="my_table_id" class="my_table_id" name="billitems">
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
 		
 		<input type="button" value="Add more items" id="more_items" class="more_items"/><br>
 		<div style="float:right">
 		
 		<span class="sameline">
				<label class="smalllabel" style="width:100px;">Total Amount</label>
				<input class="total_amount" id="total_amount "type="number" step="0.01" placeholder="will be calculated" name="total_amount" value="0.00" required readonly="readonly"></td>
    	</span><br><br>
    	<span class="sameline">
				<label class="smalllabel" style="width:100px;">Discount</label>
				<input class="total_discount" type="number" step="0.01" placeholder="if any" name="total_discount" value="0.00" required>
    	</span><br><br>
    	<span class="sameline">
				<label class="smalllabel" style="width:100px;">Paid (in cash)</label>
				<input class="paid_amount" type="number" step="0.01" placeholder="if any" name="total_paid" value="0.00" required>
    	</span><br><br>
    	<div class="sameline">
				<label class="smalllabel" style="width:100px;">Balance</label>
				<input class="balance_amount" type="number" step="0.01" placeholder="if any" name="balance_amt" value="0.00" required readonly="readonly">
    	</div><br><br>
 		<button type="submit" style="float:right">SUBMIT</button>
 		</div>
  	</div>
  	</fieldset>
</form>



<script>

$(".qty").on("keyup", function () {
    	var $this = $(this);
		$tr = $this.closest('tr');
		qty_val = $this.val();
		unitprice_val = $tr.find('.unit_price').val();
		amount = qty_val*unitprice_val;
		$(this).closest('tr').find('.pricecalc').attr("value", amount);
		alert("Hi sum = ".$('#my_table_id tr:last'));
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
    
    $("#my_table_id").on('keyup', '.qty', function () {
       var calculated_total_sum = 0;
     	//alert("Hello	");
       $("#my_table_id .pricecalc").each(function () {
           var get_textbox_value = $(this).val();
           //alert("get textbox value = "+get_textbox_value)
           if ($.isNumeric(get_textbox_value)) {
              calculated_total_sum += parseFloat(get_textbox_value);
              }                  
        });
        $('.total_amount').val(calculated_total_sum.toFixed(2));
    });
    
    $('.paid_amount').keyup(function(){
    	//alert("hello "+$('.total_amount').val()+" "+$('.paid_amount').val()+" "+$('.total_discount').val());
    	var balance = $('.total_amount').val()-$('.paid_amount').val()-$('.total_discount').val();
    	//alert("changed paid amount, balance = "+balance);
    	$('.balance_amount').val(balance.toFixed(2));
    });
    
    $('.total_discount').keyup(function(){
    	//alert("hello "+$('.total_amount').val()+" "+$('.paid_amount').val()+" "+$('.total_discount').val());
    	var balance = $('.total_amount').val()-$('.paid_amount').val()-$('.total_discount').val();
    	//alert("changed paid amount, balance = "+balance);
    	$('.balance_amount').val(balance.toFixed(2));
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
    $('#my_table_id tr:last td:second').val("Select Category");
    $('#my_table_id tr:last td:third').val("Select Product");
    $('#my_table_id tr:last td:last').val(0.00);
});

</script>

</body>
</html>
