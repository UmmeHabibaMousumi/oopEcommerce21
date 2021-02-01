<?php
$filepath=realpath(dirname(__FILE__));
 include_once($filepath.'/../lib/Database.php');
 include_once($filepath.'/../helpers/Format.php');

class Cart 
{
  private $db;
  private $fm;
  public function __construct(){
    $this->db= new Database();
    $this->fm= new Format();
   }
   //add cartProduct
   public function addToCart($quantity,$id){
   	$quantity=$this->fm->validation($quantity);
    $quantity=mysqli_real_escape_string($this->db->link,$quantity);
    $product_id=mysqli_real_escape_string($this->db->link,$id);
    $session_id=session_id();
    $squery="SELECT * FROM tb_product WHERE product_id='$product_id'";
	$result=$this->db->select($squery)->fetch_assoc();
	$product_name=$result['product_name'];
	$price=$result['price'];
	$image=$result['image'];

	$chquery="SELECT * FROM tb_cart WHERE product_id='$product_id' AND 
	session_id='$session_id'  ";
	$getpro=$this->db->select($chquery);
	if ($getpro) {
		$msg="Product already Added";
		return $msg;
	}else{

	$query="INSERT INTO tb_cart(session_id,product_id,product_name,price,quantity,image)
      VALUES('$session_id','$product_id','$product_name','$price','$quantity','$image')"; 
      $added_cart=$this->db->insert($query);
    		if($added_cart){
    			header("Location:cart.php");
    		}else{
    			header("Location:404.php");
    		}
    	}
   }
   //show cart Product
   public function getCartProduct(){
   	$session_id=session_id();
    $query="SELECT * FROM tb_cart WHERE session_id='$session_id'";
    $result=$this->db->select($query);
    return $result;
  }
  //update  cartProductQuantity
  public function UpdateCartQuantity($cart_id,$quantity){
  	$cart_id=mysqli_real_escape_string($this->db->link,$cart_id);
  	$quantity=mysqli_real_escape_string($this->db->link,$quantity);
    $query="UPDATE tb_cart SET quantity='$quantity' 
    		WHERE cart_id='$cart_id'";
    		$updated_row=$this->db->update($query);
    		if($updated_row){
    			header("Location:cart.php");
    		}else{
    			$msg="<span class='error'>Quantity Not Updated.</span>";
    			return $msg;
    		}
  }
  //delete cartproduct
  public function delProCartById($delproCart){
  	$delproCart=mysqli_real_escape_string($this->db->link,$delproCart);//security purpose
    $query="DELETE FROM tb_cart WHERE cart_id='$delproCart'";
    $deldata=$this->db->delete($query);
    if($deldata){
      echo "<script>window.location='cart.php';</script>";
    }else{
      $msg="<span class='error'>product Not Deleted.</span>";
          return $msg;
    }
  }
  //if cartproduct<=0 
  public function checkCartTable(){
  	$session_id=session_id();
    $query="SELECT * FROM tb_cart WHERE session_id='$session_id'";
	  $result=$this->db->select($query);
		return $result;
  }
  //delete cart added by customer
  public function delCustomerCart(){
    $session_id=session_id();
    $query="DELETE  FROM tb_cart WHERE session_id='$session_id'";
    $this->db->delete($query);
  }
  //oderprodct by customer
  public function OrderProduct($customer_id){
    $session_id=session_id();
    $query="SELECT * FROM tb_cart WHERE session_id='$session_id'";
    $getPro=$this->db->select($query);
  if ($getPro) {
    while ($result=$getPro->fetch_assoc()) {
     $product_id=$result['product_id'];
     $product_name=$result['product_name'];
     $quantity=$result['quantity'];
     $price=$result['price'] * $result['quantity'];
     $image=$result['image'];
     $query="INSERT INTO tb_order(customer_id,product_id,product_name,quantity,price,image)
      VALUES('$customer_id','$product_id','$product_name','$quantity','$price','$image')"; 
      $inserted_row=$this->db->insert($query);
    }
        }
      }
  //show current ordered amount
      public function payableAmount( $customer_id){
    $query="SELECT price FROM tb_order WHERE customer_id='$customer_id' AND date=now()";
    $result=$this->db->select($query);
    return $result;
      }
//show order detail
      public function getOrderProduct($customer_id){
    $query="SELECT * FROM tb_order WHERE customer_id='$customer_id' ORDER BY date DESC ";
    $result=$this->db->select($query);
    return $result;
    }
    //check order
    public function checkOrder($cust_id){
    $query="SELECT * FROM tb_order WHERE customer_id='$cust_id'";
    $result=$this->db->select($query);
    return $result;
    }
    //show orderDetails in admin pannel
    public function getAllorderProduct(){
      $query="SELECT * FROM tb_order ORDER BY date Desc";
    $result=$this->db->select($query);
    return $result;
    }
    //shift check
    public function productShifted($id,$date,$price){
      $id=mysqli_real_escape_string($this->db->link,$id);
      $date=mysqli_real_escape_string($this->db->link,$date);
      $price=mysqli_real_escape_string($this->db->link,$price);
      $query="UPDATE tb_order
       SET status='1' 
        WHERE customer_id='$id' AND date='$date' AND price='$price'";
        $updated_row=$this->db->update($query);
        if($updated_row){
          $msg="<span class='success'>Shifted Successfully.</span>";
          return $msg;
        }else{
          $msg="<span class='error'>Not Shifted.</span>";
          return $msg;
        }
    }
    //delted shifted product
public function delproductShifted($id,$time,$price){
      $id=mysqli_real_escape_string($this->db->link,$id);
      $time=mysqli_real_escape_string($this->db->link,$time);
      $price=mysqli_real_escape_string($this->db->link,$price);
      $query="DELETE FROM tb_order  WHERE customer_id='$id' AND date='$time' AND price='$price'";
    $deldata=$this->db->delete($query);
    if($deldata){
      $msg="<span class='success'>Removed Successfully.</span>";
          return $msg;
    }else{
      $msg="<span class='error'>Not Removed.</span>";
          return $msg;
    }
    }
    public function productShiftedConfirm($id,$time,$price){
    $id=mysqli_real_escape_string($this->db->link,$id);
      $time=mysqli_real_escape_string($this->db->link,$time);
      $price=mysqli_real_escape_string($this->db->link,$price);
      $query="UPDATE tb_order
       SET status='2' 
        WHERE customer_id='$id' AND date='$time' AND price='$price'";
        $updated_row=$this->db->update($query);
        if($updated_row){
          $msg="<span class='success'>Updated Successfully.</span>";
          return $msg;
        }else{
          $msg="<span class='error'>Not Updated.</span>";
          return $msg;
        }

    }


}//end class

?>