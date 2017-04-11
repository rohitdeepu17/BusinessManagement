<?php
include 'session_check_common.php';
include 'connect_my_sql_db.php';
?>

<!DOCTYPE html>
<html>
<style>
</style>
<body>
<link href="css/my_file1.css" rel="stylesheet" type="text/css" />

<nav id="navMenu" class="sidenav"></nav>
<script src="nav_script.js"></script>

<form action="<?php echo 'db_add_category.php';?>" class="subform" method="post">
	<fieldset>
	<legend style="font-size:22px">Adding a New Category of Products:</legend>
  	<div>
    	<label class="smalllabel"><b>Category Name</b></label>
    	<input class="smallinput" type="text" placeholder="max 20 chars" name="cname" maxlength="20" required>

    	<label class="smalllabel"><b>Category Details</b></label>
    	<!-- <input class="largeinput" type="text" placeholder="" name="cdetails" max-length="50"> -->
    	<textarea class="largeinput" name="cdetails" placeholder="max 50 chars" cols="40" rows="5" maxlength="50"></textarea>
        <button type="submit">SUBMIT</button>
  	</div>
  	</fieldset>
</form>


</body>
</html>
