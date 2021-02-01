<?php 
$filepath=realpath(dirname(__FILE__));
 include_once($filepath.'/../lib/Database.php');
 include_once($filepath.'/../helpers/Format.php');

class Product 
{
	private $db;
	private $fm;
	public function __construct(){
		$this->db= new Database();
		$this->fm= new Format();
	}
	//add product
	public function productInsert($data,$file){
	   $product_name=mysqli_real_escape_string($this->db->link,$data['product_name']);
	   $cat_id=mysqli_real_escape_string($this->db->link,$data['cat_id']);
	   $brand_id=mysqli_real_escape_string($this->db->link,$data['brand_id']);
	   $body=mysqli_real_escape_string($this->db->link,$data['body']);
	   $price=mysqli_real_escape_string($this->db->link,$data['price']);
	   $type=mysqli_real_escape_string($this->db->link,$data['type']);

	   $permited=array('jpg','jpeg','png','gif');
	   $file_name=$file['image']['name'];
	   $file_size=$file['image']['size'];
	   $file_temp=$file['image']['tmp_name'];

	   $div=explode('.',$file_name);
	   $file_ext=strtolower(end($div));
	   $unique_image=substr(md5(time()),0,10).'.'.$file_ext;
	   $uploaded_image="upload/".$unique_image;
	   if($product_name==""||$cat_id==""||$brand_id==""||$body==""|| $price==""||$file_name==""||$type==""){
	   	    			$msg="<span class='error'>Field must not be empty.</span>";
    			   return $msg;
	   }elseif ($file_size >1048567) {
     echo "<span class='error'>Image Size should be less then 1MB!</span>";
    } elseif (in_array($file_ext, $permited) === false) {
     echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
    }else{
	   	move_uploaded_file($file_temp, $uploaded_image);
	   	$query="INSERT INTO tb_product(product_name,cat_id,brand_id,body,price,image,type) VALUES('$product_name','$cat_id','$brand_id','$body','$price','$uploaded_image','$type')";
	   	    $insert_row=$this->db->insert($query);
    		if($insert_row){
    			$msg="<span class='success'>Product Inserted Successfully.</span>";
    			return $msg;
    		}
    		else{
    			$msg="<span class='error'>Product Inserted Failed.</span>";
    			return $msg;
    		}
	   }

	}
	//view product
	public function getAllProduct(){
		$query="SELECT  tb_product.*, tb_category.cat_name, tb_brand.brand_name
		From tb_product INNER JOIN tb_category
		ON tb_product.cat_id=tb_category.cat_id
		INNER JOIN tb_brand
		On tb_product.brand_id=tb_brand.brand_id

		 ORDER BY tb_product.product_id ASC";
		$result=$this->db->select($query);
		return $result;
	}
	//update product
	public function getProductById($id){
		$query="SELECT * FROM tb_product WHERE product_id='$id'";
		$result=$this->db->select($query);
		return $result;
	}
	public function productUpdate($data,$file,$id){
	  $product_name=mysqli_real_escape_string($this->db->link,$data['product_name']);
	   $cat_id=mysqli_real_escape_string($this->db->link,$data['cat_id']);
	   $brand_id=mysqli_real_escape_string($this->db->link,$data['brand_id']);
	   $body=mysqli_real_escape_string($this->db->link,$data['body']);
	   $price=mysqli_real_escape_string($this->db->link,$data['price']);
	   $type=mysqli_real_escape_string($this->db->link,$data['type']);

	   $permited=array('jpg','jpeg','png','gif');
	   $file_name=$file['image']['name'];
	   $file_size=$file['image']['size'];
	   $file_temp=$file['image']['tmp_name'];

	   $div=explode('.',$file_name);
	   $file_ext=strtolower(end($div));
	   $unique_image=substr(md5(time()),0,10).'.'.$file_ext;
	   $uploaded_image="upload/".$unique_image;
	   if($product_name==""||$cat_id==""||$brand_id==""||$body==""|| $price==""||$type==""){
	   	    			$msg="<span class='error'>Field must not be empty.</span>";
    			   return $msg;
	   }else {
           if(!empty($file_name)){
    
			   if ($file_size >1048567) {
		     echo "<span class='error'>Image Size should be less then 1MB!</span>";
		    } elseif (in_array($file_ext, $permited) === false) {
		     echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
		    }else{
			   	move_uploaded_file($file_temp, $uploaded_image);
			   	$query="UPDATE tb_product SET product_name='$product_name',cat_id='$cat_id',brand_id='$brand_id',body='$body',price='$price',image='$uploaded_image',type='$type' WHERE product_id='$id'";
			   	    $updated_row=$this->db->update($query);
		    		if($updated_row){
		    			$msg="<span class='success'>Product Updated  Successfully.</span>";
		    			return $msg;
		    		}
		    		else{
		    			$msg="<span class='error'>Product  Updated Failed.</span>";
    			return $msg;
    		}
	     }
	   }else { 
			   	$query="UPDATE tb_product SET product_name='$product_name',cat_id='$cat_id',brand_id='$brand_id',body='$body',price='$price',type='$type' WHERE product_id='$id'";
			   	    $updated_row=$this->db->update($query);
		    		if($updated_row){
		    			$msg="<span class='success'>Product Updated  Successfully.</span>";
		    			return $msg;
		    		}
		    		else{
		    			$msg="<span class='error'>Product  Updated Failed.</span>";
    			return $msg;
    		} 

	  }
  }

	 }
	 //delete product
 public function delProductById($id){
  $imgquery="SELECT * FROM tb_product WHERE product_id='$id'";
  $getData=$this->db->select($imgquery);
  if($getData){
  	while($delimg=$getData->fetch_assoc()){
  		$dellink=$delimg['image'];
  		unlink($dellink);
  	}
  }

 	$query="DELETE FROM tb_product WHERE product_id='$id'";
		$deldata=$this->db->delete($query);
		if($deldata){
			$msg="<span class='success'>Product Deleted Successfully.</span>";
    			return $msg;
		}else{
			$msg="<span class='error'>Product Not Deleted.</span>";
    			return $msg;
		}
 }

 //show Feature product
 public function getFeaturePro(){
 	$query="SELECT * FROM tb_product WHERE type='0' ORDER BY product_id  LIMIT 4";
    $result=$this->db->select($query);
    return $result;

 }
 //show others product
 public function getNewPro(){
 	$query="SELECT * FROM tb_product  ORDER BY product_id DESC LIMIT 4";
 	//$query="SELECT * FROM tb_product WHERE type='1'  ORDER BY product_id DESC LIMIT 4";
    $result=$this->db->select($query);
    return $result;

 }
 //show single product
 public function getSingleProduct($id){
 	$query="SELECT  p.*, c.cat_name, b.brand_name
		From tb_product as p, tb_category as c, tb_brand as b
	    WHERE p.cat_id=c.cat_id
	     AND p.brand_id=b.brand_id 
	     AND p.product_id='$id'
	    ";
		$result=$this->db->select($query);
		return $result;

 }
 // show iphone band
 public function latestFromIphone(){
 	$query="SELECT * FROM tb_product WHERE brand_id='4'  ORDER BY product_id DESC LIMIT 1";
    $result=$this->db->select($query);
    return $result;
 }
// show Samsung band
 public function latestFromSamsung(){
 	$query="SELECT * FROM tb_product WHERE brand_id='3'  ORDER BY product_id DESC LIMIT 1";
    $result=$this->db->select($query);
    return $result;
 }
 // show Canon band
 public function latestFromCanon(){
 	$query="SELECT * FROM tb_product WHERE brand_id='2'  ORDER BY product_id DESC LIMIT 1";
    $result=$this->db->select($query);
    return $result;
 }
 // show Acer band
 public function latestFromAcer(){
 	$query="SELECT * FROM tb_product WHERE brand_id='1'  ORDER BY product_id DESC LIMIT 1";
    $result=$this->db->select($query);
    return $result;
 }
 //show product from category
 public function productByCat($id){
 $cat_id=mysqli_real_escape_string($this->db->link,$id);
  $query="SELECT * FROM tb_product WHERE cat_id='$id'";
		$result=$this->db->select($query);
		return $result;
 }
 //compare product
 public function insertCompareData($cmprId,$customerId){
 	 $customerId=mysqli_real_escape_string($this->db->link,$customerId);
 	 $productId=mysqli_real_escape_string($this->db->link,$cmprId);

 	 $cquery="SELECT * FROM tb_compare WHERE customer_id='$customerId' AND product_id='$productId'";
 	 $check=$this->db->select($cquery);
     if ($check) {
          $msg="<span class='error'>Already Added.</span>";
          return $msg;
     }

 	$query="SELECT * FROM tb_product WHERE product_id='$productId'";
    $result=$this->db->select($query)->fetch_assoc();
  if ($result) {
     $product_id=$result['product_id'];
     $product_name=$result['product_name'];
     $price=$result['price'] ;
     $image=$result['image'];
     $query="INSERT INTO tb_compare(customer_id,product_id,product_name,price,image)
      VALUES('$customerId','$productId','$product_name','$price','$image')"; 
      $inserted_row=$this->db->insert($query);
        if($inserted_row){
          $msg="<span class='success'>Added! Check Compare Page.</span>";
          return $msg;
        }else{
          $msg="<span class='error'>Not Added.</span>";
          return $msg;
        }

        }
 }
 //show compare Product
 public function getCompareData($cust_id){
   $query="SELECT * FROM tb_compare WHERE customer_id='$cust_id' ORDER BY compare_id DESC";
   $result=$this->db->select($query);
		return $result;
 }
 //if user logout compared will be removed
public function delCompareData($cust_id){
    $query="DELETE  FROM tb_compare WHERE customer_id='$cust_id'";
    $result=$this->db->delete($query);
    return $result;
  }
   //add list to wish
  public function saveWishListData($id,$custId){
  	$pquery="SELECT * FROM tb_product WHERE product_id='$id'";

  	 $cquery="SELECT * FROM tb_wlist WHERE customer_id='$custId' AND product_id='$id'";
 	 $check=$this->db->select($cquery);
     if ($check) {
          $msg="<span class='error'>Already Added!</span>";
          return $msg;
     }
    $result=$this->db->select($pquery)->fetch_assoc();
  if ($result) {
     $product_id=$result['product_id'];
     $product_name=$result['product_name'];
     $price=$result['price'];
     $image=$result['image'];
     $query="INSERT INTO tb_wlist(customer_id,product_id,product_name,price,image)
      VALUES('$custId','$product_id','$product_name','$price','$image')"; 

      $inserted_row=$this->db->insert($query);
       if($inserted_row){
			$msg="<span class='success'>Added! Check WishList</span>";
    			return $msg;
		}else{
			$msg="<span class='error'>Not Added.</span>";
    			return $msg;
		}
     }
  }
  //wlist show if user is loggin
  public function getWlistData($cust_id){
  	$query="SELECT * FROM tb_wlist WHERE customer_id='$cust_id' ORDER BY wlist_id DESC";
   $result=$this->db->select($query);
		return $result;
  }
  //delete wishlist
  public function delWlistData($cust_id,$produc_id){
  	$query="DELETE  FROM tb_wlist WHERE customer_id='$cust_id' AND 
  	product_id='$produc_id'";
    $deldata=$this->db->delete($query);
    if($deldata){
			$msg="<span class='success'>WList Deleted Successfully.</span>";
    			return $msg;
		}else{
			$msg="<span class='error'>Not Deleted.</span>";
    			return $msg;
		}
  }

}//end cls
 ?>

