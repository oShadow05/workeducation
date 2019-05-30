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


$fieldsName = json_decode(stripslashes($_POST["fieldsName"]));

$inputValues = json_decode(stripslashes($_POST["inputValues"]));

$nModifiedFields =  json_decode(stripslashes($_POST["nModifiedFields"]));

$codeForUpdate = json_decode(stripslashes($_POST["code"]));


$primaryKeyFieldName = json_decode(stripslashes($_POST["primaryKeyFieldName"]));


for($i=0; $i<$nModifiedFields; $i++)
{
  $fieldsName[$i] = str_replace(" ", "_", $fieldsName[$i]);
}

$boolModifiedField = false;


$result = null;





for($i=$nModifiedFields-1; $i>=0; $i--)
{
    $result = $query->update(addslashes($_SESSION["tableUpdate"]), $fieldsName[$i], addslashes($inputValues[$i]), $primaryKeyFieldName, addslashes($codeForUpdate));

    if($result==true)
    {
        $boolModifiedField = true;

    }
    else
        $boolModifiedField = false;

}

if($boolModifiedField)
    echo "<h4 id='success-update'>Dati Aggiornati!</h4>";
else
    echo "<h4 id='error-update'>Non è stato possibile aggiornare i dati!</h4>";


    $_POST["fieldsName"] = NULL;
    $_POST["inputValues"] = NULL;
    $_POST["nModifiedFields"] = NULL;
    $_POST["code"] = NULL;
    $_POST["primaryKeyFieldName"] = NULL;
exit();
?>
