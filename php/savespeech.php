<?php
	$host = 'localhost';
	$database = 'wainot_rs';
	$user = 'root';
	$password = '';
	
	$link = mysqli_connect($host,$user,$password,$database) or die(mysqli_error($link));
	
        if(isset($_POST['speech_id'])){
            $speech_id = $_POST['speech_id'];
        } else {
            mysqli_query($link,"INSERT INTO speech (user_id) VALUES (1)") or die(mysqli_error($link));
            $result = mysqli_query($link,"SELECT id FROM speech ORDER BY id DESC LIMIT 1") or die(mysqli_error($link));
            $row = mysqli_fetch_row($result);
            $speech_id = $row[0];
        }
	$name = $_POST['name'];
        $file = $speech_id . '.txt';
	$speech = $_POST['speech'];
        
        $query = "UPDATE speech SET name='$name',file='$file' WHERE id=$speech_id";
        mysqli_query($link,$query);
        
	$fd = fopen("speeches/" . $file,"w");
	fwrite($fd,$speech);
	fclose($fp);
        
	mysqli_close($link);
?>