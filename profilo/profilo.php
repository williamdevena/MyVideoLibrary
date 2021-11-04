<?php 
    session_start(); 
    if (!isset($_SESSION["id"])) {
        header("Location: ../index.php");
    }


    $servername = "sql313.epizy.com";
	$username = "epiz_28429607";
	$password = "67bRC4AHG7eB0";

    // Connessione
	$conn = mysqli_connect($servername, $username, $password);

	if (!$conn) {
		echo "Connessione fallita !!!";
	}

	$sql="select nome, cognome, email, password from epiz_28429607_test.Utente where email='{$_SESSION["id"]}'";

	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_row($result);
	$nome = $row[0];
	$cognome = $row[1];
	$email = $row[2];
	$password = $row[3];

?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Profilo - MyVideoLibrary</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="../images/favicon.ico"/>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="./style.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200&display=swap" rel="stylesheet">
    <style>
        .container_ {
            height: 80px;
            margin-top: -18px;
        }
    </style>
    <script type="text/javascript" src="../js/valida.js" language="javascript" ></script>
</head>
<body>
    <header>
        <input type="checkbox" id="chk1">
        <div class="logo">
            <h2 style="font-size: 150%"><a href="../homepage/homepage.php">MyVideoLibrary</a></h2>
        </div>
        <ul>
            <li><a href="../add/">Aggiungi</a></li>
            <li><a href="../cerca/cerca.php">Cerca</a></li>
            <li><a href="#">Profilo</a></li>
            <li><a href="../login/logout.php">Logout</a></li>
            <label for="chk1" class="menu-close">
                <i class="bi bi-x"></i>
            </label>
        </ul>
        <label for="chk1" class="menu-open">
            <i class="bi bi-list"></i>
        </label>
    </header>
    <h1 class="titolo">Modifica il tuo profilo</h1>
 
    <form name="mainForm" method="POST" action="profilo2.php" autocomplete="off" onsubmit="return validazioneModifica();">
        <div class="divProfilo" id="divProfilo">

            <div class="divInputProfilo1">
                <label for="inputNome" class="labelProfilo">Nome: </label>
                <input type="text" class="inputProfilo form-control" name="inputNome" id="inputNome"  value="<?php echo $nome ?>" required>
            </div>
            <div class="divInputProfilo2">
                <label for="inputCognome" class="labelProfilo">Cognome: </label>
                <input type="text" class="inputProfilo form-control" name="inputCognome" id="inputCognome"  value="<?php echo $cognome ?>" required>
            </div>
            <div class="divInputProfilo3">
                <label for="inputPassword" class="labelProfilo">Password: </label>
                <input type="password" class="inputProfilo form-control" name="inputPassword" id="inputPassword"  value="<?php echo $password ?>" required>
            </div>
            <div class="divBottone2">
                <button class="btn small-btn" type="submit" id="submitButton">Salva modifiche</button>
            </div>
        </div>	
        <div class="div_errore" id="div_errore"><p>Il nome non può contenere numeri</p></div>    	
    </form>
        
</body>
</html>