<?php    
    $con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
    /* check connection */
    if (!$con) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $score=10;

    $statement = mysqli_prepare($con, "INSERT INTO user (username, email, password, score) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($statement, "sssi", $username, $email, $password, $score);
    mysqli_stmt_execute($statement);
    
    $response = array();
    $response["success"] = true;  
    
    echo json_encode($response);
?>
