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



echo " <form class='md-form' id='cred-input-form'> ";

  $table = "aziende";
  $fields = $query->getFieldsName($table);
  $nFields = count($fields);
  $meta = $query->columnMeta($table, $nFields);
  $type = array();
  for($i=0; $i<$nFields; $i++)
    $type[$i] = $query->translateNativeType($meta[$i]);

  $i = 0;
  echo "<h5 class='title'>Modifica dati azienda</h5>";
  echo "<div class='show-first'>";
  echo "<select class='browser-default custom-select bg-primary  custom-select-lg mb-3 text-white' id='codiceAziendaUpdate'>";
  echo "<option disable selected>Seleziona il codice dell'azienda da modificare</option>";
  $ids = $query->getIdProf($table);
  foreach($ids as $id)
  {
      echo "<option>" . $id["Id_Azienda"] . " - " . $id["Ragione_Sociale"] . " - " . $id["P_Iva"] . "</option>";
  }
  echo "</select>";
  echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='updateContinueAzienda'>Continua <i class='fas fa-arrow-right'></i> </div >";
  echo "</div>";
  echo "<div class='show-when-pressed'>";
  foreach($fields as $field)
  {
    $field = str_replace("_", " ", $field);
    if(strtolower(str_replace(" ", "", $field))==strtolower("Email"))
    {
      echo "<div id='input-box-update-azienda' class='form-box-update-az'>";
  
      echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-values'>" . $field . "</label>:" ;
      echo "<input required  type='email' class='form-control form-control-lg' placeholder='Valore' id='" . "$i'>" ;
      echo "</div>";
    }
    else
      if($type[$i]=="text")
      {
        echo "<div id='input-box-update-azienda' class='form-box-update-az'>";
        echo "<label class='form-padding' for='" . $type[$i] . " 'id='field'>" . $field . "</label>" ;

        echo "<input required pattern='[a-zA-Z0-9\s]{1,}' type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='" . "$i'>" ;
        echo "</div>";
      }
      else {
        if($type[$i]=="number")
        {
          echo "<div id='input-box-update-azienda' class='form-box-update-az'>";

          echo "<label class='form-padding' for='" . $type[$i] . " 'id='field'>" . $field . "</label>" ;

          echo "<input pattern='[0-9]' required  type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='" . "$i'>" ;

          echo "</div>";

        }
        else
          {
            if($type[$i]=="date")
            {

              echo "<div id='input-box-update-azienda' class='form-box-update-az'>";
              echo "<label class='form-padding' for='" . $type[$i] . " 'id='field'>" . $field . "</label>" ;

              echo "<input required  type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='" . "$i'>" ;

              echo "</div>";

            }
          }
      }

    $i++;
  }
  echo "<div id='display-error-update'></div>";

  echo "<div id='display-success-update'></div>";

  echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='submitUpdateAz'><span id='show-loading-azienda-update'><i class='fa fa-edit'></i> Modifica</span></div >";

  echo "</div>";

  $_SESSION["tableUpdate"] = $table;


echo "</form>";


exit();
?>
