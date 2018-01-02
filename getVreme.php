<?php
 
    use Cmfcmf\OpenWeatherMap;
    use Cmfcmf\OpenWeatherMap\Exception as OWMException;
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
    
            array_push($result,array('vlaznostH'=>$vlaznost));
            array_push($result,array('tempH'=>$temp));
            array_push($result,array('pritiskH'=>$pritisk));
            
            require 'vendor/vendor/autoload.php';

            // Language of data (try your own language here!):
            $lang = 'en';

            // Units (can be 'metric' or 'imperial' [default]):
            $units = 'metric';

            // Create OpenWeatherMap object. 
            // Don't use caching (take a look into Examples/Cache.php to see how it works).
            $owm = new OpenWeatherMap('53d3e9d10a6ecc145d1f52b15503af75');

            try {
                $weather = $owm->getWeather(array('lat' => $lat, 'lon' => $lon), $units, $lang);
            } catch(OWMException $e) {
                echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
            } catch(\Exception $e) {
                echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
            }

            array_push($result,array('vlaznost'=>$weather->humidity->getValue()));
            array_push($result,array('temp'=>$weather->temperature->getValue()));
            array_push($result,array('pritisk'=>$weather->pressure->getValue()));
            array_push($result,array('ikona'=>$weather->weather->id));
            //array_push($result,array('sunrise'=>$weather->sun->rise->format('dmy')));
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