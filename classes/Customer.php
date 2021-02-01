<?php
$filepath=realpath(dirname(__FILE__));
 include_once($filepath.'/../lib/Database.php');
 include_once($filepath.'/../helpers/Format.php');

class Customer 
{
  private $db;
  private $fm;
  public function __construct(){
    $this->db= new Database();
    $this->fm= new Format();
   }

   public function customerRegist($data){
   $name=mysqli_real_escape_string($this->db->link,$data['name']);
   $address=mysqli_real_escape_string($this->db->link,$data['address']);
   $city=mysqli_real_escape_string($this->db->link,$data['city']);
   $country=mysqli_real_escape_string($this->db->link,$data['country']);
   $zip=mysqli_real_escape_string($this->db->link,$data['zip']);
   $phone=mysqli_real_escape_string($this->db->link,$data['phone']);
   $email=mysqli_real_escape_string($this->db->link,$data['email']);
   $password=mysqli_real_escape_string($this->db->link,md5($data['password']));
   if($name==""||$address==""||$city==""||$country==""|| $zip==""||$phone==""||$email==""||$password==""){
	   $msg="<span class='error'>Field must not be empty.</span>";
    			   return $msg;
	   }
	   $mailquery="SELECT * FROM tb_customer WHERE email='$email' LIMIT 1";
	   $mailchk=$this->db->select($mailquery);
	   if ($mailchk!=false) {
	   $msg="<span class='error'>E-mail already Exit!</span>"; 
	   return $msg;
	   }else{
	   	$query="INSERT INTO tb_customer(name,address,city,country,zip,phone,email,password) 
	   	VALUES('$name','$address','$city','$country','$zip','$phone','$email','$password')";
	   	    $insert_row=$this->db->insert($query);
    		if($insert_row){
    			$msg="<span class='success'>Customer  Data Inserted Successfully.</span>";
    			return $msg;
    		}
    		else{
    			$msg="<span class='error'>Customer Data Inserted Failed.</span>";
    			return $msg;
    		}
	   }
   }
   //user login
   public function customerLogin($data){
  // $email=$this->fm->validation($email);
   $email=mysqli_real_escape_string($this->db->link,$data['email']);
  // $password=$this->fm->validation($password);
   $password=mysqli_real_escape_string($this->db->link,$data['password']);
   if (empty($email)||empty($password)) {
   	$msg="<span class='error'>Field must not be empty!</span>";
 	return $msg;
   }
   $query="SELECT * FROM  tb_customer WHERE email='$email' AND password='$password' ";
    $result=$this->db->select($query);
	if ($result) {
			$value=$result->fetch_assoc();
			Session::set("custlogin",true);
			Session::set("custId",$value['id']);
			Session::set("custName",$value['name']);
			header("Location:cart.php");

		
	}else{
		$msg="<span class='error'>Email or Password Not Matched!</span>";
 	    return $msg;
	   }
    }
    //show customer
    public function getCustomerData($id){
    $query="SELECT * FROM tb_customer WHERE id='$id'";//customer_id=get_id
	$result=$this->db->select($query);
	return $result;
    }
    //update customer profile
    public function customerUpdate($data,$custId){
    $name=mysqli_real_escape_string($this->db->link,$data['name']);
   $address=mysqli_real_escape_string($this->db->link,$data['address']);
   $city=mysqli_real_escape_string($this->db->link,$data['city']);
   $country=mysqli_real_escape_string($this->db->link,$data['country']);
   $zip=mysqli_real_escape_string($this->db->link,$data['zip']);
   $phone=mysqli_real_escape_string($this->db->link,$data['phone']);
   $email=mysqli_real_escape_string($this->db->link,$data['email']);
 
   if($name==""||$address==""||$city==""||$country==""||
    $zip==""||$phone==""||$email==""){
	   $msg="<span class='error'>Field must not be empty.</span>";
       return $msg;
	   }else{
	   	$query="UPDATE tb_customer SET
	   	 name='$name',
	   	 address='$address',
	   	 city='$city',
	   	 country='$country',    
	   	 zip='$zip',
	   	 phone='$phone',
	   	 email='$email'
		WHERE id='$custId'";
		$updated_row=$this->db->update($query);
		if($updated_row){
			//$msg="<span class='success'>Profile Updated Successfully.</span>";
			//return $msg;
			header("Location:profile.php");
		}else{
			$msg="<span class='error'>Profile Not Updated.</span>";
			return $msg;
		    }
	     }
    }
    

}
?>