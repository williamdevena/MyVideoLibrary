<?php 
    session_start();
    if (!isset($_SESSION["id"])) 
    {
        header("Location: ../login/login.php");
    }
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>MyVideoLibrary - La Tua Videoteca Personale</title>
    <link rel="icon" type="image/png" href="../images/favicon.ico"/>
    
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <input type="checkbox" id="chk1">
        <div class="logo">
            <h2 style="font-weight: normal;">MyVideoLibrary</h2>
        </div>
        <ul>
            <li><a href="../add">Aggiungi</a></li>           
            <li><a href="../cerca/cerca.php">Cerca</a></li>
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
    <!-- <section> -->
    <div class="container" id="posterContainer">
            <?php
            require "../config.php";

            if ($ambiente == "home")
            {
                $servername = "";
                $db = "progettoweb";
                $username = "root";
                $password = "";
            }

            $user_id = $_SESSION["id"];

                // Create connection
            $conn = mysqli_connect($servername, $username, $password);

                // selecting movies for user
            $sql = "select film from $db.possiede where utente = '{$user_id}' limit 8";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_assoc($result))
                {
                    $film_id = $row["film"];

                        // getting movie's information
                    $sql2 = "select * from $db.Film where id = $film_id";
                    $result2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($result2) > 0)
                    {
                        while($row2 = mysqli_fetch_assoc($result2))
                        {
                            $form_name = "form_" . $film_id;
                            $title = $row2["titolo"];
                            $des = ($row2["descrizione"] != null) ? $row2["descrizione"] : "n.d";
                            $screenply = ($row2["durata"] != null) ? $row2["durata"] : "n.d";
                            $year = ($row2["anno"] != null) ? $row2["anno"] : "n.d";
                            $genre = ($row2["genere"] != null) ? ucfirst($row2["genere"]) : "n.d";
                            $rating = ($row2["valutazione"] != null) ? intval($row2["valutazione"])/2 . " / 5" : "n.d";
                            $sfondo = ($row2["sfondo"] != null) ? $row2["sfondo"] : "../images/default_backdrop.jpg";

                            // selecting director
                            $sql3 = "select nome from $db.direzione join $db.Persona where film = $film_id and id = persona";
                            $result3 = mysqli_query($conn, $sql3);
                            if (mysqli_num_rows($result3) > 0)
                            {
                                while($row3 = mysqli_fetch_assoc($result3))
                                {
                                    $director_name = $row3["nome"];
                                }
                            }
                            else
                                $director_name = "n.d";

                            // selecting actors
                            $actors = "";
                            $sql3 = "select nome from $db.recitazione join $db.Persona where film = $film_id and id = persona";
                            $result3 = mysqli_query($conn, $sql3);
                            if (mysqli_num_rows($result3) > 0)
                            {
                                while($row3 = mysqli_fetch_assoc($result3))
                                {
                                    $actors .= $row3["nome"] . ", ";
                                }
                                $actors = substr($actors, 0, -2);
                            }
                            // building html page
                            echo '<div class="slides">';
                            echo '<img src="' . $sfondo . '" alt="">';
                            echo '<div class="content">';
                            echo '<table>';
                            echo '<tr><td colspan="3" class="title"><h2>' . $title . '</h2></td></tr>';
                            echo '<tr><td class="desField" rowspan="4"><div>' . $des . '</div></td><td class="field">Anno:<hr>' . $year . '</td><td class="field fieldGenere">Genere:<hr>' . $genre . '</td></tr>';
                            echo '<tr><td class="field fieldDurata">Durata:<hr>' . $screenply . ' minuti</td><td class="field fieldValutazione">Valutazione personale:<hr>' . $rating . '</td></tr>';
                            echo '<tr><td class="field">Regia:<hr>' . $director_name . '</td><td class="field"><form class="' . $form_name . '" method="POST" action="../edit/index.php"><input name="film_id" style="display: none" value="' . $film_id .'"><a onclick="document.getElementsByClassName(\'' . $form_name . '\')[0].submit()"><i class="fa fa-play" aria-hidden="true"></i>Modifica</a></form></td></tr>';
                            echo '<tr><td class="field actorsField" colspan="2">Attori:<hr>'  . $actors .  '</td></tr>';
                            echo '</table>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                }
            }

            $sql = "select film from $db.possiede where utente = '{$user_id}'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                $x=0;
                while($row = mysqli_fetch_assoc($result) and $x<8)
                {
                    $film_id = $row["film"];

                    // getting movie's information
                    $sql2 = "select * from $db.Film where id = $film_id and genere=\"drammatico\"  ";
                    $result2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($result2) > 0)
                    {
                        $x++;
                        while($row2 = mysqli_fetch_assoc($result2))
                        {
                            $form_name = "form_" . $film_id;
                            $title = $row2["titolo"];
                            $des = ($row2["descrizione"] != null) ? $row2["descrizione"] : "n.d";
                            $screenply = ($row2["durata"] != null) ? $row2["durata"] : "n.d";
                            $year = ($row2["anno"] != null) ? $row2["anno"] : "n.d";
                            $genre = ($row2["genere"] != null) ? ucfirst($row2["genere"]) : "n.d";
                            $rating = ($row2["valutazione"] != null) ? intval($row2["valutazione"])/2 . " / 5" : "n.d";
                            $sfondo = ($row2["sfondo"] != null) ? $row2["sfondo"] : "../images/default_backdrop.jpg";

                            // selecting director
                            $sql3 = "select nome from $db.direzione join $db.Persona where film = $film_id and id = persona";
                            $result3 = mysqli_query($conn, $sql3);
                            if (mysqli_num_rows($result3) > 0)
                            {
                                while($row3 = mysqli_fetch_assoc($result3))
                                {
                                    $director_name = $row3["nome"];
                                }
                            }
                            else
                                $director_name = "n.d";

                            // selecting actors
                            $actors = "";
                            $sql3 = "select nome from $db.recitazione join $db.Persona where film = $film_id and id = persona";
                            $result3 = mysqli_query($conn, $sql3);
                            if (mysqli_num_rows($result3) > 0)
                            {
                                while($row3 = mysqli_fetch_assoc($result3))
                                {
                                    $actors .= $row3["nome"] . ", ";
                                }
                                $actors = substr($actors, 0, -2);
                            }
                            // building html page
                            echo '<div class="slides">';
                            echo '<img src="' . $sfondo . '" alt="">';
                            echo '<div class="content">';
                            echo '<table>';
                            echo '<tr><td colspan="3" class="title"><h2>' . $title . '</h2></td></tr>';
                            echo '<tr><td class="desField" rowspan="4"><div>' . $des . '</div></td><td class="field">Anno:<hr>' . $year . '</td><td class="field fieldGenere">Genere:<hr>' . $genre . '</td></tr>';
                            echo '<tr><td class="field fieldDurata">Durata:<hr>' . $screenply . ' minuti</td><td class="field fieldValutazione">Valutazione personale:<hr>' . $rating . '</td></tr>';
                            echo '<tr><td class="field">Regia:<hr>' . $director_name . '</td><td class="field"><form class="' . $form_name . '" method="POST" action="../edit/index.php"><input name="film_id" style="display: none" value="' . $film_id .'"><a onclick="document.getElementsByClassName(\'' . $form_name . '\')[0].submit()"><i class="fa fa-play" aria-hidden="true"></i>Modifica</a></form></td></tr>';
                            echo '<tr><td class="field">Attori:<hr>'  . $actors .  '</td></tr>';
                            echo '</table>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    
                }
            }

            $sql = "select film from $db.possiede where utente = '{$user_id}'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                $x=0;
                while($row = mysqli_fetch_assoc($result) and $x<8)
                {
                    $film_id = $row["film"];

                        // getting movie's information
                    $sql2 = "select * from $db.Film where id = $film_id and genere=\"fantascienza\" ";
                    $result2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($result2) > 0)
                    {
                        $x++;
                        while($row2 = mysqli_fetch_assoc($result2))
                        {
                            $form_name = "form_" . $film_id;
                            $title = $row2["titolo"];
                            $des = ($row2["descrizione"] != null) ? $row2["descrizione"] : "n.d";
                            $screenply = ($row2["durata"] != null) ? $row2["durata"] : "n.d";
                            $year = ($row2["anno"] != null) ? $row2["anno"] : "n.d";
                            $genre = ($row2["genere"] != null) ? ucfirst($row2["genere"]) : "n.d";
                            $rating = ($row2["valutazione"] != null) ? intval($row2["valutazione"])/2 . " / 5" : "n.d";
                            $poster = $row2["poster"];
                            $sfondo = ($row2["sfondo"] != null) ? $row2["sfondo"] : "../images/default_backdrop.jpg";

                            // selecting director
                            $sql3 = "select nome from $db.direzione join $db.Persona where film = $film_id and id = persona";
                            $result3 = mysqli_query($conn, $sql3);
                            if (mysqli_num_rows($result3) > 0)
                            {
                                while($row3 = mysqli_fetch_assoc($result3))
                                {
                                    $director_name = $row3["nome"];
                                }
                            }
                            else
                                $director_name = "n.d";

                            // selecting actors
                            $actors = "";
                            $sql3 = "select nome from $db.recitazione join $db.Persona where film = $film_id and id = persona";
                            $result3 = mysqli_query($conn, $sql3);
                            if (mysqli_num_rows($result3) > 0)
                            {
                                while($row3 = mysqli_fetch_assoc($result3))
                                {
                                    $actors .= $row3["nome"] . ", ";
                                }
                                $actors = substr($actors, 0, -2);
                            }
                            // building html page
                            echo '<div class="slides">';
                            echo '<img src="' . $sfondo . '" alt="">';
                            echo '<div class="content">';
                            echo '<table>';
                            echo '<tr><td colspan="3" class="title"><h2>' . $title . '</h2></td></tr>';
                            echo '<tr><td class="desField" rowspan="4"><div>' . $des . '</div></td><td class="field">Anno:<hr>' . $year . '</td><td class="field fieldGenere">Genere:<hr>' . $genre . '</td></tr>';
                            echo '<tr><td class="field fieldDurata">Durata:<hr>' . $screenply . ' minuti</td><td class="field fieldValutazione">Valutazione personale:<hr>' . $rating . '</td></tr>';
                            echo '<tr><td class="field">Regia:<hr>' . $director_name . '</td><td class="field"><form class="' . $form_name . '" method="POST" action="../edit/index.php"><input name="film_id" style="display: none" value="' . $film_id .'"><a onclick="document.getElementsByClassName(\'' . $form_name . '\')[0].submit()"><i class="fa fa-play" aria-hidden="true"></i>Modifica</a></form></td></tr>';
                            echo '<tr><td class="field">Attori:<hr>'  . $actors .  '</td></tr>';
                            echo '</table>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                }
            }

            $sql = "select film from $db.possiede where utente = '{$user_id}'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                $x=0;
                while($row = mysqli_fetch_assoc($result) and $x<8)
                {
                    $film_id = $row["film"];

                        // getting movie's information
                    $sql2 = "select * from $db.Film where id = $film_id and genere=\"commedia\" ";
                    $result2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($result2) > 0)
                    {
                        $x++;
                        while($row2 = mysqli_fetch_assoc($result2))
                        {
                            $form_name = "form_" . $film_id;
                            $title = $row2["titolo"];
                            $des = ($row2["descrizione"] != null) ? $row2["descrizione"] : "n.d";
                            $screenply = ($row2["durata"] != null) ? $row2["durata"] : "n.d";
                            $year = ($row2["anno"] != null) ? $row2["anno"] : "n.d";
                            $genre = ($row2["genere"] != null) ? ucfirst($row2["genere"]) : "n.d";
                            $rating = ($row2["valutazione"] != null) ? intval($row2["valutazione"])/2 . " / 5" : "n.d";
                            $poster = $row2["poster"];
                            $sfondo = ($row2["sfondo"] != null) ? $row2["sfondo"] : "../images/default_backdrop.jpg";

                            // selecting director
                            $sql3 = "select nome from $db.direzione join $db.Persona where film = $film_id and id = persona";
                            $result3 = mysqli_query($conn, $sql3);
                            if (mysqli_num_rows($result3) > 0)
                            {
                                while($row3 = mysqli_fetch_assoc($result3))
                                {
                                    $director_name = $row3["nome"];
                                }
                            }
                            else
                                $director_name = "n.d";

                            // selecting actors
                            $actors = "";
                            $sql3 = "select nome from $db.recitazione join $db.Persona where film = $film_id and id = persona";
                            $result3 = mysqli_query($conn, $sql3);
                            if (mysqli_num_rows($result3) > 0)
                            {
                                while($row3 = mysqli_fetch_assoc($result3))
                                {
                                    $actors .= $row3["nome"] . ", ";
                                }
                                $actors = substr($actors, 0, -2);
                            }
                            // building html page
                            echo '<div class="slides">';
                            echo '<img src="' . $sfondo . '" alt="">';
                            echo '<div class="content">';
                            echo '<table>';
                            echo '<tr><td colspan="3" class="title"><h2>' . $title . '</h2></td></tr>';
                            echo '<tr><td class="desField" rowspan="4"><div>' . $des . '</div></td><td class="field">Anno:<hr>' . $year . '</td><td class="field fieldGenere">Genere:<hr>' . $genre . '</td></tr>';
                            echo '<tr><td class="field fieldDurata">Durata:<hr>' . $screenply . ' minuti</td><td class="field fieldValutazione">Valutazione personale:<hr>' . $rating . '</td></tr>';
                            echo '<tr><td class="field">Regia:<hr>' . $director_name . '</td><td class="field"><form class="' . $form_name . '" method="POST" action="../edit/index.php"><input name="film_id" style="display: none" value="' . $film_id .'"><a onclick="document.getElementsByClassName(\'' . $form_name . '\')[0].submit()"><i class="fa fa-play" aria-hidden="true"></i>Modifica</a></form></td></tr>';
                            echo '<tr><td class="field">Attori:<hr>'  . $actors .  '</td></tr>';
                            echo '</table>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                }
            }

            $sql = "select film from $db.possiede where utente = '{$user_id}'";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                $x=0;
                while($row = mysqli_fetch_assoc($result) and $x<8)
                {
                    $film_id = $row["film"];

                        // getting movie's information
                    $sql2 = "select * from $db.Film where id = $film_id and genere=\"horror\" ";
                    $result2 = mysqli_query($conn, $sql2);
                    if (mysqli_num_rows($result2) > 0)
                    {
                        $x++;
                        while($row2 = mysqli_fetch_assoc($result2))
                        {
                            $form_name = "form_" . $film_id;
                            $title = $row2["titolo"];
                            $des = ($row2["descrizione"] != null) ? $row2["descrizione"] : "n.d";
                            $screenply = ($row2["durata"] != null) ? $row2["durata"] : "n.d";
                            $year = ($row2["anno"] != null) ? $row2["anno"] : "n.d";
                            $genre = ($row2["genere"] != null) ? ucfirst($row2["genere"]) : "n.d";
                            $rating = ($row2["valutazione"] != null) ? intval($row2["valutazione"])/2 . " / 5" : "n.d";
                            $poster = $row2["poster"];
                            $sfondo = ($row2["sfondo"] != null) ? $row2["sfondo"] : "../images/default_backdrop.jpg";

                            // selecting director
                            $sql3 = "select nome from $db.direzione join $db.Persona where film = $film_id and id = persona";
                            $result3 = mysqli_query($conn, $sql3);
                            if (mysqli_num_rows($result3) > 0)
                            {
                                while($row3 = mysqli_fetch_assoc($result3))
                                {
                                    $director_name = $row3["nome"];
                                }
                            }
                            else
                                $director_name = "n.d";

                            // selecting actors
                            $actors = "";
                            $sql3 = "select nome from $db.recitazione join $db.Persona where film = $film_id and id = persona";
                            $result3 = mysqli_query($conn, $sql3);
                            if (mysqli_num_rows($result3) > 0)
                            {
                                while($row3 = mysqli_fetch_assoc($result3))
                                {
                                    $actors .= $row3["nome"] . ", ";
                                }
                                $actors = substr($actors, 0, -2);
                            }
                            // building html page
                            echo '<div class="slides">';
                            echo '<img src="' . $sfondo . '" alt="">';
                            echo '<div class="content">';
                            echo '<table>';
                            echo '<tr><td colspan="3" class="title"><h2>' . $title . '</h2></td></tr>';
                            echo '<tr><td class="desField" rowspan="4"><div>' . $des . '</div></td><td class="field">Anno:<hr>' . $year . '</td><td class="field fieldGenere">Genere:<hr>' . $genre . '</td></tr>';
                            echo '<tr><td class="field fieldDurata">Durata:<hr>' . $screenply . ' minuti</td><td class="field fieldValutazione">Valutazione personale:<hr>' . $rating . '</td></tr>';
                            echo '<tr><td class="field">Regia:<hr>' . $director_name . '</td><td class="field"><form class="' . $form_name . '" method="POST" action="../edit/index.php"><input name="film_id" style="display: none" value="' . $film_id .'"><a onclick="document.getElementsByClassName(\'' . $form_name . '\')[0].submit()"><i class="fa fa-play" aria-hidden="true"></i>Modifica</a></form></td></tr>';
                            echo '<tr><td class="field">Attori:<hr>'  . $actors .  '</td></tr>';
                            echo '</table>';
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                }
            }


                    // continues after
            ?>

    </div>
    <div class="rowContainer">
        <div class="row" id="libraryRow">
            <h2>La Tua Libreria</h2>
                <?php
                $sql = "select film from $db.possiede where utente = '{$user_id}' limit 8";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0)
                {
                echo '<div class="nav" id="nav1">';
                echo '<div class="nav-bar">';
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $film_id = $row["film"];

                            // getting movie's information
                        $sql2 = "select poster from $db.Film where id = $film_id";
                        $result2 = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($result2) > 0)
                        {
                                //$num=0;
                            while($row2 = mysqli_fetch_assoc($result2))
                            {
                                    //$num++;
                                $poster = ($row2["poster"] != null) ? $row2["poster"] : "https://ih1.redbubble.net/image.300201805.5439/flat,750x,075,f-pad,750x1000,f8f8f8.jpg";

                                    // building html page
                                echo '<div class="column active">';
                                echo '<img src="' . $poster . '" alt="">';
                                echo '</div>';
                            }
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="prev" id="prev1"><</div>';
                    echo '<div class="next" id="next1">></div>';
                }else
                {
                    echo '<div class="noFilmDiv">';
                    echo '<p>Nessun film presente nella libreria.<br><a href="../add">Aggiungi</a> un film ora.</p>';
                    echo '</div>';
                    echo '<script>document.getElementById("posterContainer").style = "display: none"; document.getElementsByClassName("rowContainer")[0].style = "top: 50px";</script>';
                }
                ?>
        </div>
        <div class="row" id="row1">
            <h2>Drammatici</h2>
                    <?php
    
                ?>
                <?php
                $sql = "select film from $db.possiede join $db.Film where id = film and utente = '{$user_id}' and genere = \"drammatico\" limit 8";
                $result = mysqli_query($conn, $sql);
                $almenoUno = false;
                if (mysqli_num_rows($result) > 0)
                {
                echo '<div class="nav" id="nav2">';
                echo '<div class="nav-bar">';
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $film_id = $row["film"];

                            // getting movie's information
                        $sql2 = "select poster from $db.Film where id = $film_id";
                        $result2 = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($result2) > 0)
                        {
                            $almenoUno = true;    
                            //$num=0;
                            while($row2 = mysqli_fetch_assoc($result2))
                            {
                                    //$num++;
                                    $poster = ($row2["poster"] != null) ? $row2["poster"] : "https://ih1.redbubble.net/image.300201805.5439/flat,750x,075,f-pad,750x1000,f8f8f8.jpg";

                                    // building html page
                                echo '<div class="column active">';
                                echo '<img src="' . $poster . '" alt="">';
                                echo '</div>';
                            }
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="prev" id="prev2"><</div>';
                    echo '<div class="next" id="next2">></div>';
                }
                if (!$almenoUno)
                {
                    echo '<script>document.getElementById("row1").style = "display: none";</script>';
                }
                ?>

        </div>
        <div class="row" id="row1_1">
            <h2>Fantascienza</h2>
                <?php
                $sql = "select film from $db.possiede join $db.Film where id = film and utente = '{$user_id}' and genere = \"fantascienza\" limit 8";
                $result = mysqli_query($conn, $sql);
                $almenoUno = false;
                if (mysqli_num_rows($result) > 0)
                {
                echo '<div class="nav" id="nav1_1">';
                echo '<div class="nav-bar">';
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $film_id = $row["film"];

                            // getting movie's information
                        $sql2 = "select poster from $db.Film where id = $film_id";
                        $result2 = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($result2) > 0)
                        {
                            $almenoUno = true;    
                            //$num=0;
                            while($row2 = mysqli_fetch_assoc($result2))
                            {
                                    //$num++;
                                    $poster = ($row2["poster"] != null) ? $row2["poster"] : "https://ih1.redbubble.net/image.300201805.5439/flat,750x,075,f-pad,750x1000,f8f8f8.jpg";

                                    // building html page
                                echo '<div class="column active">';
                                echo '<img src="' . $poster . '" alt="">';
                                echo '</div>';
                            }
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="prev" id="prev1_1"><</div>';
                    echo '<div class="next" id="next1_1">></div>';
                }
                if (!$almenoUno)
                {
                    echo '<script>document.getElementById("row1_1").style = "display: none";</script>';
                }
                ?>

        </div>
        <div class="row" id="row2">
            <h2>Commedia</h2>
                    <?php

                ?>
                <?php
                $sql = "select film from $db.possiede join $db.Film where id = film and utente = '{$user_id}' and genere = \"commedia\" limit 8";
                $result = mysqli_query($conn, $sql);
                $almenoUno = false;
                if (mysqli_num_rows($result) > 0)
                {
                echo '<div class="nav" id="nav3">';
                echo '<div class="nav-bar">';
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $film_id = $row["film"];

                            // getting movie's information
                        $sql2 = "select poster from $db.Film where id = $film_id";
                        $result2 = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($result2) > 0)
                        {
                            $almenoUno = true;    
                            //$num=0;
                            while($row2 = mysqli_fetch_assoc($result2))
                            {
                                    //$num++;
                                    $poster = ($row2["poster"] != null) ? $row2["poster"] : "https://ih1.redbubble.net/image.300201805.5439/flat,750x,075,f-pad,750x1000,f8f8f8.jpg";

                                    // building html page
                                echo '<div class="column active">';
                                echo '<img src="' . $poster . '" alt="">';
                                echo '</div>';
                            }
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="prev" id="prev3"><</div>';
                    echo '<div class="next" id="next3">></div>';
                }
                if (!$almenoUno)
                {
                    echo '<script>document.getElementById("row2").style = "display: none";</script>';
                }
                ?>
        </div>
        <div class="row" id="row3">
            <h2>Horror</h2>
                    <?php

                ?>
                <?php
                $sql = "select film from $db.possiede join $db.Film where id = film and utente = '{$user_id}' and genere = \"horror\" limit 8";
                $result = mysqli_query($conn, $sql);
                $almenoUno = false;
                if (mysqli_num_rows($result) > 0)
                {
                echo '<div class="nav" id="nav4">';
                echo '<div class="nav-bar">';
                    while($row = mysqli_fetch_assoc($result))
                    {
                        $film_id = $row["film"];

                            // getting movie's information
                        $sql2 = "select poster from $db.Film where id = $film_id";
                        $result2 = mysqli_query($conn, $sql2);
                        if (mysqli_num_rows($result2) > 0)
                        {
                            $almenoUno = true;    
                            //$num=0;
                            while($row2 = mysqli_fetch_assoc($result2))
                            {
                                    //$num++;
                                    $poster = ($row2["poster"] != null) ? $row2["poster"] : "https://ih1.redbubble.net/image.300201805.5439/flat,750x,075,f-pad,750x1000,f8f8f8.jpg";

                                    // building html page
                                echo '<div class="column active">';
                                echo '<img src="' . $poster . '" alt="">';
                                echo '</div>';
                            }
                        }
                    }
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="prev" id="prev4"><</div>';
                    echo '<div class="next" id="next4">></div>';
                }

                if (!$almenoUno)
                {
                    echo '<script>document.getElementById("row3").style = "display: none";</script>';
                }
                ?>
        </div>
    </div>

<!-- </section> -->
    <script>
        try
        {
            const slides = document.querySelectorAll(".slides");
            const dots = document.querySelectorAll(".column");
            let slideIndex = 0;
            showSlide();
            function showSlide(n) {
                if (slideIndex > slides.length - 1) {
                    slideIndex = slides.length - 1;
                }
                if (slideIndex < 0) {
                    slideIndex = 0;
                }
                for (let i=0;i<slides.length; i++) {
                    slides[i].style.display = "none";
                }
                for (let i=0;i<dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "")
                }
                slides[slideIndex].style.display = "block";
                dots[slideIndex].className += " active";
            }
            dots.forEach((item, index) => {
                item.addEventListener("click", () => {
                    showSlide(slideIndex = index);
                })
            });

            const nav1 = document.querySelector("#nav1");
            const prev1 = document.querySelector("#prev1");
            const next1 = document.querySelector("#next1");
            const nav1_1 = document.querySelector("#nav1_1");
            const prev1_1 = document.querySelector("#prev1_1");
            const next1_1 = document.querySelector("#next1_1");
            const nav2 = document.querySelector("#nav2");
            const prev2 = document.querySelector("#prev2");
            const next2 = document.querySelector("#next2");
            const nav3 = document.querySelector("#nav3");
            const prev3 = document.querySelector("#prev3");
            const next3 = document.querySelector("#next3");
            const nav4 = document.querySelector("#nav4");
            const prev4 = document.querySelector("#prev4");
            const next4 = document.querySelector("#next4");
            next1.addEventListener("click", () => {
                nav1.scrollLeft += dots[0].offsetWidth;
                showSlide(slideIndex += 1);
            })
            prev1.addEventListener("click", () => {
                nav1.scrollLeft -= dots[0].offsetWidth;
                showSlide(slideIndex -= 1);
            })
            next1_1.addEventListener("click", () => {
                nav1_1.scrollLeft += dots[0].offsetWidth;
                showSlide(slideIndex += 1);
            })
            prev1_1.addEventListener("click", () => {
                nav1_1.scrollLeft -= dots[0].offsetWidth;
                showSlide(slideIndex -= 1);
            })
            next2.addEventListener("click", () => {
                nav2.scrollLeft += dots[0].offsetWidth;
                showSlide(slideIndex += 1);
            })
            prev2.addEventListener("click", () => {
                nav2.scrollLeft -= dots[0].offsetWidth;
                showSlide(slideIndex -= 1);
            })
            next3.addEventListener("click", () => {
                nav3.scrollLeft += dots[0].offsetWidth;
                showSlide(slideIndex += 1);
            })
            prev3.addEventListener("click", () => {
                nav3.scrollLeft -= dots[0].offsetWidth;
                showSlide(slideIndex -= 1);
            })
            next4.addEventListener("click", () => {
                nav4.scrollLeft += dots[0].offsetWidth;
                showSlide(slideIndex += 1);
            })
            prev4.addEventListener("click", () => {
                nav4.scrollLeft -= dots[0].offsetWidth;
                showSlide(slideIndex -= 1);
            })
        }
        catch {}
    </script>
</body>
</html>