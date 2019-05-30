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
    $table = "credenziali";

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
   echo "<h5 class='title'>Inserimento di username e password dello studente: </h5>";

/*

  This foreach create the input and the labels dinamically.
  All if statement has a different pattern for controll user input.

*/
foreach($fields as $field)
{
  $field = str_replace("_", " ", $field);
  if(strtolower(str_replace(" ", "", $field))==strtolower("livello"))
  {
    echo "<label class='form-padding' for='" . $type[$i] . " 'id='field'>" . $field . ":</label>" ;

    echo "<input required  readonly class='form-control form-control-lg' placeholder='Valore' value='4' id='" . "$i'>" ;
  }
    else
    if($type[$i]=="text")
    {
     
      // Password field:
      if($i==1)
      {
        echo "<label class='form-padding' for='" . $type[$i] . " 'id='field'>" . $field . ":</label>" ;

        echo "<input pattern='[a-zA-Z0-9]{1,}' required  type='password' class='form-control form-control-lg' placeholder='Valore' id='" . "$i'>" ;
      }
      else
      {
        echo "<label class='form-padding' for='" . $type[$i] . " 'id='field'>" . $field . ":</label>" ;

        echo "<input pattern='[a-zA-Z0-9\s]{1,}' required  type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='" . "$i'>" ;
      }


    }
    else {
      if($type[$i]=="number")
      {

        echo "<label class='form-padding' for='" . $type[$i] . " 'id='field'>" . $field . ":</label>" ;

        echo "<input pattern='[0-9]' required  type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='" . "$i'>" ;

      }
      else
        {
          if($type[$i]=="date")
          {

            echo "<label class='form-padding' for='" . $type[$i] . " 'id='field'>" . $field . ":</label>" ;

            echo "<input pattern='[0-9]' required  type='" . $type[$i] . "' class='form-control form-control-lg' placeholder='Valore' id='" . "$i'>" ;

          }
          else
          {
            echo "<label class='form-padding' for='" . $type[$i] . " 'id='field'>" . $field . ":</label>" ;

            echo "<input required  type='" . $type[$i] . "' class='form-control form-control' placeholder='Valore' id='" . "$i'>" ;
          }
        }
    }

// We increment the counter $i for the next input:
    $i++;




}

// We store the credentials table in the session array:
   $_SESSION["tableCredenziali"] = $table;

// We create a div button that when user click the javascript shows the next fields:
   echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='insertStudentContinue'>Continua <i class='fas fa-arrow-right'></i> </div >";

   echo "</div>";
// We overwrite the variable $table with the Student table:
    $table = "classi";

// This part is the same as up:
   $fields = $query->getFieldsName($table);
   array_shift($fields);

   $nFields = count($fields);

   $meta = $query->columnMeta($table, $nFields);



// We initialize a type2 array:
   $type2 = array();

for($j=0; $j<$nFields; $j++)
  $type2[$j] = $query->translateNativeType($meta[$j]);

// We crete a div with a class that show when user click on continue button:
    echo "<div class='insert-show-when-pressed'>";

echo "<h5 class='title'>Inserimento dati classe: </h5>";

$j = 0;
foreach($fields as $field)
{
  $field = str_replace("_", " ", $field);

    if(strtolower($field)==strtolower("Indirizzo"))
    {


      echo "<div id='input-box-insert' class='form-box-insert'>";
      echo "<label class='form-padding' for='" . $type[$j] . " 'id='field-class'>" . $field . ":</label>";
      echo "<select id='class-address' class='browser-default custom-select bg-dark  custom-select-lg mb-3 text-white'>";
      echo "<option disabled selected>Inserisci l'indirizzo di studio</option>";
      echo "<option>Istituto Tecnico Settore Tecnologico - Informatica e Telecomunicazioni </option>";
      echo "<option>Liceo Linguistico</option>";
      echo "<option>Liceo Scientifico</option>";
      echo "<option>Istituto Tecnico Settore Tecnologico - Meccanica, Meccatronica ed Energia</option>";
      echo "<option>Istituto Tecnico Settore Economico</option>";
      echo "<option>Istituto Professionale per i Servizi Sociali</option>";
      echo "<option>Istituto Professionale settore Industria e Artigianato</option>";
      echo "</select>";
      echo "</div>";
    }
    else
    if($j==1)
    {
      echo "<div id='input-box-insert' class='form-box-insert'>";
      echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-class'>" . $field . ":</label>" ;

      echo "<input pattern='[a-zA-Z0-9]{1,}' required  type='text' class='form-control form-control-lg' placeholder='Valore' id='c" . "$j'>" ;
      echo "</div>";
    }
    else
    if($type2[$j]=="text")
    {
      // Because the username it's already insert by user:

        echo "<div id='input-box-insert' class='form-box-insert'>";
        echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-class'>" . $field . ":</label>" ;

        echo "<input pattern='[a-zA-Z0-9]{1,}' required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='c" . "$j'>" ;
        echo "</div>";

    }
    else {
      if($type2[$j]=="number")
      {
        echo "<div id='input-box-insert' class='form-box-insert'>";

        echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-class'>" . $field . ":</label>" ;

        echo "<input pattern='[0-9]' required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='c" . "$j'>" ;
        echo "</div>";

      }
      else
        {
          if($type2[$j]=="date")
          {
            echo "<div id='input-box-insert' class='form-box-insert'>";

            echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-class'>" . $field . ":</label>" ;

            echo "<input pattern='[0-9]' required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='c" . "$j'>" ;
            echo "</div>";

          }
          else
          {
            echo "<div id='input-box-insert' class='form-box-insert'>";
            echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-class'>" . $field . ":</label>" ;

            echo "<input required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='c" . "$j'>" ;

          }
        }
    }

    $j++;

}

// We create a submit button for send data to the php script by using an ajax call:
  echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='insertStudentContinue2'>Continua <i class='fas fa-arrow-right'></i> </div >";
  echo "</div>";

// We save the table inside the array session:
  $_SESSION["tableClasse"] = $table;
   // We overwrite the variable $table with the Student table:
   $table = "studenti";

   // This part is the same as up:
      $fields = $query->getFieldsName($table);

      $nFields = count($fields);

      $meta = $query->columnMeta($table, $nFields);

   // The first name is stored in session array, because it contains the primary key:
      $_SESSION["firstFieldName"] = $fields[0];

   // We initialize a type2 array:
      $type3 = array();

   for($j=0; $j<$nFields; $j++)
     $type3[$j] = $query->translateNativeType($meta[$j]);

   // We crete a div with a class that show when user click on continue button:
       echo "<div class='insert-show-when-pressed2'>";

   echo "<h5 class='title'>Inserimento dati studente: </h5>";

   $j = 0;
   foreach($fields as $field)
   {
    $field = str_replace("_", " ", $field);
   
    if(strtolower(str_replace(" ", "", $field))==strtolower("Email"))
    {
      echo "<div id='input-box-insert' class='form-box-insert'>";
  
      echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-values'>" . $field . "</label>:" ;
      echo "<input required  type='email' class='form-control form-control-lg' placeholder='Valore' id='s" . "$j'>" ;
      echo "</div>";
    }
    else
       if($type3[$j]=="text")
       {
         // Because the username it's already insert by user:
          if($j==$nFields-1)
          {
            echo "<div id='input-box-insert' class='form-box-insert'>";

              echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-values'>" . $field . ":</label>" ;
              echo "<div id='input-readonly'></div>";
            echo "</div>";
          }
          else
          {
            echo "<div id='input-box-insert' class='form-box-insert'>";

            echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-values'>" . $field . ":</label>" ;

            echo "<input pattern='[a-zA-Z0-9\s]{1,}' required  type='" . $type3[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='s" . "$j'>" ;
            echo "</div>";

          }




       }
       else {
         if($type3[$j]=="number")
         {
           echo "<div id='input-box-insert' class='form-box-insert'>";

           echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-values'>" . $field . ":</label>" ;

           echo "<input pattern='[0-9]' required  type='" . $type3[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='s" . "$j'>" ;
           echo "</div>";

         }
         else
           {
             if($type3[$j]=="date")
             {
               echo "<div id='input-box-insert' class='form-box-insert'>";

               echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-values'>" . $field . ":</label>" ;

               echo "<input pattern='[0-9]' required  type='" . $type3[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='s" . "$j'>" ;
               echo "</div>";

             }
             else
             {
              echo "<div id='input-box-insert' class='form-box-insert'>";
               echo "<label class='form-padding' for='" . $type3[$j] . " 'id='field-values'>" . $field . ":</label>" ;

               echo "<input required  type='" . $type3[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='s" . "$j'>" ;
               echo "</div>";
             }
           }
       }

       $j++;

   }

   $_SESSION["tableStudente"] = $table;
   echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='insertStudentContinue3'>Continua <i class='fas fa-arrow-right'></i> </div >";
   echo "</div>";
  // We overwrite the variable $table with the Student table:
  $table = "studenti_classi";

  // This part is the same as up:
     $fields = $query->getFieldsName($table);

     array_shift($fields);
     unset($fields[1]);
     $nFields = count($fields);

     $meta = $query->columnMeta($table, $nFields);

  // The first name is stored in session array, because it contains the primary key:
     $_SESSION["firstFieldName"] = $fields[0];

  // We initialize a type2 array:
     $type3 = array();

  for($j=0; $j<$nFields; $j++)
    $type4[$j] = $query->translateNativeType($meta[$j]);

    $type4[1] = "text";

  // We crete a div with a class that show when user click on continue button:
      echo "<div class='insert-show-when-pressed3'>";

  echo "<h5 class='title'>Inserimento anno scolastico: </h5>";

  $j = 0;
  foreach($fields as $field)
  {
     $field = str_replace("_", " ", $field);
      if($j==0)
      {
        echo "<div id='input-box-insert' class='form-box-insert'>";

        echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-year'>" . $field . ":</label>" ;

        echo "<div id='input-readonly-matr'></div>";

        echo "</div>";
      }
      else
        {
          if($type4[$j]=="text")
          {
            // Because the username it's already insert by user:

            echo "<div id='input-box-insert' class='form-box-insert'>";

               echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-year'>" . $field . ":</label>" ;

               echo "<input pattern='[a-zA-Z0-9\s]{1,}' required  type='" . $type4[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='sc" . "$j'>" ;
               echo "</div>";






          }
          else {
            if($type4[$j]=="number")
            {
              echo "<div id='input-box-insert' class='form-box-insert'>";

              echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-year'>" . $field . ":</label>" ;

              echo "<input pattern='[0-9]' required  type='" . $type4[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='sc" . "$j'>" ;
              echo "</div>";

            }
            else
              {
                if($type4[$j]=="date")
                {
                  echo "<div id='input-box-insert' class='form-box-insert'>";

                  echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-year'>" . $field . ":</label>" ;

                  echo "<input pattern='[0-9]' required  type='" . $type4[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='sc" . "$j'>" ;
                  echo "</div>";

                }
                else
                {
                 echo "<div id='input-box-insert' class='form-box-insert'>";
                  echo "<label class='form-padding' for='" . $type4[$j] . " 'id='field-year'>" . $field . ":</label>" ;

                  echo "<input required  type='" . $type4[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='sc" . "$j'>" ;
                  echo "</div>";
                }
              }
          }
        }



      $j++;

  }

  $_SESSION["tableStClassi"] = $table;
  echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='submitInsertStudent'><span id='show-loading'><i class='fa fa-plus'></i> Inserisci</span></div >";
  echo "</div>";
  echo "</form>";



exit();
?>
