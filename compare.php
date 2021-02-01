<?php include('include/header.php');?>
<?php
$login=Session::get("custlogin");
     if ($login==false) {
     	header("Location:login.php");
     }
?>
<style>
table.tblone img{height:60px;width:60px;}
</style>

 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>Compare</h2>
			    	<?php
			    	//msg for update
			    	if (isset($updateCart)) {
			    		echo $updateCart;
			    	}
			    	?>
						<table class="tblone">
							<tr>
								<th>SL</th>
								<th>Product Name</th>
								<th>Price</th>
								<th>Image</th>
								<th>Action</th>
							</tr>
							<tr>
				  <?php
				  $cust_id=Session::get("custId");
                  $getPd=$product->getCompareData($cust_id);
                  if ($getPd) {
                  	$i=1;
                  	while ($result=$getPd->fetch_assoc()) {?>
                  		
								<td><?php echo $i++;?></td>
								<td><?php echo $result['product_name'] ;?></td>
								<td>$<?php echo $result['price'] ;?></td>
								<td><img src="admin/<?php echo $result['image']; ?>" alt=""/></td>
								<td><a href="details.php?product_id=<?php echo $result['product_id']; ?>">View</a></td>
							</tr>
					  <?php }}?>	
						</table>
					</div>
					  <div class="shopping">
					<div class="shopleft" style="width:100%;text-align:center;">
						<a href="index.php"> <img src="images/shop.png" alt="" /></a>
					</div>
					  </div>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<?php include('include/footer.php'); ?>