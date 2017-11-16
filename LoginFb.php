<?php    
    $con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
    /* check connection */
    if (!$con) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

    $username = $_POST["username"];
    $email = $_POST["email"];
    
    $statement = mysqli_prepare($con, "SELECT * FROM user WHERE username = ?");
    mysqli_stmt_bind_param($statement, "s", $username);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_store_result($statement);
    $response = array();
    $response = false; 
    if(isset($username)){
        if(mysqli_stmt_num_rows($statement)==1){
            mysqli_stmt_bind_result($statement, $id, $username, $email, $password, $score);
            mysqli_stmt_fetch($statement);
            $response = true."-".$score;
        }else{
            $password = "asd";
            $statement = mysqli_prepare($con, "INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
            mysqli_stmt_bind_param($statement, "sss", $username, $email, $password);
            mysqli_stmt_execute($statement);
            $response = true."-10";  
        }
    }
    
    echo json_encode($response);
?>
