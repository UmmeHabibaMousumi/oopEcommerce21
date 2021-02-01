<?php 
 include 'inc/header.php';
 include 'inc/sidebar.php';
 include '../classes/Brand.php';
 $brand= new Brand();
if(isset($_GET['delbrand'])){
	$id=$_GET['delbrand'];
	$delbrand=$brand->delBandById($id);

}

 ?>

        <div class="grid_10">
            <div class="box round first grid">
                <h2>Brand List</h2>
                <div class="block">  
                <?php 
                  if(isset($delbrand)){
                  echo $delbrand;
                  }
                 ?>      
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Serial No.</th>
							<th>Brand Name</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
						 $getBrand=$brand->getAllBrand();
						 if( $getBrand){
						 	$i=1;
						 	while($result= $getBrand->fetch_assoc()){
						 		
                              ?>

						<tr class="odd gradeX">
							<td><?php echo $i++;?></td>
							<td><?php echo $result['brand_name'];?></td>
							<td><a href="brandedit.php?brand_id=<?php echo $result['brand_id']; ?>">Edit</a> ||
							 <a onclick=" return confirm('Are you sure to Delete')" href="?delbrand=<?php echo $result['brand_id']; ?>">
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

