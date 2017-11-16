<?php
 
	 $con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
	 
	 $username = $_POST['username'];
	 $sql_query = "SELECT id FROM user WHERE username = '$username';";
	 $result = mysqli_query($con, $sql_query);

	if(mysqli_num_rows($result) > 0 ){
		 $row = mysqli_fetch_assoc($result);
		 $user_id =  $row['id'];
		 $sql = "SELECT s.id AS id,s.seznamGob AS seznamGob, SUM(su.ocena) AS ocena, s.datum AS datum, s.odobreno AS odobreno FROM slika s INNER JOIN slika_user su ON s.id=su.slika_id GROUP BY s.id,s.seznamGob ORDER BY SUM(su.ocena) DESC ";
		 
		 $res = mysqli_query($con,$sql);
		 
		 
		 $result = array();
		 
		 $url = "https://jazgobar.000webhostapp.com/AndroidUploadImage/getImage.php?id=";
		 while($row = mysqli_fetch_array($res)){
		 	if(strtotime($row['datum']) <= time() - (60*60*24*7)){//7 dni(60 secs * 60 mins * 24 hours * 7 days)
		 		if(($row['odobreno']==0 && $row['ocena']>0)||($row['odobreno'!=0])){
		 			$ocena=-1;
		 			if($row['odobreno']==0 || $row['odobreno']==1){
		 				$ocena=1;
		 			}
		 			array_push($result,array('url'=>$url.$row['id'], 'seznamGob'=>$row['seznamGob'], 'ocena'=>$ocena, 'id'=>$row['id']));
		 		}
			}
		 }
		 
		 echo json_encode(array("result"=>$result));
		 
		 mysqli_close($con);
	}
 ?>