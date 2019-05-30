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



echo " <form class='md-form' id='cred-input-form'> ";
$table = "docenti";
$field = "Id_docente";
echo "<h5 class='title'><i>Eliminazione professore</i></h5>";
echo "<select class='browser-default custom-select bg-primary  custom-select-lg mb-3 text-white' id='codiceDocente'>" ;
echo "<option disable selected>Seleziona il codice del docente da eliminare</option>";
$ids = $query->getIdProf($table);

foreach($ids as $id)
{
    echo "<option>" . $id["Id_Docente"] . " - " . $id["Cognome"] . " - " . $id["Nome"] . "</option>";
}
echo "</select>";



echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='submitDeleteProfessor'><span id='show-loading'><i class='fa fa-trash'></i> Elimina</span></div >";
$_SESSION["table"] = $table;
$_SESSION["fieldName"] = $field;
echo "</form>";


exit();
?>
