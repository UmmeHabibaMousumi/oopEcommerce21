<?php include('include/header.php'); ?>
<?php 
     $login=Session::get("custlogin");
     if ($login==false) {
      header("Location:login.php");
     }
?>
<style>
.psuccess{width: 500px;min-height: 200px;text-align:center;border:1px solid #ddd;padding:20px; margin:0 auto;}
.psuccess h2{ border-bottom: 1px solid #ddd;margin-bottom: 10px;
padding-bottom:20px;}
.psuccess p{line-height:25px;font-size:18px;text-align:left;}
</style>
 <div class="main">
    <div class="content">
       <div class="section group">
        <div class="psuccess ">
          <h2>Success </h2>
          <?php 
           $customer_id=Session::get("custId");
           $amount=$cart->payableAmount($customer_id);
           if ($amount){
               $sum = 0;
             while($result=$amount->fetch_assoc()) {
               $price=$result['price'];
               $sum=$sum+$price;

                }
              }
           ?>
          <p style="color:#ca641d;">Total Payable Ammount(Including Vat) : $
           <?php

             $vat =  $sum * 0.1;
             $total =  $sum + $vat; 
             echo $total;
           ?>
          </p>

          <p>Thanks For Purchase. Receive Your Order Successfully.We will contact you as soon as possible with delivery details. Here is your order details....<a href="orderdetails.php">Visit Here</a></p>
          
        </div>
        <div class="back"><a href="cart.php">Previous</a>
        </div>
       </div>   
       <div class="clear"></div>
    </div>
 </div>
<?php include('include/footer.php'); ?>

