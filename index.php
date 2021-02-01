<?php include('include/header.php'); ?>
<?php include('include/slider.php'); ?>
		

 <div class="main">
    <div class="content">
    	<div class="content_top">
    		<div class="heading">
    		<h3>Feature Products</h3>
    		</div>
    		<div class="clear"></div>
    	</div>
	      <div class="section group">
	      	<?php
	      	$getFpro=$product->getFeaturePro();
	      	if($getFpro){
	      		while($result=$getFpro->fetch_assoc()){?>

				<div class="grid_1_of_4 images_1_of_4">
				 <a href="details.php?product_id=<?php echo $result['product_id']; ?>"><img src="admin/<?php echo $result['image']; ?>"
				  alt="" /></a>
				 <h2><?php echo $result['product_name']; ?></h2>
				 <p><?php echo $fm->textShorten($result['body'],60); ?></p>
				 <p><span class="price"><?php echo $result['price']; ?></span></p>
			     <div class="button"><span><a href="details.php?product_id=<?php echo $result['product_id']; ?>" class="details">Details</a></span></div>
				</div>	
	      	<?php	}}?>
			</div>

			<div class="content_bottom">
    		<div class="heading">
    		<h3>New Products</h3>
    		</div>
    		<div class="clear"></div>
    	    </div>

			<div class="section group">
			<?php
	      	  $getNpro=$product->getNewPro();
	      	  if($getNpro){
	      		while($result=$getNpro->fetch_assoc()){?>
				<div class="grid_1_of_4 images_1_of_4">
				 <a href="details.php?product_id=<?php echo $result['product_id']; ?>"><img src="admin/<?php echo $result['image']; ?>"
				  alt="" /></a>
				 <h2><?php echo $result['product_name']; ?></h2>
				 <p><span class="price"><?php echo $result['price']; ?></span></p>
			     <div class="button"><span><a href="details.php?product_id=<?php echo $result['product_id']; ?>" class="details">Details</a></span></div>
				</div>
				<?php	}}?>
		   </div>
			
    </div>
 </div>
<?php include('include/footer.php'); ?>