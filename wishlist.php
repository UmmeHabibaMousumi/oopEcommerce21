<?php include('include/header.php');?>
<style>
table.tblone img{height:60px;width:60px;}
</style>
<?php
if(isset($_GET['delwlistid'])){
  $produc_id=$_GET['delwlistid'];
  $delwlist=$product->delWlistData($cust_id,$produc_id);
}?>
 <div class="main">
    <div class="content">
    	<div class="cartoption">		
			<div class="cartpage">
			    	<h2>WishList</h2>
			    	<?php
			    	//msg for update
			    	if (isset($updateCart)) {
			    		echo $updateCart;
			    	}
			    	//wlist delete
			    	if (isset($delwlist)) {
			    		echo $delwlist;
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
				  //$cust_id=Session::get("custId");
                  $getPd=$product->getWlistData($cust_id);
                  if ($getPd) {
                  	$i=1;
                  	while ($result=$getPd->fetch_assoc()) {?>
                  		
								<td><?php echo $i++;?></td>
								<td><?php echo $result['product_name'] ;?></td>
								<td>$<?php echo $result['price'] ;?></td>
								<td><img src="admin/<?php echo $result['image']; ?>" alt=""/></td>
								<td>
									<a href="details.php?product_id=<?php echo $result['product_id']; ?>">Buy Now</a>||
									<a href="?delwlistid=<?php echo $result['product_id']; ?>">Remove</a>
								</td>
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