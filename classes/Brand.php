<?php 
 $filepath=realpath(dirname(__FILE__));
 include_once($filepath.'/../lib/Database.php');
 include_once($filepath.'/../helpers/Format.php');


class Brand{
  private $db;
  private $fm;
  public function __construct(){
    $this->db= new Database();
    $this->fm= new Format();
   }
   //add brand
  public function brandInsert($brand_name){
    $brand_name=$this->fm->validation($brand_name);
    $brand_name=mysqli_real_escape_string($this->db->link,$brand_name);
    if(empty($brand_name)){
        $msg="<span class='error'>Brand field must not be empty.</span>";
        return $msg;
      }
      else{
        $query="INSERT INTO tb_brand(brand_name) VALUES ('$brand_name')";
        $brandinsert=$this->db->insert($query);
        if($brandinsert){
          $msg="<span class='success'>Brand Inserted Successfully.</span>";
          return $msg;
        }
        else{
          $msg="<span class='error'>Brand Inserted Failed.</span>";
          return $msg;
        }
      }
   }
   //view brand
   public function getAllBrand(){
    $query="SELECT * FROM tb_brand ORDER BY brand_id ASC";
    $result=$this->db->select($query);
    return $result;
  }
  //update brand
  public function getBrandById($id){
    $query="SELECT * FROM tb_brand WHERE brand_id='$id'";
    $result=$this->db->select($query);
    return $result;
  }
  public function brandUpdate($brand_name,$id){
    $brand_name=$this->fm->validation($brand_name);
    $brand_name=mysqli_real_escape_string($this->db->link,$brand_name);
    $id=mysqli_real_escape_string($this->db->link,$id);
    if(empty($brand_name)){
        $msg="<span class='error'>Brand field must not be empty.</span>";
        return $msg;
      }else{
        $query="UPDATE tb_brand SET brand_name='$brand_name' 
        WHERE brand_id='$id'";
        $updated_row=$this->db->update($query);
        if($updated_row){
          $msg="<span class='success'>Brand Updated Successfully.</span>";
          return $msg;
        }else{
          $msg="<span class='error'>Brand Not Updated.</span>";
          return $msg;
        }
      }
  }
  //delete brand
  public function delBandById($id){
    $query="DELETE FROM tb_brand WHERE brand_id='$id'";
    $deldata=$this->db->delete($query);
    if($deldata){
      $msg="<span class='success'>Brand Deleted Successfully.</span>";
          return $msg;
    }else{
      $msg="<span class='error'>Brand Not Deleted.</span>";
          return $msg;
    }
  }
  ////slider
  public function addSlider($data,$file){
   $title=mysqli_real_escape_string($this->db->link,$data['title']);

    $permited=array('jpg','jpeg','png','gif');
     $file_name=$file['image']['name'];
     $file_size=$file['image']['size'];
     $file_temp=$file['image']['tmp_name'];

     $div=explode('.',$file_name);
     $file_ext=strtolower(end($div));
     $unique_image=substr(md5(time()),0,10).'.'.$file_ext;
     $uploaded_image="upload/slider/".$unique_image;
     if($title==""||$file_name==""){
                $msg="<span class='error'>Field must not be empty.</span>";
             return $msg;
     }elseif ($file_size >1048567) {
     echo "<span class='error'>Image Size should be less then 1MB!</span>";
    } elseif (in_array($file_ext, $permited) === false) {
     echo "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
    }else{
      move_uploaded_file($file_temp, $uploaded_image);
      $query="INSERT INTO tb_slider(title,image) VALUES('$title','$uploaded_image')";
          $insert_row=$this->db->insert($query);
        if($insert_row){
          $msg="<span class='success'>slider Inserted Successfully.</span>";
          return $msg;
        }
        else{
          $msg="<span class='error'>Slider Inserted Failed.</span>";
          return $msg;
        }
     }

  }
  public function getAllSlider(){
    $query="SELECT * FROM tb_slider ORDER BY id ASC";
    $result=$this->db->select($query);
    return $result;
  }
  
  public function delSlideById($sliderid){
    $query="DELETE FROM tb_slider WHERE id='$sliderid'";
    $deldata=$this->db->delete($query);
    if($deldata){
      $msg="<span class='success'>Slider Deleted Successfully.</span>";
          return $msg;
    }else{
      $msg="<span class='error'>Slider Not Deleted.</span>";
          return $msg;
    }
  }


}//end class

?>