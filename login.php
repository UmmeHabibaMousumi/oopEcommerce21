<?php include('include/header.php'); ?>
<?php 
     $login=Session::get("custlogin");
     if ($login==true) {
     	header("Location:cart.php");
     }
?>
 <?php
   if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['login'])){
    $customerLog=$customer->customerLogin($_POST);
    }
 ?>
 <div class="main">
    <div class="content">
    	 <div class="login_panel">
    	 	<?php
             if (isset($customerLog)) {
			   echo $customerLog;
			    	}?>
        	<h3>Existing Customers</h3>
        	<p>Sign in with the form below.</p>
        	<form action="" method="post" >
                	<input type="text" name="email" placeholder="E-mail">
                    <input type="text" name="password" placeholder="Password" >
                 <div class="buttons"><div><button class="grey" name="login">Sign In</button>
                 </div></div>
                </div>
             </form>
                   
    <?php
   
   if($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['register'])){
    $customerReg=$customer->customerRegist($_POST);
    }
    ?>
    	<div class="register_account">
    		<?php
             if (isset($customerReg)) {
			    		echo $customerReg;
			    	}
    		?>
    		<h3>Register New Account</h3>
    		<form action=""method="post" >
		   			 <table>
		   				<tbody>
			<tr>
				<td>
					<div><input type="text" name="name" placeholder="Name"></div>
					
					<div><input type="text" name="city" placeholder="City" ></div>
					
					<div><input type="text"  name="zip" placeholder="Zip-Code"></div>
					<div><input type="text" name="email" placeholder="E-mail"></div>
    			 </td>
    			<td>
			<div><input type="text" name="address" placeholder="Address"></div>
    		<div><input type="text" name="country" placeholder="Country"></div>		        
		    <div><input type="text" name="phone" placeholder="Phone" > </div>
           <div><input type="text" name="password" placeholder="Password" ></div>
		    	</td>
		 </tr> 
		    </tbody>
		</table> 
		   <div class="search"><div><button name="register" class="grey">Create Account</button></div></div>
		    <div class="clear"></div>
		    </form>
    	</div>  	
       <div class="clear"></div>
    </div>
 </div>
<?php include('include/footer.php'); ?>