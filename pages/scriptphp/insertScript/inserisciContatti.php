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


$nFieldsContatti = json_decode(stripslashes($_POST['nFieldsContatti']));

$valContatti = json_decode(stripslashes($_POST['valContatti']));

$bindContatti = str_repeat('?,', $nFieldsContatti) . '?';

array_unshift($valContatti, "NULL");








$insert = $query->insert(addslashes($_SESSION["tableContatti"]), $bindContatti, $valContatti);

if($insert==false)
{
  echo "<h4>Errore nell'inserimento del dipendente</h4>";
}
else
{
    echo "<h4>Contatto inserito!</h4>";
}



exit();
?>
