<?php 
    session_start();
    if (!isset($_SESSION["id"])) 
    {
        header("Location: ../login/login.php");
    }
    if (!isset($_POST["film_id"])) 
    {
        header("Location: ../homepage/homepage.php");
    }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="3;url=../homepage/homepage.php" />
    <title>Modifica Film</title>

    <!-- -------------- Stylesheets ------------- -->
    <link rel="icon" type="image/png" href="../images/favicon.ico"/>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <!-- ---------------- Scripts -------------- -->
    <script src="./functions.js"></script>
    <script>
        var display = "red";
        var message = "Error.";
        <?php
            require "../config.php";
            require "./functions.php";

            if ($ambiente == "home")
            {
                $servername = "";
                $db = "progettoweb";
                $username = "root";
                $password = "";
            }

            $film_id = $_POST["film_id"];

            $conn = mysqli_connect($servername, $username, $password);
            
            // deleting actors
            $sql = "delete from $db.recitazione where film = $film_id";
            mysqli_query($conn, $sql);

            // deleting director
            $sql = "delete from $db.direzione where film = $film_id";
            mysqli_query($conn, $sql);

            // deleting movie from user's movies
            $sql = "delete from $db.possiede where film = $film_id";
            mysqli_query($conn, $sql);
            
            // deleting movie information
            $sql = "delete from $db.Film where id = $film_id";
            mysqli_query($conn, $sql);
            
            echo "message = 'Film eliminato!';";
            echo "display = 'green';";

            end:
        ?>
    </script>
</head>
<body>
    <header>
        <h2>Modifica Film</h2>
    </header>
    <form name="mainForm" autocomplete="off" onsubmit="submitClick();">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="inputName">Nome del Film:</label>
                    <input type="text" class="form-control" name="inputName" id="inputName"  placeholder="Immetti il nome" required oninput="userInput = document.getElementById('inputName').value;">
                </div>
                <div class="form-group">
                    <label for="inputYear">Anno:</label>
                    <input type="number" min="1900" max="2099" class="form-control" name="inputYear" id="inputYear"  placeholder="Immetti l'anno" oninput="userYear = document.getElementById('inputYear').value">
                </div>
                <div class="form-group">
                    <label for="inputTime">Durata (minuti):</label>
                    <input type="number" min="0" class="form-control" name="inputTime" id="inputTime"  placeholder="Immetti la durata">
                </div>
                <div class="form-group">
                    <label for="inputDescription">Descrizione:</label>
                    <textarea class="form-control" name="inputDescription" id="inputDescription" cols="30" rows="10" placeholder="Immetti la descrizione"></textarea>
                </div>
            </div>
            <div class="col">
                <div class="form-group">
                    <label for="inputGenere">Genere:</label>
                    <select class="form-control" name="inputGenere" id="inputGenere">
                        <option value="none">Scegli un genere</option>
                        <option value="animazione">Animazione</option>
                        <option value="avventura">Avventura</option>
                        <option value="azione">Azione</option>
                        <option value="biografico">Biografico</option>
                        <option value="commedia">Commedia</option>
                        <option value="crime">Crime</option>
                        <option value="documentario">Documentario</option>
                        <option value="drammatico">Drammatico</option>
                        <option value="family">Family</option>
                        <option value="fantascienza">Fantascienza</option>
                        <option value="fantasy">Fantasy/Fantastico</option>
                        <option value="fiction">Fiction</option>
                        <option value="guerra">Guerra</option>
                        <option value="horror">Horror</option>
                        <option value="mistero">Mistero</option>
                        <option value="musical">Musical</option>
                        <option value="romantico">Romantico</option>
                        <option value="storico">Storico</option>
                        <option value="thriller">Thriller</option>
                        <option value="western">Western</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputRegia">Regia:</label>
                    <input type="text" class="form-control" name="inputRegia" id="inputRegia"  placeholder="Immetti i nomi separati da virgole">
                </div>
                <div class="form-group">
                    <label for="inputActors">Attori:</label>
                    <input type="text" class="form-control" name="inputActors" id="inputActors"  placeholder="Immetti i nomi separati da virgole">
                </div>
                <div class="form-group">
                    <div class="div_rating">
                        <label for="inputRating">Valutazione:</label> <label id="label_rating" for="inputRating">2.5/5</label>
                        <input type="range" class="form-control-range" name="inputRating" id="inputRating" min="0" max="10" oninput="document.getElementById('label_rating').innerHTML = document.getElementById('inputRating').value/2 + '/5';">
                    </div>
                    <div class="div_visto_nonvisto">
                        <button type="button" class="btn btn-switch" id="btn_nonvisto" onclick="nonvistoClick();">Non visto</button>
                        <button type="button" class="btn btn-switch" id="btn_visto" onclick="vistoClick();">Visto</button>
                        <input type="radio" class="radio_visto_nonvisto" name="radio_visto_nonvisto" value="visto">
                        <input type="radio" class="radio_visto_nonvisto" name="radio_visto_nonvisto" value="non_visto">
                        <script>
                            nonvistoClick();
                        </script>
                    </div>
                </div>
                <div class="image">
                    <div class="form-group">
                        <label for="inputImage" name="labelII" id="labelII">Immagine di copertina:</label>
                    </div>
                    <div class="coverImage" id="coverImage">
                        <img id="poster_img" src="" alt="">
                    </div>
                </div>
            </div>
        </div>
            <div class="buttons">
                <button type="reset" class="btn btn-primary formButton" id="resetButton" onclick="reset_();">Reset</button>
                <button type="submit" class="btn btn-primary formButton" id="submitButton" name="submitButton" onclick="submitClick();">Modifica</button>

            </div>
            <input type="text" class="inputImages" name="posterImage" id="posterImage">
            <input type="text" class="inputImages" name="backdropImage" id="backdropImage">
    </form>
    <div class="alert alert-success" id="alert" role="alert">
           
    </div>
    <div class="alert alert-info" id="alertRedirect" role="alert">
           Ti stiamo reindirizzando alla Homepage...
    </div>
    <script>
        if (display == "red")
            document.getElementById("alert").setAttribute("class", "alert alert-danger");
        else if (display == "green")
            document.getElementById("alert").setAttribute("class", "alert alert-success");
        else if (display == "none")
            document.getElementById("alert").style.display = "none";
        
        document.getElementById("alert").innerHTML = message;
    </script>
</body>
</html>