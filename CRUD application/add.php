<?php
  include('config/config.php');
  include('config/db.php');
    include('includes/footer.php');

  ?>

<!DOCTYPE html>
<html>
<body>
		 <button type="submit" style="font-size: 20px; margin-top: -1px; background :#ffffb3;  padding: 5px; margin-left: 62em;  font-family: monospace,sans-serif; "  onclick="clickn()" >Cancel </button>

		</body></html>

<!DOCTYPE html>
<html style="background-color: #f2f2f2;">
<head>
<title>ADD RECORDS
</title>
</head>
<body>
<?php include('includes/header.php'); 
	 include('includes/footer.php'); ?>
<br>
<form method="post" action="connect.php" style="text-align: center; margin-top: -10px;">



    <div class="wrapper" >
			

             </div>
              <form style="text-align: center;">
    
      <div class="form-field" style="font-size: 20px;  font-family: monospace,sans-serif; ">
        <label> Order Number: </label>
      </div>
      <div class="form-field">
        <input type="text"  name="ordernumber" style="font-size: 20px;" required>
      </div>
<br>

      <div class="form-field" style="font-size: 20px;font-family: monospace,sans-serif; ">
        <label for="myEmail">Item Number: </label>
      </div>
      <div class="form-field">
        <input type="text"  name="itemnumber" style="font-size: 20px; font-family: monospace,sans-serif;" required>
      </div>
      
      <br>
<div class="form-field" style="font-size: 20px; font-family: monospace,sans-serif; ">
        <label for="myEmail">Description: </label>
      </div>
      <div class="form-field">
        <input type="text"  name="description" style="font-size: 20px;" required>
      </div>
      <br>
      <div class="form-field"style="font-size: 20px; font-family: monospace,sans-serif; " >
        <label for="myEmail">Color: </label>
      </div>
      <div class="form-field">
        <input type="text"  name="color" style="font-size: 20px;" required>
      </div>

<br>

      <div class="form-field" style="font-size: 20px;  font-family: monospace,sans-serif; ">
        <label for="myEmail">Size: </label>
      </div>
      <div class="form-field" style="font-size: 20px;">
        <input type="text"  name="size" style="font-size: 20px;" required>
      </div>
            <div class="form-field" style="font-size: 20px; font-family: monospace,sans-serif; ">
      	<br>
        <label for="text" >Price: </label>
      </div>
      <div class="form-field">
        <input type="text"  name="price" style="font-size: 20px;" required>
      </div>


<br>

<input type="submit"  value="Submit"  style="font-size: 20px; background: #ffffb3; font-family: monospace,sans-serif;" onclick="my()">
</form>


<script>
	function clickn() {
		document.location.href="index.php";
	}

 </script>

 <script>
   
 function my() {
  alert("Record Added Successfully");
}

 </script>