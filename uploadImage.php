  <?php  
 
	if($_SERVER['REQUEST_METHOD']=='POST'){
		 $username = $_POST['username'];
		 $seznamGob = $_POST['seznamGob'];
	 
	 $image = $_POST['image'];
	 
    $con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
	 
	$sql_query = "SELECT id FROM user WHERE username = '$username';";
	$result = mysqli_query($con, $sql_query);
	if(mysqli_num_rows($result) > 0 ){
		$row = mysqli_fetch_assoc($result);
		$user_id =  $row['id'];

		$date = new DateTime();
		$sql = "INSERT INTO slika (user_id, seznamGob, url) VALUES (?,?,?)";
		// $sql = "INSERT INTO images (image) VALUES (?)";
		 
		 $stmt = mysqli_prepare($con,$sql);
		 $time=$date->getTimestamp();
		 mysqli_stmt_bind_param($stmt,"sss",$user_id,$seznamGob,$image);
		 mysqli_stmt_execute($stmt);
		 
		 $check = mysqli_stmt_affected_rows($stmt);
		 
		 if($check == 1){
		 	echo "Image Uploaded Successfully";
		 	$sql_query2 = "SELECT id FROM user WHERE id != '$user_id';";
			$result2 = mysqli_query($con, $sql_query2);
			if(mysqli_num_rows($result2) > 0 ){
			 	while ($row2 = mysqli_fetch_array($result2))  
				{
					$sql_query3 = "SELECT MAX(id) AS id FROM slika;";
					$result3 = mysqli_query($con, $sql_query3);
					$row3= mysqli_fetch_assoc($result3);
					$sql3 = "INSERT INTO slika_user (slika_id, user_id, ocena) VALUES (?,?,?)";
			 		$stmt2 = mysqli_prepare($con,$sql3);
			 		$ocena="0";
			 		mysqli_stmt_bind_param($stmt2,"sss",$row3['id'],$row2['id'],$ocena);
			 		mysqli_stmt_execute($stmt2);
				}
			}
		 }else{
		 	echo "Error Uploading Image";
		 }
		 mysqli_close($con);
	 }
	}else{
		 echo "Error";
	}
	/*//Getting the server ip 
	$server_ip = gethostbyname(gethostname());
	
	//creating the upload url 
	$upload_url = 'http://'.$server_ip.'/AndroidImageUpload/'; 
	
	//response array 
	$response = array(); 
	
	
	if($_SERVER['REQUEST_METHOD']=='POST'){
		
		//checking the required parameters from the request 
		if(isset($_POST['username']) and isset($_FILES['image']['name'])){
			
			//connecting to the database 
    		$con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
			
			//getting name from the request 
			//$name = $_POST['name'];
			$username = $_POST['username'];
			$seznamGob = $_POST['seznamGob'];
			
			//getting file info from the request 
			$fileinfo = pathinfo($_FILES['image']['name']);
			
			//getting the file extension 
			$extension = $fileinfo['extension'];
			
			//file url to store in the database 
			$file_url = $upload_url . getFileName() . '.' . $extension;
			
			//file path to upload in the server 
			$file_path = getFileName() . '.'. $extension; 
			//het user id
			$sql_query = "SELECT id FROM user WHERE username = '$username';";
			$result = mysqli_query($con, $sql_query);

			if(mysqli_num_rows($result) > 0 ){
				$row = mysqli_fetch_assoc($result);
				$user_id =  $row['id'];
				//trying to save the file in the directory 
				try{
					//saving the file 
					move_uploaded_file($_FILES['image']['tmp_name'],$file_path);
					$sql = "INSERT INTO `slika` (`ime`, `user_id`, `url`, `seznamGob`) VALUES ('$file_path', $user_id, '$file_url', '$seznamGob');";
					
					//adding the path and name to database 
					if(mysqli_query($con,$sql)){
						
						//filling response array with values 
						$response['error'] = false; 
						$response['url'] = $file_url; 
						$response['name'] = $file_path;
					}
				//if some error occurred 
				}catch(Exception $e){
					$response['error']=true;
					$response['message']=$e->getMessage();
				}		
				//displaying the response 
				echo json_encode($response);
				
				//closing the connection 
				mysqli_close($con);
			}
		}else{
			$response['error']=true;
			$response['message']='Please choose a file';
		}
	}
	
	/*
		We are generating the file name 
		so this method will return a file name for the image to be upload 
	*/
	function getFileName(){
    	$con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
		$sql = "SELECT max(id) as id FROM slika";
		$result = mysqli_fetch_array(mysqli_query($con,$sql));
		
		mysqli_close($con);
		if($result['id']==null)
			return 1; 
		else 
			return ++$result['id']; 
	}
	?>