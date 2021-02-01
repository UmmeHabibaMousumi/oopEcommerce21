<?php include('include/header.php');
//delete Cartproduct
if(isset($_GET['delproCart'])){
	$delproCart=$_GET['delproCart'];
	$delproCart=$cart->delProCartById($delproCart);

}
//Update Cartproduct
if($_SERVER['REQUEST_METHOD']=='POST'){
    $cart_id=$_POST['cart_id'];
    $quantity=$_POST['quantity'];
    $updateCart=$cart->UpdateCartQuantity($cart_id,$quantity);
    if ($quantity<=0) {
    	$delproCart=$cart->delProCartById($cart_id);
    }
}
 ?>
 <?php
 //refresh page
 if (!isset($_GET['id'])) {
 	echo "<meta http-equiv='refresh' content='0;URL=?id=live'/>";
 }
 ?>

 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Your Cart</h2>
			    	<?php
			    	//msg for update
			    	if (isset($updateCart)) {
			    		echo $updateCart;
			    	}
			    	//msg for delete
			    	if (isset($delproCart)) {
			    		echo $delproCart;
			    	}
			    	?>
						<table class="tblone">
							<tr>
								<th width="5%">SL</th>
								<th width="30%">Product Name</th>
								<th width="10%">Image</th>
								<th width="15%">Price</th>
								<th width="15%">Quantity</th>
								<th width="10%">Total Price</th>
								<th width="10%">Action</th>
							</tr>
							<tr>
				  <?php
                  $getPd=$cart->getCartProduct();
                  if ($getPd) {
                  	$i=1;
                  	$sum=0;
                  	$qty=0;
                  	while ($result=$getPd->fetch_assoc()) {?>
                  		
								<td><?php echo $i++;?></td>
								<td><?php echo $result['product_name'] ;?></td>
								<td><img src="admin/<?php echo $result['image']; ?>" alt=""/></td>
								<td>$<?php echo $result['price'] ;?></td>
								<td>
									<form action="" method="post">
										<input type="hidden" name="cart_id" 
										value="<?php echo $result['cart_id']; ?>"/>
										<input type="number" name="quantity" 
										value="<?php echo $result['quantity']; ?>"/>
										<input type="submit" name="submit" value="Update"/>
									</form>
								</td>
								<td>$<?php 
								$total=$result['price'] *$result['quantity'];
								echo $total;
								?></td>
								<td><a onclick=" return confirm('Are you sure to Delete')" 
									href="?delproCart=<?php echo $result['cart_id']; ?>">X</a></td>
							</tr>
							<?php 
							$sum=$sum+$total;
							$qty=$qty+ $result['quantity'];
							Session::set("sum",$sum);
							Session::set("qty",$qty);

							?>
					  <?php }}?>
							
						</table>
						<?php 
                        $getData=$cart->checkCartTable();
                         if ($getData) {?>
						<table style="float:right;text-align:left;" width="40%">
							<tr>
								<th>Sub Total : </th>
								<td><?php echo $sum;?></td>
							</tr>
							<tr>
								<th>VAT : </th>
								<td>10%</td>
							</tr>
							<tr>
								<th>Grand Total :</th>
								<td>
							  <?php
							  $vat=$sum* 0.1;
							  $gtotal=$sum+$vat;
							  echo $gtotal; 
							  ?> </td>
							</tr>
					   </table>
					   <?php }else{
					   	header("Location:index.php");
					   	//echo "Cart is Empty! Shop Now.";
					   }?>
					</div>
					  <div class="shopping">
					<div class="shopleft">
						<a href="index.php"> <img src="images/shop.png" alt="" /></a>
					</div>
					<div class="shopright">
						<a href="payment.php"> <img src="images/check.png" alt="" /></a>
					</div>
					  </div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<?php include('include/footer.php'); ?>