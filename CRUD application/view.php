
<!DOCTYPE html>
<html>
<body>
		 <button type="submit" style="font-size: 20px; margin-top: -1px;   padding: 5px; margin-left: 62em;  background:#ffffb3;  font-family: monospace,sans-serif; "  onclick="myOn()" >Cancel </button>

		</body></html>

<!DOCTYPE html>
<html style="background-color: #f2f2f2">
<head>
<title  > VIEW TABLE</title>


<?php include('includes/header.php'); ?>

  
<style>
table {
width: 100%; color:  #9999ff; font-size: 25px;text-align: center;font-family:"ink free", monospace,sans-serif;
 }

th {
background-color:  #9999ff;
color: white;
}
tr:nth-child(even) {background-color: white;}
</style>
</head>
<body>

<table>

	
<tr>
<th>OrderNumber</th>
<th>ItemNumber</th>
<th>Description</th>
<th>Color</th>
<th>Size</th>
<th> Price</th>
</tr>
<?php
	require('config/config.php');
	require('config/db.php');


$sql = "SELECT ordernumber, itemnumber, description, size, color,price FROM records";


$result = $conn->query($sql);
if ($result -> num_rows > 0) {


while($row = $result->fetch_assoc()) {

echo "<tr><td>" . $row["ordernumber"]. "</td><td>" . $row["itemnumber"] . "</td><td>". $row["description"]. "</td><td>" . $row["color"] . "</td><td>". $row["size"] . "</td><td>".  $row["price"] . "</td></td>";
}
echo "</table>";
} 
$conn->close();
?>
</table>
<?php include('includes/footer.php'); ?>

<script>
	function myOn() {
		document.location.href="index.php";
	}

 </script>