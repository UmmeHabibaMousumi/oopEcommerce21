<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php  include '../classes/Brand.php';?>
<?php
 $brand= new Brand();
if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['submit'])){
    $addslider=$brand->addSlider($_POST,$_FILES);
    }

    if(isset($_GET['delslide'])){
	$sliderid=$_GET['delslide'];
	$delslide=$brand->delSlideById($sliderid);

}
 ?>
<div class="grid_10">
    <div class="box round first grid">
        <h2>Slider List</h2>
        <div class="block"> 
        <?php
        if (isset($delslide)) {
        	echo $delslide;
        }

        ?> 
            <table class="data display datatable" id="example">
			<thead>
				<tr>
					<th>No.</th>
					<th>Title</th>
					<th>Image</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
            <?php
       
			 $getslide=$brand->getAllSlider();
			 if( $getslide){
			 	$i=1;
			 	while($result= $getslide->fetch_assoc()){
			 		
                  ?>
				<tr class="odd gradeX">
					<td><?php echo $i++;?></td>
					<td><?php echo $result['title'];?></td>
					<td><img src="<?php echo $result['image'];?>" height="40px" width="60px"/></td>				
				<td>
							 <a onclick=" return confirm('Are you sure to Delete')" href="?delslide=<?php echo $result['id']; ?>">
							 	Delete</a></td>
					</tr>
					<?php }}?>	
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
