<?php include('include/header.php'); ?>
<?php 
     $login=Session::get("custlogin");
     if ($login==false) {
     	header("Location:login.php");
     }
?>
<?php
if (isset($_GET['confirmid'])) {
  $id=$_GET['confirmid'];
  $time=$_GET['time'];
  $price=$_GET['price'];
  $confirm=$cart->productShiftedConfirm($id,$time,$price);
}
?>
<style>
.tblone{text-align:justify;}
</style>
 <div class="main">
    <div class="content">
    	 <div class="section group">
    	 	<div class="order">
    	 		<h2>Your Order Details</h2>
                <table class="tblone">
                            <tr>
                                <th>No.</th>
                                <th>Product Name</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <tr>
                  <?php
                  $customer_id=Session::get("custId");
                  $getOrder=$cart->getOrderProduct($customer_id);
                  if ($getOrder) {
                    $i=1;
                    while ($result=$getOrder->fetch_assoc()) {?>
                        
                                <td><?php echo $i++;?></td>
                                <td><?php echo $result['product_name'] ;?></td>
                                <td><img src="admin/<?php echo $result['image']; ?>" alt=""/></td>
                                <td>$<?php echo $result['quantity'] ;?></td>
                                <td>$<?php 
                                    echo $result['price'] *$result['quantity'];
                                
                                ?></td>
                                <td>$<?php echo $fm->formatDate($result['date']);?></td>
                                <td> <?php
                                if ($result['status']=='0') {
                                    echo "pending";
                                }elseif($result['status']=='1'){
                                   echo "shifted"; 
                                }else{
                                  echo "Ok";
                                }

                                 ?>
                               </td>
                                 <?php
                                 if($result['status']=='1'){?>
                                 <td><a href="?confirmid=<?php echo $customer_id;?>&price=<?php echo $result['price'];?>
                                &time=<?php echo $result['date'];?>">confirm</a></td>
                           <?php  } elseif($result['status']=='2'){ ?>
                            <td>Ok</td>
                          <?php }else{?>
                           <td>N/A</td>
                          <?php }?>

                            </tr>
                      <?php }}?>
                            
                        </table>
    	 	</div>
    	 </div> 	
       <div class="clear"></div>
    </div>
 </div>
<?php include('include/footer.php'); ?>

