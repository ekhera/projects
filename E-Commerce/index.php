<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="author" >
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="diwali.css">
  <title>Shopping-Cart</title>
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
    
  </i> <div class="headi"> <b style="color: black; font-size: 26px; box-shadow: 5px 4px 9px;"><i class="fa fa-magic"></i>HandCrafted Creations</a></b>



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
<div class="hand"><b>Handmade For You ..</b></div>

<hr class="new5">
<br>

 <div class="container">
    <div id="message"></div>
    <div class="row mt-2 ">
      <?php
        include 'config.php';
        $stmt = $conn->prepare('SELECT * FROM product');
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()):
      ?>


            <div class="col-md-4 text-center" style="background-color: ; border: 2px  ;">
        <div class="">
          <div class="card " style="box-shadow: 5px 7px 8px;">
            <img src="<?= $row['product_image'] ?>" class="card-img-top" height="600" >
            <div class="card-body">
              <h4 class="card-title "><?= $row['product_name'] ?></h4>

              <h5 class="card-text"><i class="fas fa-rupee-sign"></i>&nbsp;&nbsp;<?= ($row['product_price']) ?></h5>

            </div>
          </div>

     <div class="card-footer" style="background-color: white; text-align: center;" >
      <br><br>
              <form action="" class="form-submit">
                <div class="row">
                  <div class="col py-1 text-center p-6" id="carti">
                    <b>Quantity : </b>
                    <br><br>
                  </div>
                  <div class="col text-center text-info
                   " >
                    <input type="number" style="font-size: 24px;" class="form-control pqty" value="<?= $row['product_qty'] ?>">
                  </div>
                </div>
                <input type="hidden" class="pid" value="<?= $row['id'] ?>">
                <input type="hidden" class="pname"  value="<?= $row['product_name'] ?>">
                <input type="hidden" class="pprice" value="<?= $row['product_price'] ?>">

                <input type="hidden" class="pimage" value="<?= $row['product_image'] ?>">
                
                <input type="hidden" class="pcode" value="<?= $row['product_code'] ?>">
                <button class="btn btn-info btn-block addItemBtn" style="font-size: 22px; color: white; background-color: #808080;"><b>Add to Cart</b></button> 
              </form>
            
            </div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>




<script type="text/javascript">
  $(document).ready(function() {

    // Send product details in the server
    $(".addItemBtn").click(function(e) {
      e.preventDefault();
      var $form = $(this).closest(".form-submit");
      var pid = $form.find(".pid").val();
      var pname = $form.find(".pname").val();
      var pprice = $form.find(".pprice").val();
      var pimage = $form.find(".pimage").val();
      var pcode = $form.find(".pcode").val();

      var pqty = $form.find(".pqty").val();

       $.ajax({
        url: 'action.php',
        method: 'post',
        data: {
          pid: pid,
          pname: pname,
          pprice: pprice,
          pqty: pqty,
          pimage: pimage,
          pcode: pcode
        },
        success: function(response) {
          $("#message").html(response);
          window.scrollTo(0, 0);
          load_cart_item_number();
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

















  
