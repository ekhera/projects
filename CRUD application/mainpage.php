<!DOCTYPE html>
<html style="background-color: #f2f2f2;">

<title>Main Page</title>

</html>


<?php
	include('config/config.php');
	include('config/db.php');


?>
<?php include('includes/header.php'); ?>

<!DOCTYPE html>
<html style="background-color: #f2f2f2;">



<body>
	<div style="text-align: center;">
	 <button type="submit" style="font-size: 20px; margin-top: 200px;  background:#ffffb3;  font-family: monospace,sans-serif; padding: 6px; "  onclick="myOnClickFn()" > View </button>
	 <button type="submit" style="font-size: 20px; background:#ffffb3; font-family: monospace,sans-serif; padding: 6px; " onclick="myOnClick()" > Add </button>
     <button type="submit" style="font-size: 20px; background:#ffffb3;  font-family: monospace,sans-serif; padding: 6px;    " onclick="myOnClic()" > Delete</button>
</div>
</body>

</html>


<script>
	function myOnClickFn() {
		document.location.href="view.php";
	}

 </script>

 <script>
	function myOnClick() {
		document.location.href="add.php";
		// body...
	}

 </script>

 <script>
	function myOnClic() {
		document.location.href="delete.php";
		// body...
	}

 </script>




