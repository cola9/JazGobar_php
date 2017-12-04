<?php
 
    if($_SERVER['REQUEST_METHOD']=='POST'){
         $lon = $_POST['lon'];
         $lat = $_POST['lat'];

        $con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
        $sql_query = "SELECT * FROM mesta";

        $res = mysqli_query($con,$sql_query);
        $mesto_id=0;
        $razlika=100000000;
        while($row = mysqli_fetch_array($res)){
            $lonRaz=$lon-$row['lon'];
            $latRaz=$lat-$row['lat'];
            $skupajRaz=abs($latRaz)+abs($lonRaz);
            if($skupajRaz<$razlika){
                $razlika=$skupajRaz;
                $mesto_id=$row['id'];
            }
        }
        $sql_query2 = "SELECT * FROM vreme WHERE mesto_id = '$mesto_id' ORDER BY datum DESC LIMIT 1;";//limit 1 OFFSET 2(skipa 2)
        $result = mysqli_query($con, $sql_query2);
        if(mysqli_num_rows($result) > 0 ){
            $row = mysqli_fetch_assoc($result);
            $vlaznost =  $row['vlaznost'];  
            $temp =  $row['temperatura'];  
            $pritisk =  $row['pritisk'];  
            $result = array();
    
            array_push($result,array('vlaznost'=>$vlaznost));
            array_push($result,array('temp'=>$temp));
            array_push($result,array('pritisk'=>$pritisk));
    
            echo json_encode(array("result"=>$result));
        }
       if($razlika>10){
	    $statement = mysqli_prepare($con, "INSERT INTO mesta (lat, lon) VALUES (?, ?)");
	    $fLat=(float) $lat;
	    $fLon=(float) $lon;
	    mysqli_stmt_bind_param($statement, "dd", $fLat, $fLon);
	    mysqli_stmt_execute($statement);
       }
        mysqli_close($con);
    }else{
        $response["success"] = false;  
        echo json_encode($response);
        echo "Error";
    }
?>