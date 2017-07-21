<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/php/db.php';
	
	$category = $_GET['category'];
	
	$link = mysqli_connect($host,$user,$password,$database) or die(mysqli_error($link));
	
	$query = "SELECT id,`nl-NL`,`en-GB`,img FROM pictogram join `pictogram_category` on id=pictogram_id where category_id=$category order by usage_number DESC";
	$result = mysqli_query($link,$query) or die(mysqli_error($link));
	
	if($result){
		while ($row = mysqli_fetch_row($result)):?>
			<div class="pictogram" data-pic-id="<?=$row[0]?>" data-nl-NL="<?=$row[1]?>" 
                        data-en-GB="<?=$row[2]?>" data-audible-nl-NL="<?=$row[1]?>" data-audible-en-GB="<?=$row[2]?>">
                            <img src="dutch/<?=$row[3]?>" alt="<?=$row[2]?>">
                            <p><?=$row[2]?></p>
                        </div>
		<?endwhile;
	}
	mysqli_close($link);
?>