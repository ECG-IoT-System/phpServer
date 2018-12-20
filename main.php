<?php
	//$host = process.env.MYSQL_URL;
	//$uname = process.env.USERNAME;
	//$pwd = process.env.PASSWORD;
	$host = "mysql:unix_socket=/cloudsql/ecgproject-1069:ae86;dbname=ecg_test";
	$uname='root';
	$pwd='';

	try {
		$con =new PDO($host,$uname,$pwd);
	} catch (PDOException $e) {
		echo 'Connection failed: ' . $e->getMessage();
	}

	$jsonString=file_get_contents("php://input");
	$jArray = json_decode($jsonString, true);
	
	$sql = "INSERT INTO ecg_test.ECG_test(deviceID,time,data)VALUE ";
	$sql2 = "INSERT INTO ecg_test.Gsensor_test(deviceID,time,axisX,axisY,axisZ,ComVec)VALUE ";
	$i =-1;
	foreach($jArray as $data) // its a array of products you showed in json 
	{	
		if($i < 0)
			$count = $data[count];
		else if($i < $count)
			$valuesArr[] = "('$data[deviceid]', '$data[time]', '$data[data]')";
		else
			$valuesArr2[] = "('$data[gdeviceid]' , '$data[gtime]' , '$data[axisX]' , '$data[axisY]' , '$data[axisZ]' , '$data[ComVec]')";
		$i++;	
	}
	$sql .= implode(',', $valuesArr); 
	$sql2 .= implode(',', $valuesArr2);
	
	$result = $con->exec($sql);
	$result2 = $con->exec($sql2);
	//echo $count." ".$result." ".$result2;
	echo $count." / ".$result." / ".$result2;
	
	//mysql_close($con);
	
?>
