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
        <title>Login</title>
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

        <script type="text/javascript" src="../js/valida.js" language="javascript"></script>
        <script src="//code.jquery.com/jquery-3.5.0.js"></script>
    </head>
    <body class="login_body">
    	<header>
            <div class="logo">
                <h2 style="font-size: 150%;"><a href="../index.php">MyVideoLibrary</a></h2>
            </div>
            <ul>
                <li><a href="#">Login</a></li>
                <li><a href="../registrazione/registrazione.php">Registrazione</a></li>
                <label for="chk1" class="menu-close">
                    <i class="bi bi-x"></i>
                </label>
            </ul>
        </header>
    	<div class="loginbox" id="loginbox">
    		<h1>Accedi</h1>
    		<form action="login2.php" autocomplete="off" method="post" name="login" onsubmit="return validazioneLogin()">
    			<div class="txt_field" id="div_email">
    				<input type="text" name="email" id="email" required>
    				<label>Email</label>
    			</div>
    			<div class="txt_field" id="div_password">
    				<input type="password" name="password" id="password" required>
    				<label>Password</label>
    			</div>
    			<input type="submit" value="Login" name="bottone_login" id="bottone_login" class="login_button">
    			<div class="signup_link">
    				Non sei ancora registrato? <a href="../registrazione/registrazione.php">Registrati</a>
    			</div>
    		</form>
            <div class="div_errore" id="div_errore"><p>Dati non corretti. Riprova</p></div>
    	</div>

        <script type="text/javascript">
                <?php  if (isset($_GET["error"])) { ?>
                            document.getElementById("div_email").style.borderBottom = "2px solid red";
                            document.getElementById("div_password").style.borderBottom = "2px solid red";
                            document.getElementById("div_errore").style.visibility = "visible";
                            document.getElementById("loginbox").style.height = "60%";
                <?php } ?>
        </script>
    </body>
</html>