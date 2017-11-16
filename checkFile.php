<?php    
    $con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
    /* check connection */
    if (!$con) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $folder = "uploads/";
    $fileName = $_POST["fileName"];
    $path = $folder.$fileName;
    
    $response = array();
    $response = false;  
    if(!empty($_POST["fileName"])){
        if (file_exists($path)) {
            $response = true;
        } 
    }
    
    echo json_encode($response);
?>
