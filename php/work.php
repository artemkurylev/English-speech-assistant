<!DOCTYPE html>
<html>
<head>
<title>work</title>
<meta charset="utf-8">
</head>
<body>

<?php
	$host = 'localhost';
	$database = 'wainot_rs';
	$user = 'root';
	$password = '';
	
	$link = mysqli_connect($host,$user,$password,$database) or die(mysqli_error($link));
	
	/*$csv = fopen("dutch-eng.csv","r");
	while ($line = fgetcsv($csv)){
		$key = $line[0];
		$csvarray[$key][] = $line[1];
	}
	fclose($csv);*/
	
	$query = "select id,category_id from pictogram join wn_pictogram_img_category on id=img_id";
	$result = mysqli_query($link,$query) or die(mysqli_error($link));
	if($result){
		$found = 0;
		while($row = mysqli_fetch_row($result)){
			/*$dutch = str_replace('-',' ',$row[1]);
			echo '<b>' . $dutch . ': </b>';
			$img_name = $dutch . '.png';
			$img_d = fopen('dutch/' . $img_name,"r");
			if ($img_d) {
				if ($csvarray[$row[1]]){
					foreach($csvarray[$row[1]] as $english){
						$english = str_replace('_',' ',$english);
						$img_e = fopen('english/' . $english . '.png','r');
						if ($img_e) {
							echo 'found translation - <b>' . $english . '</b><br/> ';
							fclose($img_e);
							$query = "insert into pictogram values ($row[0],'$dutch','$english','$img_name',$row[2])";
							echo $query;
							mysqli_query($link,$query) or die (mysqli_error($link));
							break;
						}
					}
				}
				else echo ' no match in csv <br/>';
				/*$query = "insert into pictogram_category(id,`nl-NL`,img,usage_number) values ($row[0],'$row[1]','$img_name',$row[3])";
				$query = "insert into pictogram_category values ($row[0],$row[1])";
				mysqli_query($link,$query) or die(mysqli_error($link));
				fclose($img_d);
			} else echo 'no dutch pictogram';
			echo '<br/>';*/
			$query = "insert into pictogram_category values ($row[0],$row[1])";
			echo "$row[0] and $row[1] <br/>";
			mysqli_query($link,$query);// or die(mysqli_error($link));
		}
	}
	
	mysqli_close($link);
?>

</body>
</html>
