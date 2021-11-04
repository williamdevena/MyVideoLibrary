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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="../style.css">
        <link rel="stylesheet" href="./style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">

        <link href= "https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap" rel="stylesheet">
        <style>
            .container_ {
                height: 80px;
                margin-top: -18px;
            }
        </style>
        <script type="text/javascript" src="../js/valida.js" language="javascript" ></script>

    </head>
    <body class="registration_body">
        <header>
            <input type="checkbox" id="chk1">
            <div class="logo">
                <h2 style="font-size: 150%;"><a href="../index.php">MyVideoLibrary</a></h2>
            </div>
            <ul>
                <li><a href="../login/login.php">Login</a></li>
                <li><a href="#">Registrazione</a></li>
                <label for="chk1" class="menu-close">
                    <i class="bi bi-x"></i>
                </label>
            </ul>
        </header>
        <div class="registration_box" id="registration_box">
            <h1>Registrati</h1>
            <form action="successo.php" autocomplete="off" method="post" name="registr" onsubmit="return validazioneRegistr();">
                <div class="txt_field_registration" id="div_nome">
                    <input type="text" name="nome" id="nome"  required>
                    <label>Nome</label>
                </div>
                <div class="txt_field_registration" id="div_cognome">
                    <input type="text" name="cognome" id="cognome" required>
                    <label>Cognome</label>
                </div>
                <div class="txt_field_registration" id="div_email">
                    <input type="text" name="email" id="email" required>
                    <label>E-mail</label>
                </div>
                <div class="txt_field_registration" id="div_password">
                    <input type="password" name="password" id="password" required>
                    <label>Password</label>
                </div> 
                <div class="txt_field_registration" id="div_ConfermaPassword">
                    <input type="password" name="ConfermaPassword" id="ConfermaPassword" required>
                    <label>Conferma Password</label>
                </div>          
                <input type="submit" value="Conferma" class="registration_button">
            </form>
            <div class="div_errore" id="div_errore"><p>Il nome non può contenere numeri</p></div>
        </div>
    </body>
</html>