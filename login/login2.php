<?php

session_start();

$servername = "sql313.epizy.com";
$username = "epiz_28429607";
$password = "67bRC4AHG7eB0";

// Connessione
$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    echo "Errore connessione";
    goto end;
}

$sql1 = "select * from epiz_28429607_test.Utente where email = '{$_POST["email"]}' ";
$result1 = mysqli_query($conn, $sql1);

if (mysqli_num_rows($result1) == 0)
{
    header("Location: ./login.php?error=Email errata");
    goto end;
}

$sql2 = "select password from epiz_28429607_test.Utente where email = '{$_POST["email"]}' ";

$result2 = mysqli_query($conn, $sql2);
$row = mysqli_fetch_row($result2);
$password = $row[0];


if ($password!=$_POST["password"]) {
    header("Location: ./login.php?error=Password errata");
    goto end;
}

$_SESSION['id']=$_POST["email"];

header("Location: ../homepage/homepage.php");

end:
?>