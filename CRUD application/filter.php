<DOCTYPE html>
<html style="background-color: #f2f2f2">
<title> Filter Records</title>
<body>

         <button type="submit" style="font-size: 20px; margin-top: -1px;   padding: 5px; margin-left: 62em;  background:#ffffb3;  font-family: monospace,sans-serif; "  onclick="mn()" >Cancel </button>

        </body></html>

<!DOCTYPE html>
<style>
table {
width: 100%; color:  #9999ff; font-size: 25px;text-align: center;font-family: monospace,sans-serif;
 }

th {
background-color:  #9999ff;
color: white;
}
tr:nth-child(even) {background-color: white;}

</style>
</head>
<body>






</body>
</html>


<?php
  require('config/config.php');
  require('config/db.php');
                                    //Solution code by Dr Majchrzak,edited by me.//
  if (isset($_POST['submit']))  { 
    $color = $_POST['opt']; 
  } else {
    $color = "";
  }

  // Create Query 
  if ($color == "all") {
    $query = "SELECT * FROM records ORDER BY orderNumber";
  } else {
    $query = "SELECT * FROM records WHERE color = '" . $color . "' ORDER BY orderNumber;";
  }
  //echo $query;

  // Get Result
  $result = mysqli_query($conn, $query);

  // Fetch Data
  $records = mysqli_fetch_all($result, MYSQLI_ASSOC);
  //var_dump($records);
  $totRecs = count($records);

  // Free Result
  mysqli_free_result($result);

  // Close Connection
  mysqli_close($conn);
?>
  
<?php include('includes/header.php'); ?>
  <div class="container">
    <div class="well">
    
    </div>
    
    <div class="well" style="text-align: center; font-size: 25px; color: #9999ff;"> 
      <form action="<?php echo $_SERVER['PHP_SELF'];  ?>" method="post">
       <label for="opt">Color:       </label>
        <select class="btn btn-default" name="opt" id="opt" style="background-color: whitesmoke; font-weight: bold;" >
           
          <option>
            Select Option</option>
          <option<?php if($color=="black") {echo " selected";} ?>>
            Black</option>
          <option<?php if($color=="green") {echo " selected";} ?>>
            Green</option>
          <option<?php if($color=="orange") {echo " selected";} ?>>
            Orange</option>
          <option<?php if($color=="purple") {echo " selected";} ?>>
            Purple</option>
          <option<?php if($color=="white") {echo " selected";} ?>>
            White</option>
          <option<?php if($color=="yellow") {echo " selected";} ?>>
            Yellow</option>

        </select>
        <input class="btn btn-default" type="submit" name="submit" value="Filter">
        <?php echo $totRecs; ?> records
    
      </form>
    </div>
    <table>
    
    <div class="well"> 
     <div class="grid-container">
        <table>
        <tr>
        <td><div class="grid-item">Order Number</td>
        <td><div class="grid-item">Item Number</div> </td>
        <td><div class="grid-item">Description</div></td>
       <td> <div class="grid-item">Size</div></td>
       <td> <div class="grid-item">Color</div></td>
       <td> <div class="grid-item">Price</div></td>
    </tr>
       
        <?php $cnt = 0; ?>
        <?php foreach ($records as $record) : ?>
         <?php if ($cnt<500) : ?>
          
            <tr>
         <td> <div class="grid-item"><?php echo $record['ordernumber']; ?></div> </td>
        <td>  <div class="grid-item"><?php echo $record['itemnumber']; ?></div> </td>
         <td> <div class="grid-item"><?php echo $record['description']; ?></div></td>
         <td> <div class="grid-item"><?php echo $record['size']; ?></div></td>
         <td> <div class="grid-item"><?php echo $record['color']; ?></div></td>
          <td><div class="grid-item"><?php echo $record['price']; ?></div></td>
      </tr>
  
         <?php endif; ?>
         <?php $cnt++; ?>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</table>
<?php include('includes/footer.php'); ?>




<script>
    function mn() {
        document.location.href="index.php";
    }

 </script>















