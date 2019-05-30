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



echo " <form class='md-form' id='cred-input-form-upd'> ";
echo "<h5 class='title'>Seleziona azienda: </h5>";


  $table = "aziende";

  $select = $query->getId($table);
  echo "<select id='get-id-update-az-filiale'  class='browser-default custom-select disable bg-primary  custom-select-lg mb-3 text-white'>";
  echo "<option disabled selected>Scegli l'azienda su cui fare la modifica</option>";
  if($select!=NULL)
  {
    foreach($select as $option)
    {
      echo "<option>" . $option["Id_Azienda"] . " - " . $option["Ragione_Sociale"] . "</option>";
    }
  }
 
  echo "</select>";
  echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='cntSubmitUpdateFiliale'><span id='show-loading-update-filiale'><i class='fa fa-edit'></i> Continua</span></div >";
echo "</form>";


exit();
?>
