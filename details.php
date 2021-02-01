<?php include('include/header.php'); ?>
<?php
if(isset($_GET['product_id'])){
  $id=$_GET['product_id'];
}


if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){
    $quantity=$_POST['quantity'];
    $addCart=$cart->addToCart($quantity,$id);
    }
?>
<?php
   $custId=Session::get("custId"); 
   if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['compare'])){
   	$product_id=$_POST['product_id'];
    $insertCompare=$product->insertCompareData($product_id,$custId);
    }
 ?>

<?php

   $custId=Session::get("custId");
   if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['wlist'])){
    $saveWlist=$product->saveWishListData($id,$custId);
    }
 ?>
 <div class="main">
    <div class="content">
    	<div class="section group">
		<div class="cont-desc span_1_of_2">		
				<?php
                  $getPd=$product->getSingleProduct($id);
                  if ($getPd) {
                  	while ($result=$getPd->fetch_assoc()) {?>
                  		
					<div class="grid images_3_of_2">
						<img src="admin/<?php echo $result['image']; ?>" alt="" />
					</div>
				<div class="desc span_3_of_2">
					<h2><?php echo $result['product_name']; ?> </h2>
					
					<div class="price">
						<p>Price: <span><?php echo $result['price']; ?></span></p>
						<p>Category: <span><?php echo $result['cat_name']; ?></span></p>
						<p>Brand:<span><?php echo $result['brand_name']; ?></span></p>
					</div>
				<div class="add-cart">
					<form action="" method="post">
						<input type="number" class="buyfield" name="quantity" value="1"/>
						<input type="submit" class="buysubmit" name="submit" value="Buy Now"/>
					</form>	
				</div>
					<span style="color:red;font-size:18px;">
					<?php
					if (isset($addCart)) {
						echo $addCart;
                       }?>
						<?php 
						if (isset($insertCompare)) {
						echo $insertCompare;
					  }?>	

					  <?php 
						if (isset($saveWlist)) {
						echo $saveWlist;
					  }?>
				</span>	
             <?php $login=Session::get("custlogin");
             if ($login==true) {?>
			<div class="add-cart" style="display:flex;">
				<div class="sample">
				<form action="" method="post">
					<input type="hidden" class="buyfield" name="product_id" value="<?php echo $result['product_id']; ?>"/>
					<input type="submit" class="buysubmit" name="compare" value="Add to Compare"/>
				</form>
				</div>
			<div style="margin-left:10px;">	
				<form action="" method="post">
			    <input type="submit" class="buysubmit" name="wlist" value="Save To List"/>
				</form>	
			</div>
			</div>
               <?php }?>
			</div>
			<div class="product-desc">
			<h2>Product Details</h2>
			<?php echo $result['body']; ?>
	      </div>
	     <?php	} } ?>			
	</div>
				<div class="rightsidebar span_3_of_1">
					<h2>CATEGORIES</h2>
					<ul>
					<?php
					$getCat=$cg->getAllCat();
					if( $getCat){
						 	while($result= $getCat->fetch_assoc()){ ?>
				      <li><a href="productbycat.php?cat_id=<?php echo $result['cat_id']; ?>">
				      	<?php echo $result['cat_name'];?></a>
				      </li>
				      	<?php	}}?>
    				</ul>
    	
 				</div>
 		</div>
 	</div>
	</div>
   <?php include('include/footer.php'); ?>