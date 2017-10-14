<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
$catid = $_GET['catid'];
$catname = null;
$catdetails = null;
$cathsncode = null;
$catsgst = null;
$catcgst = null;

$qry = "SELECT * FROM category WHERE cat_id=".$_GET['catid'];

		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_assoc($res)){
			$catname = $data['cat_name'];
			$catdetails = $data['cat_details'];
			$cathsncode = $data['cat_hsn_code'];
			$catsgst = $data['cat_sgst'];
			$catcgst = $data['cat_cgst'];
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

<form action="<?php echo 'db_update_category.php';?>" class="subform" method="post">
	<fieldset>
	<legend style="font-size:22px">Update a New Category of Products:</legend>
  	<div>
  		<label class="smalllabel"><b>Category Id</b></label>
    	<input class="smallinputreadonly" type="text" placeholder="max 20 chars" name="cid" maxlength="20" value="<?php echo $catid;?>" readonly="readonly" required>
    	
    	<label class="smalllabel"><b>Category Name</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="cname" maxlength="20" value="<?php echo $catname;?>" required>
    	
    	<label class="smalllabel"><b>HSN Code</b></label>
    	<input class="smallinput" type="text" placeholder="max 8 chars" name="hsncode" maxlength="8" value="<?php echo $cathsncode;?>" required>
    	
    	<label class="smalllabel"><b>SGST</b></label>
    	<input class="smallinput" type="number" step="0.01" placeholder="ex: 56.50" name="sgst" value="<?php echo $catsgst;?>" required>
    	
    	<label class="smalllabel"><b>CGST</b></label>
    	<input class="smallinput" type="number" step="0.01" placeholder="ex: 56.50" name="cgst" value="<?php echo $catcgst;?>" required>

    	<label class="smalllabel"><b>Category Details</b></label>
    	<!-- <input class="largeinput" type="text" placeholder="" name="cdetails" max-length="50"> -->
    	<textarea class="largeinput" name="cdetails" placeholder="max 50 chars" cols="40" rows="5" maxlength="50"><?php echo $catdetails;?></textarea>
    	<button onclick="goBack()">BACK</button>
        <button type="submit">UPDATE</button>
  	</div>
  	</fieldset>
</form>


</body>
</html>
