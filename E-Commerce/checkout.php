<?php
  require 'config.php';

  $grand_total = 0;
  $allItems = '';
  $items = [];

  $sql = "SELECT CONCAT(product_name, '(',qty,')') AS ItemQty, total_price FROM cart";
  $stmt = $conn->prepare($sql);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    
    $items[] = $row['ItemQty'];
  }
  $allItems = implode(', ', $items);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="author" content="Elisha">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="diwali.css">
  <title>Shopping Cart</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

</head>



<body>
  

  <nav class="navbar  navbar-light">
  <!-- Brand -->
  <a class="navbar-brand" href="index.php">



    
      <i class="fa fa-star-o" style="font-size:12px; color: black;"></i>
      <i class="fa fa-star-o" style="font-size:15px; color: black;"></i>
<i class="fa fa-star-o" style="font-size:18px; color: black;"></i>
<i class="fa fa-star-o" style="font-size:24px; color: black;"></i>
<i class="fa fa-star-o" style="font-size:28px; color: black;"></i>
    
  </i> <div class="headi"> <b style="color: black; font-size: 26px; box-shadow: 5px 5px 8px;"><i class="fa fa-magic"></i>HandCrafted Creations</a></b>



  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler"  type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
</div>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse"  style="color: black;"  id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto" style="color: black;">
      <li class="nav-item">
        <a class="nav-link active" style="color: black;" href="index.php"><b>Paintings</a></b>
      </li>

      <li class="nav-item">
        <a class="hmbgr" href="cart.php"  onclick="toggleNavBar()"><i style="font-size:30px;"></i></a>
      

      <li class="nav-item">
        <a style="color: black;" href="checkout.php"><b>Checkout</a></b>
      </li>
       <li class="nav-item">
        <a class="nav-link" href="cart.php"  onclick="toggleNavBar()"><i class="fa fa-shopping-cart" style="font-size:30px; color: black;"></i><span id="cart-item"   class="badge badge-danger">1</span></a>
    </ul>
  </div>
</nav>


  <div class="container" id="cont" >
    <div class="row justify-content-center">
      <div class="col-lg-6 px-4 " id="order">

        <h4 class="text-center"style="font-size: 34px;"><b>Complete your order!</b></h4>
        <div class=" text-center">

          <h6 class="lead" id="mode"  style="font-size: 30px;"><b>Paintings Selected(s) : </b><?= $allItems; ?></h6>
          <h6 class="lead" id="mode" style="font-size: 30px;"><b>Delivery Charge : Free</b></h6>
          
        </div>
        <form action="" method="post" id="placeOrder">
          <input type="hidden" name="products" value="<?= $allItems; ?>">
          <input type="hidden" name="grand_total" value="<?= $grand_total; ?>">
          <div class="form-group" >
            <input type="text" name="name" style="font-size: 24px;color: black;" 
            class="form-control" placeholder="Enter Name" required>
          </div>
          <div class="form-group">
            <input type="email" name="email" style="font-size: 24px;color: black;" style="font-size: 24px;color: black;" class="form-control" placeholder="Enter E-Mail" required>
          </div>
          <div class="form-group">
            <input type="tel" name="phone" style="font-size: 24px;color: black;" class="form-control" placeholder="Enter Phone" required>
          </div>
          <div class="form-group">
            <textarea name="address" style="font-size: 24px;color: black;"  class="form-control" rows="3" cols="10" placeholder="Enter Delivery Address Here..."></textarea>
          </div>
          <h6 class="text-center lead" id="mode"  style="font-size: 30px;"><b>Select Payment Mode</b></h6>

          <div class="form-group">
            <select name="pmode" class="form-control"style="font-size: 30px;">>
              <option value="" selected disabled>-Select Payment Mode-</option>
              <option value="cod"style="font-size: 30px;">Cash On Delivery</option>
              
              <option value="cards"style="font-size: 30px;">Debit/Credit Card</option>
            </select>
          </div>

          <div class="form-group">
            <input type="submit" name="submit" value="Place Order" class="btn btn-danger btn-block"style="font-size: 30px;">
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/js/bootstrap.min.js'></script>

  <script type="text/javascript">
  $(document).ready(function() {

    // Send form data to the server
    $("#placeOrder").submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: 'action.php',
        method: 'post',
        data: $('form').serialize() + "&action=order",
        success: function(response) {
          $("#order").html(response);
        }
      });
    });

    // It will load total no.of items added in the cart and display in the navbar
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
  <br><br>

<footer>
  <div class="footer">
    <hr class="foot">
      &COPY; HandCrafted Creations<br><br>
       Contact us : <br>
      <a href="mailto:ekhera@hccfl.edu">ekhera@hawkmail.hccfl.edu</a><br>
  </div>
      
 <span id="mobile"><a href="tel:1813-898-3910">
     <i class="fa fa-phone"></i> 1813-898-3910</a></span>
<span id="desktop"></span>

 
   
  </footer>



</body>

</html>