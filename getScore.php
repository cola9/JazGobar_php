<?php
 
	if($_SERVER['REQUEST_METHOD']=='POST'){
		 $username = $_POST['username'];

		 $con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
		 $sql_query = "SELECT score FROM user WHERE username = '$username';";
		$result = mysqli_query($con, $sql_query);
		if(mysqli_num_rows($result) > 0 ){
			$row = mysqli_fetch_assoc($result);
			$score =  $row['score'];  
			$result = array();
    
		    array_push($result,array('score'=>$score));
    
		 	echo json_encode(array("result"=>$result));
			mysqli_close($con);
	 	}
	}else{
   		$response["success"] = false;  
    	echo json_encode($response);
	 	echo "Error";
	}
?>