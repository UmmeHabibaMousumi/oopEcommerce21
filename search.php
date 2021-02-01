<?php include('include/header.php'); ?>	
<?php
if (!isset($_GET['search'])|| $_GET['search']==NULL) {
	header("Location:404.php");
}else{
	$search=$_GET['search'];
}
?>
<div class="wrap">
<div style="text-align:center;margin:15px 0 100px 0;">
<?php
$query="SELECT * FROM tb_brand WHERE brand_name LIKE '%search%' 
";
$getData=$db->select($query);
if ($getData) {
	while ( $result->$getData->fetch_assoc()) {?>
	<td><?php echo $result['brand_name'];?></td>
	
	
	<?php }} else{?>
<p>No Result Found</p>
<?php }?>

</div>
</div>
<?php include('include/footer.php'); ?>