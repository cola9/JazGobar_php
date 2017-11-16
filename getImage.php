<?php
 
	if($_SERVER['REQUEST_METHOD']=='GET'){
		 $id = $_GET['id'];
		 $sql = "SELECT * From slika WHERE id = '$id'";

		 $con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
		 $r = mysqli_query($con,$sql);
		 
		 $result = mysqli_fetch_array($r);
		 
		 header('content-type: image/jpeg');
		 
		 echo base64_decode($result['url']);
		 
		 mysqli_close($con);
	 
	}else{
	 	echo "Error";
	}
?>