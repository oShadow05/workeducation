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
    }}

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

  /*

     First we create a call to the database and we get the fields name of the table credentials.
     All the methods are avaible in the php file called requestDatabaseHandler.php.

  */

  $table = "Aziende";

  // We store the fields name in a variable (it's an array):
      $fields = $query->getFieldsName($table);

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

  /*

    We initialize a counter $i to 0 for create a dinamic id for all the input.
    Javascript can get in this way all the user input.

  */
  $i = 0;

  // We display a title that inform the user what he do:
    echo "<div class='show-first'>";
    echo "<h5 class='title'>Inserimento dati dell'azienda </h5>";

  /*

    This foreach create the input and the labels dinamically.
    All if statement has a different pattern for controll user input.

  */
  foreach($fields as $field)
  {
    $field = str_replace("_", " ", $field);
    if(strtolower(str_replace(" ", "", $field))==strtolower("Email"))
    {
      echo "<div id='input-box-insert' class='form-box-insert'>";
  
      echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-azienda'>" . $field . "</label>:" ;
      echo "<input required  type='email' class='form-control form-control-lg' placeholder='Valore' id='a" . "$i'>" ;
      echo "</div>";
    }
    else
      if($type[$i]=="text")
      {

          echo "<div id='input-box-insert' class='form-box-insert'>";

          echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-azienda'>" . $field . ":</label>" ;

          echo "<input pattern='[a-zA-Z0-9\s]{1,}' required  type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='a" . "$i'>" ;
          echo "</div>";




      }
      else {
        if($type[$i]=="number")
        {

          echo "<div id='input-box-insert' class='form-box-insert'>";

          echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-azienda'>" . $field . ":</label>" ;

          echo "<input pattern='[0-9]' required  type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='a" . "$i'>" ;
          echo "</div>";

        }
        else
          {
            if($type[$i]=="date")
            {
              echo "<div id='input-box-insert' class='form-box-insert'>";

              echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-azienda'>" . $field . ":</label>" ;

              echo "<input pattern='[0-9]' required  type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='a" . "$i'>" ;
              echo "</div>";

            }
            else
            {
              echo "<div id='input-box-insert' class='form-box-insert'>";

              echo "<label class='form-padding' for='" . $type[$i] . " 'id='field-azienda'>" . $field . ":</label>" ;

              echo "<input required  type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='a" . "$i'>" ;
              echo "</div>";

            }
          }
      }

  // We increment the counter $i for the next input:
      $i++;




  }

  // We store the credentials table in the session array:
     $_SESSION["tableAzienda"] = $table;

  // We create a div button that when user click the javascript shows the next fields:
     echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='insertAziendaContinue'>Continua <i class='fas fa-arrow-right'></i> </div >";

     echo "</div>";
  // We overwrite the variable $table with the Professor table:
      $table = "filiali";

  // This part is the same as up:
     $fields = $query->getFieldsName($table);

     $nFields = count($fields);

     $meta = $query->columnMeta($table, $nFields);

  // The first name is stored in session array, because it contains the primary key:
     $_SESSION["firstFieldName"] = $fields[0];

  // We initialize a type2 array:
     $type2 = array();

  for($j=0; $j<$nFields; $j++)
    $type2[$j] = $query->translateNativeType($meta[$j]);

  // We crete a div with a class that show when user click on continue button:
      echo "<div class='insert-show-when-pressed'>";

  echo "<h5 class='title'>Inserimento dati filiale: </h5>";

  $j = 0;
  foreach($fields as $field)
  {
    $field = str_replace("_", " ", $field);

    if($j==1)
    {
      echo "<div id='input-box-insert' class='form-box-insert'>";
          echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-filiale'>" . $field . ":</label>" ;

         echo "<div id='input-readonly-azienda'></div>";
          echo "</div>";

    }
    else
      if($type2[$j]=="text" && $j!=$nFields-1)
      {

          echo "<div id='input-box-insert' class='form-box-insert'>";
          echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-filiale'>" . $field . ":</label>" ;

          echo "<input pattern='[a-zA-Z0-9\s]{1,}' required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='f" . "$j'>" ;
          echo "</div>";

      }
      else {
        if($type2[$j]=="number")
        {
          echo "<div id='input-box-insert' class='form-box-insert'>";

          echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-filiale'>" . $field . ":</label>" ;

          echo "<input pattern='[0-9]' required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='f" . "$j'>" ;
          echo "</div>";

        }
        else
        {
          if(strtolower($field)==strtolower("Note"))
          {
              echo "<div id='input-box-insert' class='form-box-insert'>";

              echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-filiale'>" . $field . ":</label>" ;

              echo "<textarea  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Qui puoi inserire una descrizione' id='f" . "$j'></textarea>" ;
              echo "</div>";

          }
          else
          {
            if($type2[$j]=="date")
            {
              echo "<div id='input-box-insert' class='form-box-insert'>";

              echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-filiale'>" . $field . ":</label>" ;

              echo "<input pattern='[0-9]' required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='f" . "$j'>" ;
              echo "</div>";

            }
            else
            {
              echo "<div id='input-box-insert' class='form-box-insert'>";

              echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-filiale'>" . $field . ":</label>" ;

              echo "<input required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='f" . "$j'>" ;
              echo "</div>";
            }
          }


        }



      }
      $j++;

  }

  // We create a submit button for send data to the php script by using an ajax call:
    echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='insertAziendaContinue2'>Continua <i class='fas fa-arrow-right'></i> </div >";
    echo "</div>";
    $_SESSION["tableFiliale"] = $table;
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
      echo "<div class='insert-show-when-pressed2'>";
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
        echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-cred'>" . $field . ":</label>" ;

        echo "<input required  readonly class='form-control form-control-lg' placeholder='Valore' value='3' id='cred" . "$j'>";
      }
        else
        if($type3[$j]=="text")
        {


          // Password field:
          if($j==1)
          {
            echo "<div id='input-box-insert' class='form-box-insert'>";

            echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-cred'>" . $field . ":</label>" ;

            echo "<input pattern='[a-zA-Z0-9]{1,}' required  type='password' class='form-control form-control-lg' placeholder='Valore' id='cred" . "$j'>" ;
            echo "</div>";
          }
          else
          {
            echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-cred'>" . $field . ":</label>" ;

            echo "<input pattern='[a-zA-Z0-9\s]{1,}' required  type='" . $type3[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='cred" . "$j'>" ;
          }


        }
        else {
          if($type3[$j]=="number")
          {
            echo "<div id='input-box-insert' class='form-box-insert'>";

            echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-cred'>" . $field . ":</label>" ;

            echo "<input pattern='[0-9]' required  type='" . $type3[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='cred" . "$j'>" ;
            echo "</div>";

          }
          else
            {
              if($type3[$j]=="date")
              {
                echo "<div id='input-box-insert' class='form-box-insert'>";

                echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-cred'>" . $field . ":</label>" ;

                echo "<input pattern='[0-9]' required  type='" . $type3[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='cred" . "$j'>" ;
                echo "</div>";

              }
              else
              {
                echo "<div id='input-box-insert' class='form-box-insert'>";

                echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-cred'>" . $field . ":</label>" ;

                echo "<input required  type='" . $type3[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='cred" . "$j'>" ;
                echo "</div>";
              }
            }
        }

    // We increment the counter $j for the next input:
        $j++;
    }
    echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='insertAziendaContinue3'>Continua <i class='fas fa-arrow-right'></i> </div >";
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
      echo "<div class='insert-show-when-pressed3'>";
      echo "<h5 class='title'>Inserimento dati del dipendente: </h5>";

    /*

      This foreach create the input and the labels dinamically.
      All if statement has a different pattern for controll user input.

    */
    foreach($fields as $field)
    {
      $field = str_replace("_", " ", $field);
      if(strtolower(str_replace(" ", "", $field))==strtolower("Email"))
      {
        echo "<div id='input-box-insert' class='form-box-insert'>";

        echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip'>" . $field . ":</label>" ;
        echo "<input required  type='email' class='form-control form-control-lg' placeholder='Valore' id='da" . "$j'>" ;
        echo "</div>";
      }
      else
       if($j==$nFields-2)
       {
        echo "<div id='input-box-insert' class='form-box-insert'>";
        echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip'>" . $field . ":</label>" ;

        echo "<div id='input-readonly-filiale'></div>";
        echo "</div>";
       }
       else
          if($j==$nFields-1)
          {
            echo "<div id='input-box-insert' class='form-box-insert'>";
            echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip'>" . $field . ":</label>" ;

            echo "<div id='input-readonly-user'></div>";
            echo "</div>";
          }
          else
          {
            if($type4[$j]=="text")
            {
              echo "<div id='input-box-insert' class='form-box-insert'>";
              echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip'>" . $field . ":</label>" ;

              echo "<input pattern='[a-zA-Z0-9\s]{1,}' required  type='" . $type4[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='da" . "$j'>" ;
              echo "</div>";
            }


              else {
                if($type4[$j]=="number")
                {
                  echo "<div id='input-box-insert' class='form-box-insert'>";

                  echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip'>" . $field . ":</label>" ;

                  echo "<input pattern='[0-9]' required  type='" . $type4[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='da" . "$j'>" ;
                  echo "</div>";
                }
                else
                  {
                    if($type4[$j]=="date")
                    {
                      echo "<div id='input-box-insert' class='form-box-insert'>";

                      echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip'>" . $field . ":</label>" ;

                      echo "<input pattern='[0-9]' required  type='" . $type4[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='da" . "$j'>" ;
                      echo "</div>";
                    }
                    else
                    {
                      echo "<div id='input-box-insert' class='form-box-insert'>";

                      echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-dip'>" . $field . ":</label>" ;

                      echo "<input required  type='" . $type4[$j] . "' class=' form-control form-control-lg' placeholder='Valore' id='da" . "$j'>" ;
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


    echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='submitInsertAz'><span id='show-loading'><i class='fa fa-plus'></i> Inserisci</span></div >";
    echo "</div>";



    echo "</form>";

    $_SESSION["tableContatti"] = $table;





exit();
?>
