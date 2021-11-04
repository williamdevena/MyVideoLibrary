<?php 
    // SE L' UTENTE E' LOGGATO VIENE REINDIRIZZATO ALLA HOMEPAGE
    session_start(); 
    if (isset($_SESSION["id"])) {
        header("Location: ../homepage/homepage.html");
    }
?>
<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <title>Registrazione</title>
        <link rel="icon" type="image/png" href="../images/favicon.ico"/>
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

        <link href= "https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap" rel="stylesheet">

        <script type="text/javascript" src="../js/valida.js" language="javascript" ></script>

    </head>
    <body class="registration_body">
        <?php if (!isset($_SESSION["id"])) { ?>
        <header>
            <input type="checkbox" id="chk1">
            <div class="logo">
                <h2><a href="../index.php">MyVideoLibrary</a></h2>
            </div>
            <ul>
                <li><a href="../login/login.php">Login</a></li>
                <li><a href="./registrazione.php">Registrazione</a></li>
                <label for="chk1" class="menu-close">
                    <i class="bi bi-x"></i>
                </label>
            </ul>
        </header>
        <div class="registration_box success">
            <h1 id="message"></h1>
            <img src="" class="success_logo" id="result_logo">
        </div>

        <script>
            var message = "Unknown error";
            var src = "../images/fallimento.png";

            <?php
            $servername = "sql313.epizy.com";
            $username = "epiz_28429607";
            $password = "67bRC4AHG7eB0";

            // Crea connessione
            $conn = mysqli_connect($servername, $username, $password);

            if (!$conn) {
                echo "message = 'Connection to DataBase failed';";
                goto end;
            }
            
            if ($_POST["email"] == "")
            {
                echo "message = 'Riempire il campo email';";
                goto end;
            }
            if ($_POST["password"] == "")
            {
                echo "message = 'Riempire il campo password';";
                goto end;
            }

            

            $sql = "select * from epiz_28429607_test.Utente where email = '{$_POST["email"]}' ";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0)
            {
                echo "message = 'Email già registrata';";
                echo "src = '../images/fallimento.png';";
                goto end;
            }

            $sql =  "insert into epiz_28429607_test.Utente values('{$_POST["nome"]}', '{$_POST["cognome"]}', '{$_POST["email"]}', '{$_POST["password"]}')";

            $result = mysqli_query($conn, $sql);
            if (!$conn)
            {
                echo "message = 'Errore sconosciuto';";
                echo "src = '../images/fallimento.png';";
                goto end;
            }

            echo "message = 'Registrazione avvenuta con successo';";
            echo "src = '../images/successo.png';";

            end:
            ?>

        </script>
        <script>
            document.getElementById("message").innerHTML = message;
            document.getElementById("result_logo").setAttribute("src", src);
        </script>
        <?php }  else { 
            header("Location: ../index.php"); }
        ?>
    </body>
</html>