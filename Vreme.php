<?php  

    use Cmfcmf\OpenWeatherMap;
    use Cmfcmf\OpenWeatherMap\Exception as OWMException;
    $con = mysqli_connect("localhost", "id2873074_jazgobar", "admin123", "id2873074_jazgobar");
    /* check connection */
    if (!$con) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    $mesta = array();
    $sql = "SELECT * FROM mesta";
		 
	$res = mysqli_query($con,$sql);
	while($row = mysqli_fetch_array($res)){
		//$row['id'],
        // Must point to composer's autoload file.
        require 'vendor/vendor/autoload.php';

        // Language of data (try your own language here!):
        $lang = 'en';

        // Units (can be 'metric' or 'imperial' [default]):
        $units = 'metric';

        // Create OpenWeatherMap object. 
        // Don't use caching (take a look into Examples/Cache.php to see how it works).
        $owm = new OpenWeatherMap('53d3e9d10a6ecc145d1f52b15503af75');

        try {
            $weather = $owm->getWeather($row['ime'], $units, $lang);
        } catch(OWMException $e) {
            echo 'OpenWeatherMap exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        } catch(\Exception $e) {
            echo 'General exception: ' . $e->getMessage() . ' (Code ' . $e->getCode() . ').';
        }
		$statement = mysqli_prepare($con, "INSERT INTO vreme (mesto_id, temperatura, pritisk, vlaznost) VALUES (?, ?, ?, ?)");
		mysqli_stmt_bind_param($statement, "isss", $row['id'], $weather->temperature, $weather->pressure, $weather->humidity);
		mysqli_stmt_execute($statement);
        echo $row['ime'].' '.$weather->temperature.' pritisk:'.$weather->pressure.' vlaznost:'.$weather->humidity."<br/>";
	}
 ?>