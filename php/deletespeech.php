<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/php/db.php';
    $link = mysqli_connect($host,$user,$password,$database) or die(mysqli_error($link));
      
    $speech_id = $_GET['id'];
    $query = "DELETE FROM speech WHERE id=$speech_id";
    mysqli_query($link,$query);
    mysqli_close($link);
?>
