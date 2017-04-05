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

<form action="db_add_product.php" class="subform" method="post">
	<fieldset>
	<legend style="font-size:22px">Adding a New Product:</legend>
  	<div>
  		<label class="smalllabel"><b>Product Name</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="pname" maxlength="20" required>
  	
    	<label class="smalllabel"><b>Category Name</b></label>
    	<select name="categories">
    				
    	<?php 
		include 'connect_my_sql_db.php';
		$qry = "SELECT cat_name FROM category;";

		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_row($res)){
			echo ("<option value='$data[0]'>$data[0]</option>");
		}

		?>
		
		
		<!-- <script type="text/javascript"
    				src="jquery-ui-1.10.0/tests/jquery-1.9.0.js"></script>
			<script src="jquery-ui-1.10.0/ui/jquery-ui.js"></script>
			<script>    
				$('#dbType').change(function(){

   				selection = $('this').value();
   				switch(selection)
   				{
       				case 'Hose Pipe':
       					alert("Please be careful");
           				document.findElementById("prodName").value = 'Hose Pipe';
           				break;
       				case 'default':
           				document.findElementById("prodName").value = 'Other';
           				break;
   				}
			});
			</script> -->
		
		
		
  		</select>
  		<br><br>
  		
  		<label class="smalllabel"><b>Stock</b></label>
    	<input class="smallinput" type="number" step="0.01" placeholder="enter a number" name="pstock" required>
    	
    	<label class="smalllabel"><b>Unit Cost Price</b></label>
    	<input class="smallinput" type="number" step="0.01" placeholder="ex: 56.50" name="punitcostprice" required>
    	
    	<label class="smalllabel"><b>Unit Sale Price</b></label>
    	<input class="smallinput" type="number" step="0.01" placeholder="ex: 56.50" name="punitsaleprice" required>
    	
    	<label class="smalllabel"><b>Product Details</b></label>
    	<!-- <input class="largeinput" type="text" placeholder="" name="pdetails" max-length="50"> -->
    	<textarea class="largeinput" name="pdetails" placeholder="max 50 chars" cols="40" rows="5" maxlength="50"></textarea>
    	
        <button type="submit">SUBMIT</button>
  	</div>
  	</fieldset>
</form>


</body>
</html>
