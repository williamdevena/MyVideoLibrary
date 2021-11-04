<?php 
    // SE L' UTENTE E' LOGGATO VIENE REINDIRIZZATO ALLA HOMEPAGE
    session_start(); 
    if (isset($_SESSION["id"])) {
        header("Location: ../homepage/homepage.php");
    }
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>MyVideoLibrary</title>
        <link rel="icon" type="image/png" href="../images/favicon.ico"/>
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="./style2.css">
        <link rel="stylesheet" href="./style_index.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">

        <script src="//code.jquery.com/jquery-3.5.0.js"></script>

        <script type="text/javascript">
            
            $(document).ready(function() {

                // BOTTONE "ACCEDI"
                $("#bottone1").click(function() {
                    window.location.href = "./login/login.php";
                });

                // BOTTONE "REGISTRATI SUBITO"
                $("#bottone2").click(function() {
                    window.location.href = "./registrazione/registrazione.php";
                });

                // CONTIENE LE IMMAGINI CHE SI ALTERNANO
                var array_film = [
                "./images/gladiatore.jpeg", 
                "./images/inception.jpg", 
                "./images/spiderman.jpeg", 
                "./images/superman.jpeg", 
                "./images/america.jpeg", 
                "./images/intoccabili.jpeg", 
                "./images/kill_bill.jpeg", 
                "./images/pulp_fiction.jpeg", 
                "./images/troy.jpeg",  
                "./images/xmen.jpeg", 
                "./images/interstellar.jpeg", 
                "./images/james_bond.jpeg", 
                "./images/mission_impossible.jpeg", 
                "./images/esorcista.jpeg", 
                "./images/io_robot.jpeg"
                ];

                var tempo=1000;

                // FUNZIONE CHE CAMBIA IL SRC DELL' IMMAGINE
                function cambiaFilm(i, film) {
                        setTimeout(function() {$("#immagine_alternare").attr("src", film);}, i);
                }


                for (var x = 0; x < 1000; x++) {
                    cambiaFilm(tempo*(x+1), array_film[x%array_film.length]);
                }

            });

        </script>
    </head>
    <body class="index_body"> 
        <header>
            <input type="checkbox" id="chk1">
            <div class="logo">
                <h2 style="font-size: 150%">MyVideoLibrary</h2>
            </div>
            <ul>
                <li><a href="./login/login.php">Login</a></li>
                <li><a href="./registrazione/registrazione.php">Registrazione</a></li>
                <label for="chk1" class="menu-close">
                    <i class="bi bi-x"></i>
                </label>
            </ul>
            <label for="chk1" class="menu-open">
                <i class="bi bi-list"></i>
            </label>
        </header>
        <div class="div_salva">
            <h2>Salva i tuoi film preferiti</h2>
            <p>Registrati su myVideoLibrary e salva tutti i tuoi DVD e cassette, cosi da poterli cercare, filtrare e scegliere quando vuoi e dove vuoi senza preoccupazioni.</p>
            <input type="submit" value="Registrati subito" name="Registrati_subito" id="bottone2" class="bottone_login">
            <input type="submit" value="Accedi" name="Accedi" id="bottone1" class="bottone_login">
        </div>
        <div class="div_filtra">
            <h2>Filtra i tuoi film per attore, titolo o regista</h2>
            <img src="./images/io_robot.jpeg" id="immagine_alternare">
        </div>
        <div class="div_aggiungi">
            <h2>Aggiungi i tuoi film in un click</h2>
            <p>Scrivi solo il titolo e tutti le informazioni necessarie (anno, durata, trama, regista, attori, ...) veranno autocompilate in modo intelligente.</p>
        </div>

    </body>
</html>