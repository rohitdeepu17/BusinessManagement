<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
$prodid = $_GET['prodid'];
$prodname = null;
$proddetails = null;
$prodstock = null;
$produnitsaleprice = null;
$produnitcostprice = null;
$prodcat = null;
$qry = "SELECT * FROM product WHERE prod_id=".$prodid;

$res = mysqli_query($conn, $qry);
while($data = mysqli_fetch_assoc($res)){
	$prodname = $data['prod_name'];
	$proddetails = $data['prod_details'];
	$prodstock = $data['stock'];
	$produnitsaleprice = $data['unit_sale_price'];
	$produnitcostprice = $data['unit_cost_price'];
	$prodcat = $data['cat_name'];
}

?>


<!DOCTYPE html>
<html>
<style>
</style>
<body>
<link href="css/my_file1.css" rel="stylesheet" type="text/css" />

<nav id="navMenu" class="sidenav"></nav>
<script src="nav_script.js"></script>
<script>
function goBack(){
	window.history.back();
}
</script>

<form action="db_update_product.php" class="subform" method="post">
	<fieldset>
	<legend style="font-size:22px">Update a Product:</legend>
  	<div>
  		<label class="smalllabel"><b>Product Id</b></label>
    	<input class="smallinputreadonly" type="text" placeholder="max 20 chars" name="pid" maxlength="20" value="<?php echo $prodid;?>" readonly="readonly" required>
  	
  		<label class="smalllabel"><b>Product Name</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="pname" maxlength="20" value="<?php echo $prodname;?>" required>
  	
    	<label class="smalllabel"><b>Category Name</b></label>
    	<select name="categories">
    				
    	<?php 
		include 'connect_my_sql_db.php';
		$qry = "SELECT cat_name FROM category;";

		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_row($res)){
			if(!strcmp($prodcat, $data[0]))
				echo ("<option value='$data[0]' selected>$data[0]</option>");
			else
				echo ("<option value='$data[0]'>$data[0]</option>");
		}
		?>
		
  		</select>
  		<br><br>
  		
  		<label class="smalllabel"><b>Stock</b></label>
    	<input class="smallinput" type="number" step="0.01" placeholder="enter a number" name="pstock" value="<?php echo $prodstock;?>" required>
    	
    	<label class="smalllabel"><b>Unit Cost Price</b></label>
    	<input class="smallinput" type="number" step="0.01" placeholder="ex: 56.50" name="punitcostprice" value="<?php echo $produnitcostprice;?>" required>
    	
    	<label class="smalllabel"><b>Unit Sale Price</b></label>
    	<input class="smallinput" type="number" step="0.01" placeholder="ex: 56.50" name="punitsaleprice" value="<?php echo $produnitsaleprice;?>" required>
    	
    	<label class="smalllabel"><b>Product Details</b></label>
    	<!-- <input class="largeinput" type="text" placeholder="" name="pdetails" max-length="50"> -->
    	<textarea class="largeinput" name="pdetails" placeholder="max 50 chars" cols="40" rows="5" maxlength="50"><?php echo $proddetails;?></textarea>
    	
    	<button onclick="goBack()">BACK</button>
        <button type="submit">SUBMIT</button>
  	</div>
  	</fieldset>
</form>


</body>
</html>
