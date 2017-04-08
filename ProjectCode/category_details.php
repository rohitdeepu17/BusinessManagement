<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
$catid = $_GET['catid'];
$catname = null;
$catdetails = null;

$qry = "SELECT * FROM category WHERE cat_id=".$_GET['catid'];

		$res = mysqli_query($conn, $qry);
		while($data = mysqli_fetch_assoc($res)){
			$catname = $data['cat_name'];
			$catdetails = $data['cat_details'];
		}

?>

<!DOCTYPE html>
<html>
<style>
</style>
<body>
<link href="css/my_file.css" rel="stylesheet" type="text/css" />

<nav id="navMenu" class="sidenav"></nav>
<script src="nav_script.js"></script>

<script>
function goBack(){
	window.history.back();
}
</script>

<form action="<?php echo 'db_update_category.php';?>" class="subform" method="post">
	<fieldset>
	<legend style="font-size:22px">Adding a New Category of Products:</legend>
  	<div>
  		<label class="smalllabel"><b>Category Id</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="cid" maxlength="20" value="<?php echo $catid;?>" readonly="readonly" required>
    	
    	<label class="smalllabel"><b>Category Name</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="cname" maxlength="20" value="<?php echo $catname;?>" required>

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
