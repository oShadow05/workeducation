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


$nFieldsClass = json_decode(stripslashes($_POST['nValuesClass']));

$classValues = json_decode(stripslashes($_POST['valuesClass']));

array_unshift($classValues, "NULL");


$class = $classValues[1];
$sezione = $classValues[2];


$bindClass = str_repeat('?,', $nFieldsClass) . '?';

echo $_SESSION["tableClasse"];


$check = $query->checkClassAlreadyUsed($class, addslashes($sezione));


if($check)
{
  $_SESSION["id"] = $check[0]["id"];
}
else
{
  $insert = $query->insert(addslashes($_SESSION["tableClasse"]), $bindClass, $classValues);

  if($insert==false)
  {
    echo "<h4 id='er-cred'>Errore nell'inserimento della classe</h4>";
  }
  else
  {
      echo "<h4>Classe Inserita!</h4>";
      $idClasse = $query->checkClassAlreadyUsed($class, addslashes($sezione));
      $_SESSION["id"] = $idClasse[0]["id"];
  }
}





exit();
?>
