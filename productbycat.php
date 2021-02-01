<?php include('include/header.php');

if(!isset($_GET['cat_id'])||$_GET['cat_id']==NULL){
  echo "<script>window.location='404.php';</script>";
}
else{
  $id=$_GET['cat_id'];
}

?>

 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
    		<h3>Latest from Iphone</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
	      <div class="section group">
             <?php
             $productbycat=$product->productByCat($id);
             if ($productbycat) {
              while ($result=$productbycat->fetch_assoc()) {?>
				<div class="grid_1_of_4 images_1_of_4">
			<a href="details.php?product_id=<?php echo $result['product_id']; ?>">
				<img src="admin/<?php echo $result['image'];?>"
		  alt="" /></a>
			 <h2><?php echo $result['product_name']; ?></h2>
		    <p><?php echo $fm->textShorten($result['body'],60); ?></p>
			 <p><span class="price"><?php echo $result['price']; ?></span></p>
		     <div class="button"><span><a href="details.php?product_id=<?php echo $result['product_id']; ?>" class="details">Details</a></span></div>
				</div>
              <?php }}else{
              	echo "<p>Products Of this Category are not Available! </p>";
              }?>
			</div>

	
	
    </div>
 </div>
<?php include('include/footer.php'); ?>