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
    echo "<h1>Non hai l'autorizzazione per accedere a questa pagina.</h1>";
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


$nFieldsCred = json_decode(stripslashes($_POST['nCredFields']));

$credValues = json_decode(stripslashes($_POST['credValues']));

$bindCred = str_repeat('?,', $nFieldsCred - 1) . '?';


// Inserimento anagrafica:
$fieldsNameCred = $query->getFieldsName(addslashes($_SESSION["tableCredenziali"]));

$boolInsert = false;
$insertCred = null;
$insertVal = null;
foreach($fieldsNameCred as $field)
{
  if(strtolower($field)==strtolower("Pwd"))
      $credValues[1] = password_hash($credValues[1], PASSWORD_BCRYPT);
}


$insertCred = $query->insert(addslashes($_SESSION["tableCredenziali"]), $bindCred, $credValues);

if($insertCred==false)
{
  echo "<h4 id='er-cred'>Errore nell'inserimento delle credenziali</h4>";
}
else
{
  $insertVal = json_decode(stripslashes($_POST["values"]));
  $nFieldsVal = json_decode(stripslashes($_POST["nValFields"]));
  $bindVal = str_repeat('?,', $nFieldsVal - 1) . '?';
  $insertVal = $query->insert(addslashes($_SESSION["tableProf"]), $bindVal, $insertVal);
  if($insertVal==false)
  {
    echo "<h4 id='er-val'>Errore inserimento studente</h4>";
  }
  else
  {
    echo "<h4 id='success'>Docente inserito!</h4>";
  }
}



exit();
?>
