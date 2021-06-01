
<?php include('includes/header.php'); ?>
<!DOCTYPE html>
<html style="background-color: #f2f2f2;">

<title>Main Page</title>

</html>


<?php
	include('config/config.php');
	include('config/db.php');
    include('includes/footer.php');


$ordernumber = filter_input(INPUT_POST, 'ordernumber');
$itemnumber = filter_input(INPUT_POST, 'itemnumber');
$description = filter_input(INPUT_POST, 'description');
$color = filter_input(INPUT_POST, 'color');
$size = filter_input(INPUT_POST, 'size');
$price= filter_input(INPUT_POST, 'price');



$sql = "INSERT INTO records (ordernumber, itemnumber,description, color, size, price)
values ('$ordernumber','$itemnumber','$description','$color','$size','$price')";

if ($conn->query($sql)){
echo "";
}


$conn->close();

?>


<!DOCTYPE html>
<html style="background-color: #f2f2f2;">



<body>

	<div id="container" style="text-align: center; color: white;  background-color: #9999ff; box-shadow: 8px 8px 8px 8px #ffff80; margin-left: 250px; margin-right: 250px; margin-top: 60px; font-family: monospace, sans-serif;  " >
    <br>
	<div style="text-align: center;">
		<button type="submit" style="font-size: 20px; background:#ffffb3;  font-family: monospace,sans-serif; padding: 6px;    " onclick="ic()" > Filter</button>
	 <button type="submit" style="font-size: 20px; margin-top: 20px;  background:#ffffb3;  font-family: monospace,sans-serif; padding: 6px; "  onclick="myOnClickFn()" > View </button>
	 <button type="submit" style="font-size: 20px; background:#ffffb3; font-family: monospace,sans-serif; padding: 6px; " onclick="myOnClick()" > Add </button>
     <button type="submit" style="font-size: 20px; background:#ffffb3;  font-family: monospace,sans-serif; padding: 6px;    " onclick="myOnClic()" > Delete</button>

<br><br>
<?php include('includes/footer.php'); ?>


<script>
	function myOnClickFn() {
		document.location.href="view.php";
	}

 </script>

 <script>
	function myOnClick() {
		document.location.href="index.php";
		// body...
	}

 </script>

 <script>
	function myOnClic() {
		document.location.href="delete.php";
		// body...
	}

 </script>



<script>
	function ic() {
		document.location.href="filter.php";
		// body...
	}

 </script>
