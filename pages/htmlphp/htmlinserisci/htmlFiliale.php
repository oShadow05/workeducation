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


  $field = str_replace("_", " ", $field);

  echo " <form class='md-form' id='cred-input-form'> ";


    $table = "filiali";

     $fields = $query->getFieldsName($table);

     $nFields = count($fields);

     $meta = $query->columnMeta($table, $nFields);

     $_SESSION["firstFieldName"] = $fields[0];

     $type2 = array();

  for($j=0; $j<$nFields; $j++)
    $type2[$j] = $query->translateNativeType($meta[$j]);

  // We crete a div with a class that show when user click on continue button:
  echo " <form class='md-form' id='cred-input-form'> ";

  echo "<h5 class='title'>Inserimento dati filiale: </h5>";

  $j = 0;
  foreach($fields as $field)
  {
    $field = str_replace("_", " ", $field);

    if($j==1)
    {
      echo "<div id='input-box-insert' class='form-box-insert'>";
      echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-filiale-f'>" . $field . ":</label>" ;

      echo "<select  class='browser-default custom-select bg-primary  custom-select-lg mb-3 text-white' id='codeAzienda'>";
      echo "<option disabled selected>Inserisci Azienda</option>";
            $select = $query->getId("aziende");
            foreach ($select as $option) {
              echo "<option>" . $option["Id_Azienda"] . " - " . $option["Ragione_Sociale"] . "</option>";
            }
            echo "</select>";
      echo "</div>";

    }
    else
      if($type2[$j]=="text" && $j!=$nFields-1)
      {

          echo "<div id='input-box-insert' class='form-box-insert'>";
          echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-filiale-f'>" . $field . ":</label>" ;

          echo "<input pattern='[a-zA-Z0-9\s]{1,}' required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='ff" . "$j'>" ;
          echo "</div>";

      }
      else {
        if($type2[$j]=="number")
        {
          echo "<div id='input-box-insert' class='form-box-insert'>";

          echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-filiale-f'>" . $field . ":</label>" ;

          echo "<input pattern='[0-9]' required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='ff" . "$j'>" ;
          echo "</div>";

        }
        else
        {
          if(strtolower($field)==strtolower("Note"))
          {
              echo "<div id='input-box-insert' class='form-box-insert'>";

              echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-filiale-f'>" . $field . ":</label>" ;

              echo "<textarea  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Qui puoi inserire una descrizione' id='ff" . "$j'></textarea>" ;
              echo "</div>";

          }
          else
          {
            if($type2[$j]=="date")
            {
              echo "<div id='input-box-insert' class='form-box-insert'>";

              echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-filiale-f'>" . $field . ":</label>" ;

              echo "<input pattern='[0-9]' required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='ff" . "$j'>" ;
              echo "</div>";

            }
            else
            {
              echo "<div id='input-box-insert' class='form-box-insert'>";

              echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-filiale-f'>" . $field . ":</label>" ;

              echo "<input required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='ff" . "$j'>" ;
              echo "</div>";
            }
          }


        }



      }
      $j++;
	

  }  // We create a submit button for send data to the php script by using an ajax call:
    echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='submitInsertFiliale'><span id='show-loading-insert-filiale'><i class='fas fa-plus'></i> Inserisci </span></div >";
    echo "</form>";
  

  


    $_SESSION["tableFiliale"] = $table;





exit();
?>
