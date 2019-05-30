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
  

  /*

     First we create a call to the database and we get the fields name of the table credentials.
     All the methods are avaible in the php file called requestDatabaseHandler.php.

  */

  // Name of table that store the username, password and level of the user:
  $table = "periodi_stage";

  // We store the fields name in a variable (it's an array):
      $fields = $query->getFieldsName($table);
      array_shift($fields);



  // We store in a variable the number of elements inside the array called $fields:
      $nFields = count($fields);

  // We store the type of column, for example Varchar or int:
      $meta = $query->columnMeta($table, $nFields);


  // We initialize an array:
      $type = array();

  /*
    This loop convert the array meta in an array type that has a translate of metadata.
     Example:
        - $meta[$i]   --  $type[$i]

        - VARCHAR     --  type = 'text'

        - INT         --  type = 'number'

    The type array is used for the input fields.

  */
  for($i=0; $i<$nFields; $i++)
    // The function translateNativeType translate the meta in an input type.
        $type[$i] = $query->translateNativeType($meta[$i]);

    $type[0] = "date";
    $type[2] = "number";
  /*

    We initialize a counter $i to 0 for create a dinamic id for all the input.
    Javascript can get in this way all the user input.

  */
  $i = 0;

    echo "<div class='show-first'>";

     echo "<h5 class='title'>Inserimento periodo stage: </h5>";

  /*

    This foreach create the input and the labels dinamically.
    All if statement has a different pattern for controll user input.

  */
  foreach($fields as $field)
  {
    $field = str_replace("_", " ", $field);
    if(strtolower(str_replace(" ", "", $field))==strtolower("iddipendente"))
    {
      $optionValues = $query->getIdDipendente();
      echo "<div id='input-box-insert' class='form-box-insert-classi display-prof'>";
      echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-stage'>Tutor aziendale:</label>";
      echo "<select id='employee-code' class='browser-default custom-select bg-primary  custom-select-lg mb-3 text-white'>";
      echo "<option disabled selected>Inserisci il codice del tutor aziendale</option>";
      foreach($optionValues as $value)
      {
        echo "<option> " . $value["id_dipendente"] . " - " . $value["nome"] . " - " . $value["ragione_sociale"] . "</option>";
      }
      echo "</select>";

      echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='submitInsertPeriodiStage'><span id='show-loading'><i class='fa fa-plus'></i> Inserisci</span></div >";

      echo "</div>";
    }
    else
    if(strtolower(str_replace(" ", "", $field))==strtolower("Iddocente"))
    {
      $optionValues = $query->getIdProf("docenti");

      echo "<div id='input-box-insert' class='form-box-insert-classi display-prof'>";
      echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-stage'>Tutor scolastico:</label>";
      echo "<select id='professor-code' class='browser-default custom-select bg-primary  custom-select-lg mb-3 text-white'>";
      echo "<option disabled selected>Inserisci il codice del professore</option>";
      foreach($optionValues as $value)
      {
        echo "<option> " . $value["Id_Docente"] . " - " . $value["Cognome"] . " " . $value["Nome"] . "</option>";
      }
      echo "</select>";


      echo "</div>";
      
    }

    else
      if(strtolower($field)==strtolower("Matricola"))
      {



        echo "<div id='input-box-insert' class='form-box-insert-studenti'>";
        echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-stage'>" . $field . ":</label>";
       echo "<div id='display-student'></div>";

        echo "</div>";



      }
      else
        if(strtolower(str_replace(" ", "", $field))==strtolower("Idclasse"))
        {
          $optionValues = $query->getId("classi");


          echo "<div id='input-box-insert' class='form-box-insert-classi'>";
          echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-stage'>" . $field . ":</label>";
          echo "<select id='class-code' class='browser-default custom-select bg-primary  custom-select-lg mb-3 text-white'>";
          echo "<option disabled selected>Inserisci il codice della classe</option>";
          foreach($optionValues as $value)
          {
            echo "<option> " . $value["Id_Classe"] . " - " . $value["Classe"] . "" . $value["Sezione"] . " - " . $value["Indirizzo"] . "</option>";
          }
          echo "</select>";
          echo "</div>";
          echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='continueInsertPeriodiStage'>Continua <i class='fas fa-arrow-right'></i> </div >";

        }
        else
      if($type[$i]=="text")
      {


          echo "<div id='input-box-insert' class='form-box-insert'>";

          echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-stage'>" . $field . ":</label>" ;

          echo "<input pattern='[a-zA-Z0-9\s]{1,}' required  type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='stg" . "$i'>" ;
          echo "</div>";




      }
      else {
        if($type[$i]=="number")
        {

          echo "<div id='input-box-insert' class='form-box-insert'>";

          echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-stage'>" . $field . ":</label>" ;

          echo "<input pattern='[0-9]' required  type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='stg" . "$i'>" ;
          echo "</div>";

        }
        else
          {
            if($type[$i]=="date")
            {
              echo "<div id='input-box-insert' class='form-box-insert'>";

              echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-stage'>" . $field . ":</label>" ;

              echo "<input pattern='[0-9]' required  type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='stg" . "$i'>" ;
              echo "</div>";

            }
            else
            {
              echo "<div id='input-box-insert' class='form-box-insert'>";

              echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-stage'>" . $field . ":</label>" ;

              echo "<input required  type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='stg" . "$i'>" ;
              echo "</div>";

            }
          }
      }

  // We increment the counter $i for the next input:
      $i++;




	
  }

 // We create a submit button for send data to the php script by using an ajax call:
 

  $_SESSION["tablePeriodiStage"] = $table;

  echo "</div>";
  echo "</form>";



exit();
?>
