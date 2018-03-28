<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/php/db.php';

    $link = mysqli_connect($host,$user,$password,$database) or die(mysqli_error($link));

    $Login = $_POST["Login"];
    $Password = $_POST["Password"];

    $query = "SELECT * FROM masters WHERE `Login` = '$Login'";

    $result = mysqli_query($link,$query) or die (mysqli_error($link));
    $myrow = mysqli_fetch_row($result);
    if (empty($myrow[2]))
    {
        //если пользователя с введенным логином не существует
        exit ("Login or password are incorrect");
    }
    else {
        //если существует, то сверяем пароли
        if ($myrow[2] == $Password) {
            header("Location: ../MasterPage.php?authorized=true&masterId=$myrow[0]");

        } else {
            echo 'Incorrect login/password';
        }
    }
    mysqli_close($link);
?>