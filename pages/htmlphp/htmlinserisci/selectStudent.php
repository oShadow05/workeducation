<?php
session_start();
require $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/script/php/credentials.php";

require $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/script/php/requestHandler/RequestDatabaseHandler.php";
$livello = $_SESSION["livello"];
if($livello==1)
{
    $conn = new RequestDatabaseHandler($host, $type, $dbName, $userAdmin, $passwordLoginAdmin);

    $conn->request();
}
else
{
  if($livello==2)
  {
      $conn = new RequestDatabaseHandler($host, $type, $dbName, $userStDoc, $passwordLoginStandardDoc);

      $conn->request();
  }
  else{
      echo "<h1>Non sei autorizzato ad accedere a questa pagina</h1>";
  }
}

if($_SESSION["username"]!=NULL && $_SESSION["password"]!=NULL)
{
   // Create query object:
   $query = new SendQuery();

   // Send login query:
     $result = $query->login($_SESSION["username"],  $_SESSION["password"], "credenziali");

   // This if means that the user insert wrong credentials, the session variable is reset to NULL:
     if(!$result)
     {
       session_destroy();
       $_SESSION["username"] = NULL;
       $_SESSION["password"] = NULL;
       header("location:../../index.html?er=2");
       exit();
     }

}
else
{
  session_destroy();
  header("location:../index.html?er=1");
  exit();
}




$idClass =  $_POST['classCode'];

$optionValues = $query->getIdStudent("studenti", $idClass);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Select Student</title>
</head>
<body>
    <div id="student-code">
        <?php 
            echo "<select id='student-code-val' class='browser-default custom-select bg-danger  custom-select-lg mb-3 text-white'>";
            echo "<option disabled selected>Inserisci Il codice dello studente</option>";
            foreach($optionValues as $value)
            {
                echo "<option> " . $value["Matricola"] . " - " . $value["Cognome"] . " " . $value["Nome"] . "</option>";
            }
            echo "</select>";
            

            ?>
    </div>
</body>
</html>
