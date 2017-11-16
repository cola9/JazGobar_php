<?php
 
	 $con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
	 
	 $username = $_POST['username'];
	 $sql_query = "SELECT id FROM user WHERE username = '$username';";
	 $result = mysqli_query($con, $sql_query);

	if(mysqli_num_rows($result) > 0 ){
		 $row = mysqli_fetch_assoc($result);
		 $user_id =  $row['id'];
		 $sql = "SELECT s.id AS id,s.seznamGob AS seznamGob,su.ocena AS ocena FROM slika s INNER JOIN slika_user su ON s.id=su.slika_id WHERE su.user_id ='$user_id' ORDER BY s.id DESC";
		 
		 $res = mysqli_query($con,$sql);
		 
		 
		 $result = array();
		 
		 $url = "https://jazgobar.000webhostapp.com/AndroidUploadImage/getImage.php?id=";
		 while($row = mysqli_fetch_array($res)){
		 array_push($result,array('url'=>$url.$row['id'], 'seznamGob'=>$row['seznamGob'], 'ocena'=>$row['ocena'], 'id'=>$row['id']));
		 }
		 
		 echo json_encode(array("result"=>$result));
		 
		 mysqli_close($con);
	}
 ?>