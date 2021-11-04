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
    <title>Modifica Film</title>

    <!-- -------------- Stylesheets ------------- -->
    <link rel="icon" type="image/png" href="../images/favicon.ico"/>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <!-- ---------------- Scripts -------------- -->
    <script src="./functions.js"></script>
    <script>
        var id = null;
        var titolo = null;
        var anno = null;
        var durata = null;
        var descrizione = null;
        var genere = null;
        var valutazione = null;
        var poster = null;
        var sfondo = null;
        var visto = null;
        var regia = null;
        var attori = null;
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

            // Create connection
            $conn = mysqli_connect($servername, $username, $password);
            $id = $_POST["film_id"];

            // $id = 68; // film id

            echo "id = $id;";

            // getting movie information
            $sql = "select * from $db.Film where id = $id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_assoc($result))
                {
                    echo "titolo = " . convert_string($row["titolo"]) . ";";
                    echo ($row["anno"] != null) ? "anno = '{$row["anno"]}';" : "";
                    echo ($row["durata"] != null) ? "durata = '{$row["durata"]}';" : "";
                    echo ($row["descrizione"] != null) ? "descrizione = " . convert_string($row["descrizione"]) . ";" : "";
                    echo ($row["genere"] != null) ? "genere = '{$row["genere"]}';" : "";
                    echo ($row["valutazione"] != null) ? "valutazione = {$row["valutazione"]};" : "";
                    echo ($row["poster"] != null) ? "poster = '{$row["poster"]}';" : "";
                    echo ($row["sfondo"] != null) ? "sfondo = '{$row["sfondo"]}';" : "";
                    echo ($row["visto"] != null) ? "visto = '{$row["visto"]}';" : "";
                }
            }

            // getting movie director
            $sql = "select persona from $db.direzione where film = $id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_assoc($result))
                {
                    $director_id = $row["persona"];
                    $sql2 = "select nome from $db.Persona where id = $director_id";
                    $result2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($result2) > 0)
                    {
                        while($row2 = mysqli_fetch_assoc($result2))
                        {
                            echo ($row2["nome"] != null) ? "regia = " . convert_string($row2["nome"]) . ";" : "";
                        }
                    }
                }
            }

            // getting movie actors
            $actors = "";
            $sql = "select persona from $db.recitazione where film = $id";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_assoc($result))
                {
                    $actor_id = $row["persona"];
                    $sql2 = "select nome from $db.Persona where id = $actor_id";
                    $result2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($result2) > 0)
                    {
                        while($row2 = mysqli_fetch_assoc($result2))
                        {
                            $actors .= $row2["nome"] . ", ";
                        }
                    }
                }
            }
            $actors = (strlen($actors) > 0) ? substr($actors, 0, -2) : $actors;
            echo "attori = " . convert_string($actors) . ";";
        ?>
    </script>
</head>
<body>
    <header>
        <h2>Modifica Film</h2>
    </header>
    <form name="mainForm" method="POST" action="./result.php" autocomplete="off" onsubmit="submitClick();">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="inputName">Nome del Film:</label> <input type="text" name="film_id" id="film_id" style="display:none">
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
            <a href="../homepage/homepage.php"><button type="button" class="btn btn-primary formButton">Annulla</button></a>
                <button type="submit" class="btn btn-primary formButton" id="submitButton" name="submitButton" onclick="submitClick();">Modifica</button>
            </div>
            <input type="text" class="inputImages" name="posterImage" id="posterImage">
            <input type="text" class="inputImages" name="backdropImage" id="backdropImage">
    </form>
    <form id="deleteForm" action="./delete.php" method="POST" onsubmit="return deleteConfirm()">
        <div id="deleteDiv">
            <input name="film_id" style="display: none">
            <script>
                deleteForm.film_id.value = id;
                function deleteConfirm()
                {
                    if (confirm("Eliminare il film '" + titolo +  "' dalla tua libreria?"))
                        return true;
                    return false;
                }
            </script>
            <button id="deleteButton" class="btn btn-primary">Elimina</button>
        </div>
    </form>
    <script>
        document.getElementById("film_id").value = id;
        document.getElementById("inputName").value = titolo;
        document.getElementById("inputYear").value = anno;
        document.getElementById("inputTime").value = durata;
        document.getElementById("inputDescription").value = descrizione;
        document.getElementById("inputGenere").value = genere;
        document.getElementById("posterImage").value = poster;
        document.getElementById("backdropImage").value = sfondo;
        if (visto == "1")
        {
            vistoClick();
            document.getElementById("inputRating").value = valutazione;
            document.getElementById('label_rating').innerHTML = valutazione/2 + "/5";
        }
        document.getElementById("inputRegia").value = regia;
        document.getElementById("inputActors").value = attori;

        // setting image 1 on screen
        resetImage1();
        if (poster != null)
        {
            document.getElementById("poster_img").setAttribute("src", poster);
            document.getElementById("coverImage").style.border = "0px";
            document.getElementById("poster_img").style.display = "inline";
        }

    </script>
</body>
</html>