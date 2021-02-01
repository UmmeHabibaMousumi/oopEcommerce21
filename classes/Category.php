<?php 
 $filepath=realpath(dirname(__FILE__));
 include_once($filepath.'/../lib/Database.php');
 include_once($filepath.'/../helpers/Format.php');


class Category{

	private $db;
	private $fm;
	public function __construct(){
		$this->db= new Database();
		$this->fm= new Format();

	}
	//add category
	public function catInsert($cat_name){
		$cat_name=$this->fm->validation($cat_name);
		$cat_name=mysqli_real_escape_string($this->db->link,$cat_name);
		if(empty($cat_name)){
    		$msg="<span class='error'>Category field must not be empty.</span>";
    		return $msg;
    	}
    	else{
    		$query="INSERT INTO tb_category(cat_name) VALUES ('$cat_name')";
    		$catinsert=$this->db->insert($query);
    		if($catinsert){
    			$msg="<span class='success'>Category Inserted Successfully.</span>";
    			return $msg;
    		}
    		else{
    			$msg="<span class='error'>Category Inserted Failed.</span>";
    			return $msg;
    		}
    	}

	}
	//view category
	public function getAllCat(){
		$query="SELECT * FROM tb_category ORDER BY cat_id ASC";
		$result=$this->db->select($query);
		return $result;
	}
	//update category
	public function getCatById($id){
		$query="SELECT * FROM tb_category WHERE cat_id='$id'";
		$result=$this->db->select($query);
		return $result;
	}
	public function catUpdate($cat_name,$id){
		$cat_name=$this->fm->validation($cat_name);
		$cat_name=mysqli_real_escape_string($this->db->link,$cat_name);
		$id=mysqli_real_escape_string($this->db->link,$id);
		if(empty($cat_name)){
    		$msg="<span class='error'>Category field must not be empty.</span>";
    		return $msg;
    	}else{
    		$query="UPDATE tb_category SET cat_name='$cat_name' 
    		WHERE cat_id='$id'";
    		$updated_row=$this->db->update($query);
    		if($updated_row){
    			$msg="<span class='success'>Category Updated Successfully.</span>";
    			return $msg;
    		}else{
    			$msg="<span class='error'>Category Not Updated.</span>";
    			return $msg;
    		}
    	}

	}
	//Delete category
	public function delCatById($id){
		$query="DELETE FROM tb_category WHERE cat_id='$id'";
		$deldata=$this->db->delete($query);
		if($deldata){
			$msg="<span class='success'>Category Deleted Successfully.</span>";
    			return $msg;
		}else{
			$msg="<span class='error'>Category Not Deleted.</span>";
    			return $msg;
		}
	}
	
}

?>