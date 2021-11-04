<?php

// se l' utente non è loggato viene reindirizzato alla index
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
	echo "Connection to DataBase failed";
	goto end;
}
if ($_POST["inputNome"] == "")
{
	echo "Riempire il campo nome";
	goto end;
}
if ($_POST["inputCognome"] == "")
{
	echo "Riempire il campo cognome";
	goto end;
}

if ($_POST["inputPassword"] == "")
{
	echo "Riempire il campo password";
	goto end;
}



$sql="update epiz_28429607_test.Utente set nome='{$_POST["inputNome"]}', cognome='{$_POST["inputCognome"]}', password='{$_POST["inputPassword"]}' where email='{$_SESSION["id"]}'; ";

$result = mysqli_query($conn, $sql);

header("Location: ../homepage/homepage.php");

end:


?>