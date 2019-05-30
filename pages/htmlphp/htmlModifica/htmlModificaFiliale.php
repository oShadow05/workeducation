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



echo " <form class='md-form' id='cred-input-form-upd-fi'> ";
echo "<h5 class='title'>Modifica dati filiale: </h5>";

  $table = "filiali";
  $fields = $query->getFieldsName($table);
  $nFields = count($fields);
  $change = true;
  $meta = $query->columnMeta($table, $nFields);
  $type2 = array();
  for($i=0; $i<$nFields; $i++)
    $type2[$i] = $query->translateNativeType($meta[$i]);
    $j = 0;
    foreach($fields as $field)
    {
      $field = str_replace("_", " ", $field);
        if(str_replace(" ", "",strtolower($field))==str_replace(" ", "", strtolower("id azienda")))
        {
            $change = false;
        }
        else
        {
        if($type2[$j]=="text" && $j!=$nFields-1)
        {
  
            echo "<div id='input-box-insert' class='form-box-update'>";
            echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-update-filiale'>" . $field . "</label>" ;
  
            echo "<input pattern='[a-zA-Z0-9\s]{1,}' required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='ff-upt" . "$j'>" ;
            echo "</div>";
  
        }
        else {
            $change = true;
          if($type2[$j]=="number")
          {
            echo "<div id='input-box-insert' class='form-box-update'>";
  
            echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-update-filiale'>" . $field . "</label>" ;
  
            echo "<input pattern='[0-9]' required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='ff-upt" . "$j'>" ;
            echo "</div>";
  
          }
          else
          {
            if(strtolower($field)==strtolower("Note"))
            {
                echo "<div id='input-box-insert' class='form-box-update'>";
  
                echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-update-filiale'>" . $field . "</label>" ;
  
                echo "<textarea  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Qui puoi inserire una descrizione' id='ff-upt" . "$j'></textarea>" ;
                echo "</div>";
  
            }
            else
            {
              if($type2[$j]=="date")
              {
                echo "<div id='input-box-insert' class='form-box-update'>";
  
                echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-update-filiale'>" . $field . "</label>" ;
  
                echo "<input pattern='[0-9]' required  type='" . $type2[$j] . "' class='form-control-lg' placeholder='Valore' id='ff-upt" . "$j'>" ;
                echo "</div>";
  
              }
              else
              {
                echo "<div id='input-box-insert' class='form-box-update'>";
  
                echo "<label class='form-padding' for='" . $type2[$j] . " 'id='field-update-filiale'>" . $field . "</label>" ;
  
                echo "<input required  type='" . $type2[$j] . "' class='form-control form-control-lg' placeholder='Valore' id='ff-upt" . "$j'>" ;
                echo "</div>";
              }
            }
  
  
          }
  
  
        }
        }
        $j++;
  
    }

  echo "<div class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0' id='submitUpdateFiliale'><span id='show-loading'><i class='fa fa-edit'></i> Modifica</span></div >";

  echo "</div>";

  $_SESSION["tableUpdate"] = $table;


echo "</form>";


exit();
?>
