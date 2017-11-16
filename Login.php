<?php    
    $con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
    /* check connection */
    if (!$con) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $username = $_POST["username"];
    $password = $_POST["password"];
    
    $statement = mysqli_prepare($con, "SELECT * FROM user WHERE username = ? AND password = ?");
    mysqli_stmt_bind_param($statement, "ss", $username, $password);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $id, $username, $email, $password, $score);
    
    $response = array();
    $response["success"] = false;  
    $response["fileExist"] = false;
    
    while(mysqli_stmt_fetch($statement)){
        $response["success"] = true;
        $response["username"] = $username;  
        $response["email"] = $email;
        $response["password"] = $password;
        $response["score"] = $score;
        $folder = "uploads/";
        $fileName = "jazgobar_".$username.".json";
        $path = $folder.$fileName;
        
        if(!empty($fileName)){
            if (file_exists($path)) {
                $response["fileExist"] = true;
            } 
        }
    }
    
    echo json_encode($response);
?>
