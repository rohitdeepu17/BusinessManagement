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

<form action="db_add_bill.php" class="subform" method="post" id="submit_form_id">
	<fieldset>
	<legend style="font-size:22px">Creating an Invoice:</legend>
  	<div>
  		<div class="sameline">
  			<label class="smalllabel"><b>Customer ID :</b></label>
    		<input class="smallinput" type="text" placeholder="max 20 chars" name="cid" maxlength="20" value="N.A"disabled required>
    	
  			<label class="smalllabel"><b>Customer Name</b></label>
    		<input class="smallinput" type="text" placeholder="max 20 chars" name="cname" maxlength="20" list="suggestions" required>
			<datalist id="suggestions">
				<?php 
					include 'connect_my_sql_db.php';
					$qry = "SELECT cust_id, cust_name, father_name FROM customer;";

					$res = mysqli_query($conn, $qry);
					while($data = mysqli_fetch_assoc($res)){
				?>
					<option value="<?php echo $data['cust_name'];?>" data-father="<?php echo $data['father_name'] ?>" data-id="<?php echo $data['cust_id'] ?>"><?php echo $data['father_name'];?></option>
				<?php
					}
					mysqli_free_result($res);
				?>
			</datalist>
	
    		<label class="smalllabel"><b>Fathers Name</b></label>
    		<input class="smallinput" type="text" placeholder="max 20 chars" name="fname" maxlength="20" required>
    	</div>
    	
    	<div class="sameline">
    		<label class="smalllabel"><b>Address</b></label>
    		<input class="smallinput" type="text" placeholder="village name only" name="caddress" maxlength="20" required>
    	
    		<label class="smalllabel"><b>Contact</b></label>
    		<input class="smallinput" type="number" placeholder="phone" name="cphone" required>
    	
    		<label class="smalllabel"><b>Other Details</b></label>
    		<!-- <input class="largeinput" type="text" placeholder="" name="cdetails" max-length="50"> -->
    		<textarea class="largeinput" name="cdetails" placeholder="ex : Complete address, C/O, alternate contact number, etc. max 50 chars" cols="40" rows="5" maxlength="50"></textarea>
    	</div>
    	
    	<label class="smalllabel"><b>Invoice Date</b></label>
    	<input class="smallinput" type="date" name="bdate" required>
    	
    	<table id="billitems" name="billitems">
    		<tr>
       			<td>Sr. No.</td>
       			<td>Category</td>
       			<td>Product</td>
       			<td>Quantity</td>
       			<td>Unit Price</td>
       			<td>Price</td>
    		</tr>
    		
    		<tr class="billrowdata">
       			<td>1.</td>
       			<td><!--<select name="categories[]" id="category_select_id" onChange="getProduct(this.value);">-->
       			<select name="categories[]" class="category_select_id">
       				<option value="Select Category">Select Category</option>		
    				<?php 
						include 'connect_my_sql_db.php';
						$qry = "SELECT cat_id, cat_name FROM category;";

						$res = mysqli_query($conn, $qry);
						while($data = mysqli_fetch_row($res)){
						echo ("<option value='$data[1]'>$data[1]</option>");
					}
					?></td>
       			<td><select name="products[]" class="product_list">
       				<option value="Select Product">Select Product</option>
					</td>
				<script src="https://code.jquery.com/jquery-2.1.1.min.js" type="text/javascript"></script>
				<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>

				<script>
					/*$(function() {
          				// When your year changes...
          				$(document).on('change','#category_select_id',function() {
          					//alert("Hi");
          					var $curRow = $(this).find('#category_select_id').closest('tr');
          					if($curRow)
          						alert("Found sidenave in current"+$(this).find('#category_select_id').value);
          					else
          						alert("couldn't find sidenav in current"+$(this).find('#category_select_id').value);
          					$.ajax({
							type: "POST",
							url: "get_products.php",
							data:'cat_name='+$curRow.find('#category_select_id').value,
							success: function(data){
								$curRow.find$("#product-list").html(data);
								//$("#product-list").html(data);
							}
							});
          				});
        			});*/
					
					
				
					$(document).ready(function(){
						$('.category_select_id').change(function(){
							//alert("Hi"+$(this).closest('tr').find('.category_select_id').val());
							var valCat = $(this).closest('tr').find('.category_select_id').val();
							alert("Hi,..."+valCat);
							var curRowProduct = $(this).closest('tr').find(".product_list");
							$.ajax({
								type: "POST",
								url: "get_products.php",
								data:'cat_name='+valCat,
								success: function(data){
									//alert("Success ajax call"+data);
									//alert("Success ajax call"+$(this).closest('tr').find(".product_list").val());
									//$(this).closest('tr').find(".product_list").html(data);
									curRowProduct.html(data);
									//$("#product-list").html(data);
								}
							});
						})
					});
					
					
					
					
					$(function() {
          // When you add a new user
          $("#addRows").click(function(){
            debugger;
            
            // Determine the next users number
            var nextUser = $('.billrowdata').length + 1;
            alert("Hi"+nextUser);
            // Clone the first row
            var nextUserRow = $('#billitems tr:last').clone();
            // Update your attributes
            /*$(nextUserRow).find('.person-number').text(nextUser + ':');
            $(nextUserRow).find('.person-year').attr('name','Year' + nextUser).val('');
            $(nextUserRow).find('.person-value').attr('name','Results' + nextUser);
            $(nextUserRow).find('.person-additional').attr('name','Additional' + nextUser);
            // Set the defaults for the row
            $(nextUserRow).find('select option:not(:first)').each(function() {
                var valueToUse = $(this).attr('data-over-18');
                $(this).val(valueToUse).text(valueToUse + '.-');
            });*/
            // Append the row
            $("#billitems").append(nextUserRow);
          });
        });

					
				
				
				
				
				
					/*function getProduct(val) {
					
						$.ajax({
						type: "POST",
						url: "get_products.php",
						data:'cat_name='+val,
						success: function(data){
							//$(this).closest('tr').find$(".product-list").html(data);
							$("#product-list").html(data);
						}
						});
					}
					
					function updatePrice(val) {
						document.getElementById("calculated-price").value = Math.round(document.getElementById("qty").value*document.getElementById("unit-price").value*100)/100;
					//var $tr = $(this).closest('tr');
					//$tr.find('#calculated-price').value = Math.round($tr.find("#qty").value*$tr.find("#unit-price").value*100)/100;
					}
					
					function cloneRow() {
						var row = document.getElementById("billrowdata"); // find row to copy
						var table = document.getElementById("billitems"); // find table to append to
						var clone = row.cloneNode(true); // copy children too
						//var clone = row.clone(); // copy children too
						//clone.id = "newID"; // change id or other attributes/contents
						//table.appendChild(clone); // add new row to end of table
						table.append(clone); // add new row to end of table
						
						//changing serial number
						var numRows = table.rows.length;
						table.rows[numRows-1].cells[0].innerHTML = ""+(numRows-1)+".";
					}*/
					
				</script>

       			<td class="qty"><input type="number" step="0.01" placeholder="ex: 12.50" name="qty[]" value="0.00" required onkeyup="updatePrice(this.value)"></td>
       			<td class="unit-price"><input type="number" step="0.01" placeholder="ex: 56.50" name="unitprice[]" value="0.00" required onkeyup="updatePrice(this.value)"></td>
       			<td class="price"><input type="number" step="0.01" placeholder="will be calculated" name="calculatedprice[]" value="0.00" disabled required></td>
    		</tr>
 		</table>
 		<p>
    		<input type="button" value="+ Add Item" id="addRows" onclick="cloneRow()"/>
  		</p>
        <button type="submit">SUBMIT</button>
  	</div>
  	</fieldset>
</form>


</body>
</html>
