<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="UTF-8">
  <meta name="author">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="diwali.css">
  <title>Cart</title>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css' />
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css'/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body >
  

  <nav class="navbar navbar-light">
  <!-- Brand -->
  <a class="navbar-brand" href="index.php">


<i class="fa fa-star-o" style="font-size:12px; color: black;"></i>
      <i class="fa fa-star-o" style="font-size:15px; color: black;"></i>
<i class="fa fa-star-o" style="font-size:18px; color: black;"></i>
<i class="fa fa-star-o" style="font-size:24px; color: black;"></i>
<i class="fa fa-star-o" style="font-size:28px; color: black;"></i>
    
  </i> <div class="navbar-nav ml-auto" id="heado"><b style="color: black; font-size: 26px;box-shadow: 5px 5px 8px;"><i class="fa fa-magic"></i>HandCrafted Creations</a></b>
  </div>





    <!-- Toggler/collapsibe Button -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <!-- Navbar links -->
    <div class="collapse navbar-collapse" style="color: black;" id="collapsibleNavbar">
      <ul class="navbar-nav" style="color: black;">
        <li class="nav-item">
          <a class="nav-link active" style="color: black; size: 22px;" href="index.php"></i>Paintings</a>
        </li>

       
           <li class="nav-item">
        <a class="hmbgr" href="cart.php"  onclick="toggleNavBar()"><i style="font-size:30px;"></i></a>
          
        </li>
        <li class="nav-item">
          <a style ="color: black;" href="checkout.php">Checkout</a>
        </li>

        <li class="nav-item">
    <a class="nav-link" href="cart.php"  onclick="toggleNavBar()"><i class="fa fa-shopping-cart" style="font-size:30px; color: black;"></i><span id="cart-item"   class="badge badge-danger">1</span></a>
          
        </li>
      </ul>
    </div>
  </nav>


  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div style="display:<?php if (isset($_SESSION['showAlert'])) {
  echo $_SESSION['showAlert'];
} else {
  echo 'none';
} unset($_SESSION['showAlert']); ?>" class="alert alert-success alert-dismissible mt-3">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><?php if (isset($_SESSION['message'])) {
  echo $_SESSION['message'];
} unset($_SESSION['showAlert']); ?></strong>
        </div>
        <div class="table-responsive mt-2">
          <table class="table table-bordered table-striped text-center">
            <thead>
              <tr>
                <td colspan="8" >
                 <h4 style="color: black; font-size: 28px;"><b>Paint Selected!</b></h4>
                </td>
              </tr>
              <tr>
                <th style="font-size: 24px;" >ID</th>
                <th  style="font-size: 24px;" >Image</th>
                <th  style="font-size: 24px;">Painting</th>
                <th  style="font-size: 24px;" >Price</th>
                <th style="font-size: 24px;">Quantity</th>
                
                <th>
                  <a href="action.php?clear=all" class="badge-danger badge p-2" style="font-size: 22px;" onclick="return confirm('Are you sure want to clear your cart?');"><i class="fas fa-trash"></i>&nbsp;&nbsp;Clear Cart</a>
                </th>
              </tr>
            </thead>
            <tbody  style="font-size: 24px; font-weight: bold;">
              <?php
                require 'config.php';
                $stmt = $conn->prepare('SELECT * FROM cart');
                $stmt->execute();
                $result = $stmt->get_result();
               
                while ($row = $result->fetch_assoc()):
              ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <input type="hidden" class="pid" style="font-size: 2px;" value="<?= $row['id'] ?>">
                <td><img src="<?= $row['product_image'] ?>" width="140"></td>
                <td><?= $row['product_name'] ?></td>
                <td>
                  </i>&nbsp;&nbsp;<?= ($row['product_price']); ?>
                </td>
              
                <td >
                  <input type="number" class="form-control itemQty" value="<?= $row['qty'] ?>" style="width:75pxfont-size: 24px;">
                </td>
               
                <td>
                  <a href="action.php?remove=<?= $row['id'] ?>" class="text-danger lead" onclick="return confirm('Are you sure want to remove this item?');"><i class="fas fa-trash-alt"></i></a>
                </td>
              </tr>
              

              <?php endwhile; ?>
              <tr>
                <td colspan="8" style="background-color: white;background-color: ; box-shadow: 8px 2px 8px;">
                  <a href="index.php" style="text-align: center; background-color: ;" class=""><i class="fas fa-cart-plus" style="text-align: center; font-size: 27px;"></i>&nbsp;&nbsp;<b>Continue
                    Shopping</b></a>
                </td>
                
                
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // Change the item quantity
    $(".itemQty").on('change', function() {
      var $el = $(this).closest('tr');

      var pid = $el.find(".pid").val();
      var pprice = $el.find(".pprice").val();
      var qty = $el.find(".itemQty").val();
      location.reload(true);
      $.ajax({
        url: 'action.php',
        method: 'post',
        cache: false,
        data: {
          qty: qty,
          pid: pid,
          pprice: pprice
        },
        success: function(response) {
          console.log(response);
        }
      });
    });

    // Load total no.of items added in the cart and display in the navbar
    load_cart_item_number();

    function load_cart_item_number() {
      $.ajax({
        url: 'action.php',
        method: 'get',
        data: {
          cartItem: "cart_item"
        },
        success: function(response) {
          $("#cart-item").html(response);
        }
      });
    }
  });
  </script>
 

<br>
<br><br><br><br><br><br><br><br>

<footer>
  <div class="footer" style="margin-top:-2px;">
    <hr class="foot">
      &COPY; HandCrafted Creations<br>
       Contact us : <br>
      <a href="mailto:ekhera@hccfl.edu">ekhera@hawkmail.hccfl.edu</a><br>
  
      
 <span id="mobile"><a href="tel:1813-898-3910">
     <i class="fa fa-phone"></i> 1813-898-3910</a></span>
<span id="desktop"></span>

 
   
  </footer>




</body>

</html>