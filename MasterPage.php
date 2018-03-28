<!DOCTYPE html>


<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Master Mode</title>

        <!-- Bootstrap -->
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
		<!-- Manifest -->
		<link rel="manifest" href="/manifest.webmanifest">


        <?php
        require_once 'php/db.php';
        if (isset($_GET['speech_id'])) {
            $speech_id = $_GET['speech_id'];
        } else {
            $speech_id = -1;
        }
        echo "<script>var speech_id = $speech_id </script>";
        ?>
        <?php if(isset($_GET['authorized']) != true){
            echo"You are not authorized to see this page";
            exit();
        }?>

    </head>


    <body>
        <div class="container">
            <div class="row">
                <div class="col-sm-2 col-xs-6 sidebar">
                    <div id="language-panel">
                        <img src="img/flag_en.png" alt="en-GB" class="language active-language img-circle">
                        <br/>
                        <img src="img/flag_nl.png" alt="nl-NL" class="img-circle language">
                    </div>
                    <div id="menu-panel">
                        <div id="save">
                            <img src="img/save.png" alt="save">
                        </div>
                        <br/>
                        <div id="speeches">
                            <a href="speechlist.php?mode=1">
                                <img src="img/speeches.svg" alt="speeches">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-9 col-xs-6">
                    <div class="row">
                        <div class="panel panel-default">
                            <div id="input-field" class="panel-body normal"></div>
                        </div>
                    </div>
                    <div class="row keyboard-panel">
                        <div class="col-sm-10 col-xs-6" id="picto-grid">
                            <?php
                            require 'php/getcategories.php';
                            ?>
                        </div>
                        <div class="col-sm-2 col-xs-6" id="control-buttons">
                            <div id="delete">
                                <img src="img/delete.gif" alt="delete">
                            </div>
                            <br/>
                            <div id="newline">
                                <img src="img/enter.png" alt="newline">
                            </div>
                            <br/>
                            <div id="home">
                                <img src="img/home.jpg" alt="home">
                            </div>
                            <br/>
                            <div id="hide-keyboard">
                                <img src="img/hide.png" alt="hide">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- jQuery -->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!-- Bootstrap JS -->
        <script src="js/bootstrap.min.js"></script>
        <!-- Interact JS -->
        <script src="js/interact.min.js"></script>
        <!-- main code -->
        <script src="js/MasterMode.js"></script>

        <?php
        if($speech_id>0){
            $link = mysqli_connect($host,$user,$password,$database) or die(mysqli_error($link));
            $query = "SELECT * FROM speech WHERE id=$speech_id";
            $result = mysqli_query($link,$query) or die(mysqli_error($link));
            $row = mysqli_fetch_row($result);
            $filename = 'speeches/' . $row[3];

            $speech_str = file_get_contents($filename);

            echo "<script>var speech_str = $speech_str</script>";
            echo "<script src=\"js/loadspeech.js\"></script>";
        }
        ?>
    </body>
</html>