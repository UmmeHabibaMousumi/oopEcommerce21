<?php
$filepath=realpath(dirname(__FILE__));
include($filepath.'/../lib/Session.php');
Session::checkLogin();
 include_once($filepath.'/../lib/Database.php');
 include_once($filepath.'/../helpers/Format.php');

 ?>

<?php 
/*
adminlogin class
*/
class Adminlogin{
	private $db;
	private $fm;
	public function __construct(){
		$this->db= new Database();
		$this->fm= new Format();

	}
	public function adminLogin($admin_user,$admin_pass){
		$admin_user=$this->fm->validation($admin_user);
		$admin_pass=$this->fm->validation($admin_pass);
		$admin_user=mysqli_real_escape_string($this->db->link,$admin_user);
    	$admin_pass=mysqli_real_escape_string($this->db->link,$admin_pass);
    	if(empty($admin_user)||empty($admin_pass)){
    		$loginmsg="username or password must not be empty";
    		return $loginmsg;
    	}
    	else{
    		$query="SELECT * FROM tb_admin WHERE admin_user='$admin_user' AND admin_pass='$admin_pass'
    		";
    		$result=$this->db->select($query);

    		if($result!=false){
    			$value=$result->fetch_assoc();
    			Session::set("adminlogin",true);
                Session::set("admin_id",$value['admin_id']);
                Session::set("admin_user",$value['admin_user']);
                Session::set("admin_name",$value['admin_name']);
    			header("Location:dashboard.php");
    		}else{
    			$loginmsg="username or password  not match";
    			return $loginmsg;
    		}
    	}

	}


}

?>