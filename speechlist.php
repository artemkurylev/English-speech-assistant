<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>English speech</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">

        <?php
            require_once 'php/db.php';
        ?>

    </head>
    <body>
        <div class="container">
            <?php
                $link = mysqli_connect($host,$user,$password,$database) or die(mysqli_error($link));
                $query = "SELECT id,name FROM speech WHERE user_id=1";
                $result = mysqli_query($link,$query);
                while($row = mysqli_fetch_row($result)){
                    echo '<div class="speech-row">';
                    echo "<div class=\"speech\" data-speech=\"$row[0]\">";
                    echo "<a href=\"index.php?speech_id=$row[0]\">";
                    $pictos = split(',',$row[1]);
                    foreach ($pictos as $pic) {
                        $res = mysqli_query($link,"SELECT img FROM pictogram WHERE id=$pic");
                        $img = 'dutch/' . mysqli_fetch_row($res)[0];
                        //print_r(mysqli_fetch_row($res)[0]);
                        echo "<div class=\"pictogram\"><img src=\"$img\"></div>";
                    }
                    echo '</a>';
                    echo '</div>';
                    echo '<div class="delete"> <img src="img/delete.svg"> </div>';
                    echo "</div>";
                }
                mysqli_close($link);
            ?>
            
            <div id="create">
                <a href="index.php">
                <img src="img/create.png">
                </a>
            </div>
        </div>
        
        <!-- jQuery -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="js/bootstrap.min.js"></script>
        <script src="js/speechlist.js"></script>
    </body>
</html>
