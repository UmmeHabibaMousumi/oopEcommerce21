<?php include('include/header.php'); ?>
<?php 
     $login=Session::get("custlogin");
     if ($login==false) {
      header("Location:login.php");
     }
?>
<style>
.payment{width: 500px;min-height: 200px;text-align:center;border:1px solid #ddd;padding: 50px; margin:0 auto;}
.payment h2{ border-bottom: 1px solid #dd;margin-bottom: 10px;}
.payment a{ background:#cc2d2d none repeat scroll 0 0; border-radius: 3px;color: #fff;font-size: 25px;padding: 5px 30px;}
.back a{width: 160px;margin:5px auto 0;padding:7px 0;text-align: center;display: block;background:#555;border:1px solid #333;color:#fff;border-radius: 3px;font-size: 20px; }
</style>
 <div class="main">
    <div class="content">
       <div class="section group">
        <div class=" payment ">
          <h2>Choose Payment Option </h2>
          <a href="paymentoffline.php">Offline Payment</a>
          <a href="paymentonline.php">Online Payment</a>
        </div>
        <div class="back"><a href="cart.php">Previous</a>
        </div>
       </div>   
       <div class="clear"></div>
    </div>
 </div>
<?php include('include/footer.php'); ?>

