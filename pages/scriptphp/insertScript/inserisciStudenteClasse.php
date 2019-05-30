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
       header("location:/dashboard/workereducation/index.html?er=2");
       exit();
     }

}
else
{
  session_destroy();
  header("location:/dashboard/workereducation/index.html?er=1");
  exit();
}


$nValuesYear = json_decode(stripslashes($_POST['nValuesYear']));

$valuesYear = json_decode(stripslashes($_POST['valuesYear']));

$bindYear = str_repeat('?,', $nValuesYear+1) . '?';


array_unshift($valuesYear, "NULL");

$idClass = $_SESSION["id"];

var_dump($idClass);

array_splice($valuesYear, 2, 0, array($idClass));



$insert = $query->insert(addslashes($_SESSION["tableStClassi"]), $bindYear, $valuesYear);

if($insert==false)
{
  echo "<h4 id='er-cred'>Errore nell'inserimento della classe</h4>";
}
else
{
    echo "<h4>Collegamento inserito!</h4>";
}



exit();
?>
