<?php
 
	if($_SERVER['REQUEST_METHOD']=='POST'){
		 $slika_id = $_POST['id'];
		 $username = $_POST['username'];
		 $ocena = $_POST['ocena'];

		 $con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
		 $sql_query = "SELECT id FROM user WHERE username = '$username';";
		$result = mysqli_query($con, $sql_query);
		if(mysqli_num_rows($result) > 0 ){
			$row = mysqli_fetch_assoc($result);
			$user_id =  $row['id'];
			if($ocena==-1){				
				/*$sqlDelete = "DELETE FROM slika_user WHERE slika_id = '$slika_id'";
				mysqli_query($con, $sqlDelete);
				$sql = "DELETE FROM slika WHERE id = '$slika_id'";*/
				$sql = "UPDATE slika SET odobreno=-1 WHERE id = '$slika_id'";
				if (mysqli_query($con, $sql)) {
	    			echo "Slika je ocenjena";
				} else {
				    echo "Error updating record: " . mysqli_error($con);
				}
			}else if($ocena==1){
				$sql = "UPDATE slika SET odobreno=1 WHERE id = '$slika_id'";
				if (mysqli_query($con, $sql)) {
	    			echo "Slika je ocenjena";
				} else {
				    echo "Error updating record: " . mysqli_error($con);
				}
			}
			mysqli_close($con);
	 	}
	}else{
	 	echo "Error";
	}
?>