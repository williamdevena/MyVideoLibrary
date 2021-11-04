<?php 

// SE L' UTENTE NON E' LOGGATO VIENE REINDIRIZZATO ALLA INDEX
session_start(); 
if (!isset($_SESSION["id"])) {
    header("Location: ../index.php");
}

require "../add/functions.php";  // PER USARE convert_string() che mette la \ prima delle apici nelle stringhe


// CREDENZIALI PER CONNETTERSI AL SERVER
$servername = "sql313.epizy.com";
$username = "epiz_28429607";
$password = "67bRC4AHG7eB0";

// CREA CONNESSIONE
$conn = mysqli_connect($servername, $username, $password);
if (!$conn) {
    echo "Connessione fallita";
}


if ($_POST["ricerca_per"]=="attore") {
    // QUERY RICERCA PER ATTORE

    $sql="select *
    from epiz_28429607_test.Film as Film, (select film from epiz_28429607_test.recitazione as recitazione, (select id from epiz_28429607_test.Persona as Persona where Persona.nome like '%{$_POST["inputCerca"]}%') as attore where recitazione.persona=attore.id) as filmPresi, (select film from epiz_28429607_test.possiede as possiede where possiede.utente='{$_SESSION["id"]}') as Codici
    where Film.id=filmPresi.film and Film.id=Codici.film;";


}
else if ($_POST["ricerca_per"]=="regista") {
    // QUERY RICERCA PER REGISTA

    $sql="select *
    from epiz_28429607_test.Film as Film, (select film from epiz_28429607_test.direzione as direzione, (select id from epiz_28429607_test.Persona as Persona where Persona.nome like '%{$_POST["inputCerca"]}%') as regista where direzione.persona=regista.id) as filmPresi, (select film from epiz_28429607_test.possiede as possiede where possiede.utente='{$_SESSION["id"]}') as Codici
    where Film.id=filmPresi.film and Film.id=Codici.film;";

}
else {
    // QUERY RICERCA PER TITOLO

    $sql="select * from epiz_28429607_test.Film as Film, (select film from epiz_28429607_test.possiede as possiede where possiede.utente='{$_SESSION["id"]}') as Codici where Film.titolo like '%{$_POST["inputCerca"]}%' and Film.id=Codici.film;";
}

$array = array();
$result = mysqli_query($conn, $sql);

while($row = $result->fetch_array(MYSQLI_NUM)) {    
    array_push($array, array($row[0], $row[1], $row[2], $row[3],$row[4],$row[5],$row[6],$row[7],$row[8],$row[9],$row[10]));
}

end:

?>

<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title> Cerca - MyVideoLibrary</title>
        <link rel="icon" type="image/png" href="../images/favicon.ico"/>
        
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="./style_modal.css">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap" rel="stylesheet">
        <style>
            .container_ {
                height: 80px;
                margin-top: -18px;
            }
        </style>

        <script src="//code.jquery.com/jquery-3.5.0.js"></script>
        <script type="text/javascript">
            
            $(document).ready(function() {
                    <?php foreach ($array as $film) { 

                            // IMMAGINI DEI FILM 
                            if ($film[8]=="") { ?>
                                $("#divFilm").append("<a href=\"#\"><img src=\"../images/no_image.jpeg\" width=\"150\" height=\"300\" class=\"immagineFilm\"></a>");
                             <?php } else { ?>
                                $("#divFilm").append("<a href=\"#\"><img src=\"<?php echo $film[8]; ?>\" width=\"150\" height=\"300\" class=\"immagineFilm\" id=\"<?php echo $film[0]; ?>\"></a>");   
                             <?php } 


                             // VISTA MODALE

                             $id=convert_string($film[0]);
                             $titolo=convert_string($film[2]);
                             $anno=convert_string($film[3]);
                             $durata=convert_string($film[4]);
                             $des=convert_string($film[5]);
                             $genere=convert_string($film[6]);
                             $valutazione=convert_string($film[7]);
                             $poster=convert_string($film[8]);
                             $sfondo=convert_string($film[9]);

                             ?>

                             var id=<?php echo $id; ?>;
                             var titolo=<?php echo $titolo; ?>;
                             var anno=<?php echo $anno; ?>;
                             var durata=<?php echo $durata; ?>;
                             var des=<?php echo $des; ?>;
                             var genere=<?php echo $genere; ?>;
                             if (<?php echo $valutazione; ?>=="") {
                                var valutazione="n.d."
                             } else {
                                var valutazione=<?php echo $valutazione; ?>;
                             }                        
                             var poster=<?php echo $poster; ?>;
                             var sfondo=<?php echo $sfondo; ?>;

                             // PER OGNI FILM VIENE AGGIUNTA UNA MODALE CHE PERO E' NASCOSTA (DISPLAY: NONE)
                             $("body").append("<div class=\"modale\" id=\"modale_"+id+"\"><div class=\"modaleBox\" id=\"modaleBox\"><img src=\""+sfondo+"\"><a href=\"#\" class=\"close\"></a><table><tr><td colspan=\"3\" class=\"title\"><h2>"+titolo+"</h2></td></tr><tr><td class=\"desField\" rowspan=\"4\"><div>"+des+"</div></td><td class=\"field\">Anno:<hr>"+anno+"</td><td class=\"field fieldGenere\">Genere:<hr>"+genere+"</td></tr><tr><td class=\"field fieldDurata\">Durata:<hr>"+durata+" minuti</td><td class=\"field fieldValutazione\">Valutazione personale:<hr>"+valutazione+"</td></tr><tr><td class=\"field\"><form class=\"form_id\" method=\"POST\" action=\"../edit/index.php\"><input name=\"film_id\" style=\"display: none\" value=\""+id+"\"><input class=\"submit_button\" type=\"submit\" value=\"Modifica\"></form></td></tr></table></div></div>");

                         <?php } ?>   


                // APERTURA MODALE SU UN CLICK SU UN IMMAGINE
                $(".immagineFilm").click(function() {
                    $(this).fadeOut("fast", function () {$("#modale_"+$(this).attr("id")).show(); $(this).fadeIn();});
                });  

                // CHIUSURA MODALE SU CLICK SULLA X
                $(".close").click(function() { $(".modale").hide(); });  

         
            });

        </script>

    </head>
    <body>
        <header>
            <input type="checkbox" id="chk1">
            <div class="logo">
                <h2 style="font-size: 150%"><a href="../homepage/homepage.php">MyVideoLibrary</a></h2>
            </div>
            <ul>
                <li><a href="../add/index.php">Aggiungi</a></li>
                <li><a href="#">Cerca</a></li>
                <li><a href="../profilo/profilo.php">Profilo</a></li>
                <li><a href="../login/logout.php">Logout</a></li>
                <label for="chk1" class="menu-close">
                    <i class="bi bi-x"></i>
                </label>
            </ul>
            <label for="chk1" class="menu-open">
                <i class="bi bi-list"></i>
            </label>
        </header>
        <h2 class="titolo">Cerca tra i tuoi film</h2>   
        <form action="cerca.php" method="post" name="cerca">
            <div class="divCerca" id="divCerca">
                <div class="barraCerca">
                    <div class="divInputCerca">
                        <label for="inputNome" class="labelProfilo">Cerca: </label>
                        <input type="text" class="inputCerca" name="inputCerca" id="inputCerca" required>
                    </div>         
                    <div class="divRicercaPer">
                        <p>Ricerca per:</p>
                    </div>
                    <div class="divRadio1">
                        <input type="radio" class="bottoneRadio1" id="titolo" name="ricerca_per" value="titolo" checked="checked">
                        <label for="titolo" class="labelRicerca">Titolo</label><br>
                    </div>
                    <div class="divRadio2">
                        <input type="radio" class="bottoneRadio2" id="regista" name="ricerca_per" value="regista">
                        <label for="regista" class="labelRicerca">Regista</label><br>
                    </div>
                    <div class="divRadio3">
                        <input type="radio" class="bottoneRadio3" id="attore" name="ricerca_per" value="attore">
                        <label for="attore" class="labelRicerca">Attore</label><br>
                    </div>
                    <div class="divBottoneCerca">
                        <button type="submit"  class="bottoneCerca" id="submitButton">Vai</button>
                    </div>          
                </div>  
                <div class="divFilm" id="divFilm">
                    <!-- QUI VANNO LE IMMAGINI CHE VENGONO CARICATE NELLE RIGHE 86-89-->                 
                </div>           
            </div>
        </form>	  
    </body>
</html>