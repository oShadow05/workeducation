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
    // Name of table that store the username, password and level of the user:
    $table = "credenziali";

    // We store the fields name in a variable (it's an array):
        $fields = $query->getFieldsName($table);

    // We store in a variable the number of elements inside the array called $fields:
        $nFields = count($fields);

    // We store the type of column, for example Varchar or int:
        $meta = $query->columnMeta($table, $nFields);

    // We initialize an array:
        $type3 = array();

    /*
      This loop convert the array meta in an array type that has a translate of metadata.
      Example:
          - $meta[$i]   --  $type[$i]

          - VARCHAR     --  type = 'text'

          - INT         --  type = 'number'

      The type array is used for the input fields.

    */
    for($j=0; $j<$nFields; $j++)
      // The function translateNativeType translate the meta in an input type.
          $type3[$j] = $query->translateNativeType($meta[$j]);

    /*

      We initialize a counter $i to 0 for create a dinamic id for all the input.
      Javascript can get in this way all the user input.

    */
    $j = 0;

    // We display a title that inform the user what he do:
      echo "<div class='show-first-d'>";
      echo "<h5 class='title'>Inserimento di username e password del dipendente: </h5>";

    /*

      This foreach create the input and the labels dinamically.
      All if statement has a different pattern for controll user input.

    */
    foreach($fields as $field)
    {
        $field = str_replace("_", " ", $field);
        if(strtolower(str_replace(" ", "", $field))==strtolower("livello"))
        {
          echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-cred-d'>" . $field . ":</label>" ;

          echo "<input required  readonly class='form-control form-control-lg' placeholder='Valore' value='3' id='cred-d" . "$j'>";
        }
        else
        if($type3[$j]=="text")
        {

          // Password field:
          if($j==1)
          {
            echo "<div id='input-box-insert' class='form-box-insert'>";

            echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-cred-d'>" . $field . ":</label>" ;

            echo "<input pattern='[a-zA-Z0-9]{1,}' required  type='password' class='form-control form-control-lg' placeholder='Valore' id='cred-d" . "$j'>" ;
            echo "</div>";
          }
          else
          {
            echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-cred-d'>" . $field . ":</label>" ;

            echo "<input pattern='[a-zA-Z0-9\s]{1,}' required  type='" . $type3[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='cred-d" . "$j'>" ;
          }


        }
        else {
          if($type3[$j]=="number")
          {
            echo "<div id='input-box-insert' class='form-box-insert'>";

            echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-cred-d'>" . $field . ":</label>" ;

            echo "<input pattern='[0-9]' required  type='" . $type3[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='cred-d" . "$j'>" ;
            echo "</div>";

          }
          else
            {
              if($type3[$j]=="date")
              {
                echo "<div id='input-box-insert' class='form-box-insert'>";

                echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-cred-d'>" . $field . ":</label>" ;

                echo "<input pattern='[0-9]' required  type='" . $type3[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='cred-d" . "$j'>" ;
                echo "</div>";

              }
              else
              {
                echo "<div id='input-box-insert' class='form-box-insert'>";

                echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-cred-d'>" . $field . ":</label>" ;

                echo "<input required  type='" . $type3[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='cred-d" . "$j'>" ;
                echo "</div>";
              }
            }
        }

    // We increment the counter $j for the next input:
        $j++;
    }
    echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='insertDipContinue-d'>Continua <i class='fas fa-arrow-right'></i> </div >";
    echo "</div>";

    $_SESSION["tableCredenziali"] = $table;

    $table = "dipendenti_azienda";

    // We store the fields name in a variable (it's an array):
        $fields = $query->getFieldsName($table);


    // We store in a variable the number of elements inside the array called $fields:
        $nFields = count($fields);

    // We store the type of column, for example Varchar or int:
        $meta = $query->columnMeta($table, $nFields);

    // We initialize an array:
        $type4 = array();

    /*
      This loop convert the array meta in an array type that has a translate of metadata.
      Example:
          - $meta[$i]   --  $type[$i]

          - VARCHAR     --  type = 'text'

          - INT         --  type = 'number'

      The type array is used for the input fields.

    */
    for($j=0; $j<$nFields; $j++)
      // The function translateNativeType translate the meta in an input type.
          $type4[$j] = $query->translateNativeType($meta[$j]);

    /*

      We initialize a counter $i to 0 for create a dinamic id for all the input.
      Javascript can get in this way all the user input.

    */
    $j = 0;

    // We display a title that inform the user what he do:
      echo "<div class='insert-show-when-pressed-d-1'>";
      echo "<h5 class='title'>Inserimento dati del dipendente: </h5>";

    /*

      This foreach create the input and the labels dinamically.
      All if statement has a different pattern for controll user input.

    */
    foreach($fields as $field)
    {
      $field = str_replace("_", " ", $field);

       if(strtolower($field)==strtolower("email"))
       {
        echo "<div id='input-box-insert' class='form-box-insert'>";
        echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip-d'>" . $field . ":</label>" ;

        echo "<input  required  type='email' class='form-control form-control-lg' placeholder='Valore' id='da-d" . "$j'>" ;
        echo "</div>";
       }
       else
       if($j==$nFields-2)
       {
        echo "<div id='input-box-insert' class='form-box-insert'>";
        echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip-d'>" . $field . ":</label>" ;

        echo "<select  class='browser-default custom-select bg-primary  custom-select-lg mb-3 text-white' id='codeFiliale'>";
        echo "<option disabled selected>Inserisci filiale</option>";
              $select = $query->getId("filiali");
              foreach ($select as $option) {
                echo "<option>" . $option["Id_Filiale"] . " - " . $option["Id_Azienda"] . "</option>";
              }
              echo "</select>";


        echo "</div>";
       }
       else
          if($j==$nFields-1)
          {
            echo "<div id='input-box-insert' class='form-box-insert'>";
            echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip-d'>" . $field . ":</label>" ;

            echo "<div id='input-readonly-user-d'></div>";
            echo "</div>";
          }
          else
          {
            if($type4[$j]=="text")
            {
              echo "<div id='input-box-insert' class='form-box-insert'>";
              echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip-d'>" . $field . ":</label>" ;

              echo "<input pattern='[a-zA-Z0-9\s]{1,}' required  type='" . $type4[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='da-d" . "$j'>" ;
              echo "</div>";
            }


              else {
                if($type4[$j]=="number")
                {
                  echo "<div id='input-box-insert' class='form-box-insert'>";

                  echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip-d'>" . $field . ":</label>" ;

                  echo "<input pattern='[0-9]' required  type='" . $type4[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='da-d" . "$j'>" ;
                  echo "</div>";
                }
                else
                  {
                    if($type4[$j]=="date")
                    {
                      echo "<div id='input-box-insert' class='form-box-insert'>";

                      echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip-d'>" . $field . ":</label>" ;

                      echo "<input pattern='[0-9]' required  type='" . $type4[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='da-d" . "$j'>" ;
                      echo "</div>";
                    }
                    else
                    {
                      echo "<div id='input-box-insert' class='form-box-insert'>";

                      echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip-d'>" . $field . ":</label>" ;

                      echo "<input required  type='" . $type4[$j] . "' class=' form-control form-control-lg' placeholder='Valore' id='da-d" . "$j'>" ;
                      echo "</div>";
                    }
                  }
          }



        }

    // We increment the counter $j for the next input:
        $j++;
    }

  // We save the table inside the array session:
    $_SESSION["tableDipendente"] = $table;


    echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='submitInsertDip'><span id='show-loading-dip'><i class='fa fa-plus'></i> Inserisci</span></div >";
    echo "</div>";



    echo "</form>";






exit();
?>
