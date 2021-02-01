<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php
		$filepath=realpath(dirname(__FILE__));
		include($filepath.'/../classes/Cart.php');
		$cart=new Cart();
		$fm=new Format();
 ?>
 <?php
if (isset($_GET['shiftid'])) {
	$id=$_GET['shiftid'];
	$time=$_GET['time'];
	$price=$_GET['price'];
	$shift=$cart->productShifted($id,$time,$price);
}
  
  if (isset($_GET['delpro'])) {
	$id=$_GET['delpro'];
	$time=$_GET['time'];
	$price=$_GET['price'];
	$delpro=$cart->delproductShifted($id,$time,$price);
}
 ?>
        <div class="grid_10">
            <div class="box round first grid">
                <h2>Inbox</h2>
                <?php
                if (isset($shift)) {
                	echo $shift;
                }
                if (isset($delpro)) {
                	echo $delpro;
                }
            	?>
                <div class="block">        
                    <table class="data display datatable" id="example">
					<thead>
						<tr>
							<th>Id</th>
							<th>Order Time</th>
							<th>Product</th>
							<th>Quantity</th>
							<th>Price</th>
							<th>Customer ID</th>
							<th>Address</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php
                        $getOrder=$cart->getAllorderProduct();
                        if ($getOrder) {
                        	while ($result=$getOrder->fetch_assoc()) {?>
      
						<tr class="odd gradeX">
							<td><?php echo $result['id'];?></td>
							<td><?php echo $fm->formatDate($result['date']);?></td>
							<td><?php echo $result['product_name'];?></td>
							<td><?php echo $result['quantity'];?></td>
							<td>$<?php echo $result['price'];?></td>
							<td><?php echo $result['customer_id'];?></td>
							<td><a href="customer.php?customer_id=<?php echo $result['customer_id'];?>">View Details</a></td>
							<?php
                             if ($result['status']=='0') {?>
                             	<td><a href="?shiftid=<?php echo $result['customer_id'];?>&price=<?php echo $result['price'];?>
                             		&time=<?php echo $result['date'];?>">Shifted</a></td>
                            <?php }elseif($result['status']=='1'){?>
                             <td>Pending</td>
                            <?php }else{?>
							 <td><a onclick=" return confirm('Are you sure to Remove')" href="?delpro=<?php echo $result['customer_id'];?>&
                             		price=<?php echo $result['price'];?>&time=<?php echo $result['date'];?>">Remove</a></td>
                         <?php }?>
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
