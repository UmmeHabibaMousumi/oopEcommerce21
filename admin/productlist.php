<?php 
include 'inc/header.php';
include 'inc/sidebar.php';
include '../classes/Product.php';
include_once '../helpers/Format.php';
$product= new Product();
$fm= new Format();
if(isset($_GET['delproduct'])){
	$id=$_GET['delproduct'];
	$delproduct=$product->delProductById($id);

}
?>

 
 <?php 
  if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){
    $updateproduct=$product->productUpdate($_POST,$_FILES,$id);
    }
?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Post List</h2>
        <div class="block"> 
        <?php 
                  if(isset($delproduct)){
                  echo $delproduct;
                  }
                 ?>       
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>SL</th>
					<th>Product Name</th>
					<th>Category</th>
					<th>Brand</th>
					<th>Description</th>
					<th>Price</th>
					<th>Image</th>
					<th>Type</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
			 $getProduct=$product->getAllProduct();
			 if( $getProduct){
			 	$i=1;
			 	while($result= $getProduct->fetch_assoc()){
			 		
                  ?>

				<tr class="odd gradeX">
					<td><?php echo $i++;?></td>
					<td><?php echo $result['product_name'];?></td>
					<td><?php echo $result['cat_name'];?></td>
					<td><?php echo $result['brand_name'];?></td>
					<td><?php echo $fm->textShorten($result['body'],50);?></td>
					<td>$<?php echo $result['price'];?></td>
					<td><img src="<?php echo $result['image'];?>" height="40px" width="60px"/></td>
					<td>
					<?php 
					if($result['type']==0){
						echo"Featured";
					}else{
						echo"General";
					}
					?>
				    </td>
					<td><a href="productedit.php?product_id=<?php echo $result['product_id']; ?>">Edit</a> ||
							 <a onclick=" return confirm('Are you sure to Delete')" href="?delproduct=<?php echo $result['product_id']; ?>">
							 	Delete</a></td>
				</tr>
				<?php 
						}
						 }
				?>	
			</tbody>
		</table>

       </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        setupLeftMenu();
        $('.datatable').dataTable();
		setSidebarHeight();
    });
</script>
<?php include 'inc/footer.php';?>
