<!DOCTYPE html>
<html>
<body>
         <button type="submit" style="font-size: 20px; margin-top: -1px; background :#ffffb3;  padding: 5px; margin-left: 62em;  font-family: monospace,sans-serif; "  onclick="cl()" >Cancel </button>

        </body></html>



<!DOCTYPE html>
<html style="background-color: #f2f2f2;">
<head>
<title>DELETE RECORD
</title>
</head>
<body>
</body></html>

<?php

include('includes/header.php');
include('config/config.php');

$ordernumber = "";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);


try{
    $connect = mysqli_connect($host, $user, $password, $database);
} catch (mysqli_sql_exception $ex) {
    echo 'Error';
}

// get values from the form
function getPosts()
{
    $posts = array();
    $posts[0] = $_POST['ordernumber'];
   
    return $posts;
}



if(isset($_POST['delete']))
{
    $data = getPosts();
    $delete_Query = "DELETE FROM `records` WHERE `ordernumber` = $data[0]";
    try{
        $delete_Result = mysqli_query($connect, $delete_Query);
        
        
    } catch (Exception $exe) {
        echo 'Error '.$exe->getMessage();
    }

}

?>


<!DOCTYPE Html>
<html style="background-color: #f2f2f2;">   

        <title>DELETE</title>

    <body>
        <form action="" method="post" style="text-align: center; margin-top: 12em;">

            <form style="text-align: center; margin-top: 30px;">
    
      <div class="form-field" style="font-size: 30px; margin-top: 100px;font-family: monospace,sans-serif;">
        <label> Order Number: </label>
      </div>
      <br>

<div class="form-field">
        <input type="text"  name="ordernumber" style="font-size: 20px;" required value="<?php echo $ordernumber;?>"> 
        <br><br>
            
      </div>

      <br>
      <input type="submit"  value="Delete" name="delete" style="font-size: 20px; background: #ffffb3; font-family: monospace,sans-serif;" onclick="myal()">

           
           
            
        </form>
    
<?php include('includes/footer.php'); ?>

<script>
    function cl() {
        document.location.href="index.php";
    }

 </script>

 <script>
 function myal() {
  alert("Record Deleted Successfully");
}
</script>