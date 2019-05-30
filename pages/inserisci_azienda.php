<?php
ob_start();
session_start();
require $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/script/php/credentials.php";

  $codiceInserimento= $_POST["Codice_inserimento"];
  $partitaIva=$_POST["Partita_Iva"];
  $ragioneSociale=$_POST["Ragione_Sociale"];
  $codiceFiscale=$_POST["Codice_Fiscale"];
  $numeroDipendenti=$_POST["Numero_Dipendenti"];
  $sedeLegale=$_POST["Sede_Legale"];
  $provinciaSedeLegale=$_POST["Provincia_Sede_Legale"];
  $Telefono=$_POST["Telefono"];
  $Email=$_POST["Email"];


$id_azienda = mt_rand();

  $dsn="mysql:host=localhost; dbname=workereducation";

  try {
    $con=new PDO($dsn,$userAz, $codiceInserimento);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo "Errore ". $e->getMessage();
  }


  try {
    $stm=$con->prepare("INSERT INTO Aziende(Id_Azienda,Ragione_Sociale,
      P_Iva,C_F,N_Dipendenti,Sede_Legale,
      Provincia_Sede_Legale,Email,Telefono) VALUES(:id,:ra,:pi,:co,:nu,
      :se,:pr,:te,:em);
    ");
    $stm->bindParam(":id", $id_azienda);
    $stm->bindParam(":ra", $ragioneSociale);
    $stm->bindParam(":pi", $partitaIva);
    $stm->bindParam(":co", $codiceFiscale);
    $stm->bindParam(":nu", $numeroDipendenti);
    $stm->bindParam(":se", $sedeLegale);
    $stm->bindParam(":pr", $provinciaSedeLegale);
    $stm->bindParam(":te", $Telefono);
    $stm->bindParam(":em", $Email);
    $stm->execute();

    echo "<h1>Registrazione avvenuta con successo!!!</h1>";
    echo "<h1>Attendi l'invio delle credenziali per il tuo primo accesso.</h1>";
  } catch (PDOException $e) {
    echo "Errore ". $e->getMessage();
  }
 ?>
