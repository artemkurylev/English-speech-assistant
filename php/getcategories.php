<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/php/db.php';
	
	$link = mysqli_connect($host,$user,$password,$database) or die(mysqli_error($link));
	
	$query = "select * from category order by usage_number desc";
	$result = mysqli_query($link,$query) or die(mysqli_error($link));
	
	if($result){
		while ($row = mysqli_fetch_row($result)){
                    echo "<div class=\"pictogram category\" " . "data-category=\"$row[0]\" " .
			"data-nl-NL=\"$row[1]\" " . "data-en-GB=\"$row[2]\"> " .
			"<img src=\"dutch/$row[3]\" alt=\"$row[2]\"> " .
			"<p>$row[2]</p> " . "</div>";
		}
	}
	
	mysqli_close($link);
?>