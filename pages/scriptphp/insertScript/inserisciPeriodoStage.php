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


$nFieldsStage =  json_decode(stripslashes($_POST['nFieldsStage']));
$valuesStage  =  json_decode(stripslashes($_POST['valuesStage']));

$dateStart    =   $valuesStage[2];
$dateEnd      =   $valuesStage[3];



array_unshift($valuesStage, "NULL");
var_dump($valuesStage);
$bindStage = str_repeat('?,', $nFieldsStage) . '?';


$insert = $query->insert(addslashes($_SESSION["tablePeriodiStage"]), $bindStage, $valuesStage);

if($insert==false)
{
  echo "<h4 id='status-err'>Errore nell'inserimento del periodo</h4>";
}
else {
    echo "<h4 id='status-ok'>Periodo inserito!</h4>";
}

$selectIdPrt = $query->select("periodi_stage");


$viewName = "stage";
$select = $query->createStage($viewName);

/*
$classCode = $valuesStage[3];



$studentCode = $valuesStage[4];

$profCode = $valuesStage[5];

$employeeCode = $valuesStage[6];

$studentData = $query->selectStudentForStage($studentCode);
$usernameDip = $query->selectUsernameDipendente($employeeCode);

$employeeData = $query->selectEmployeeForStage($employeeCode);

$usernameStudent = $query->selectUsernameStudent($studentCode);


$usernameProfessor = $query->selectUsernameProfessor($profCode);

echo "<br>";


$classData = $query->selectClassForStage($classCode);


$profData =  $query->selectProfForStage($profCode);



$countClassData = count($classData);

$countStudentData = count($studentData);




$insertData = array();


$numElementsStudentData = array_sum(array_map("count", $studentData));

$numElementsClassData = array_sum(array_map("count", $classData));

$numElementsProfData = array_sum(array_map("count", $profData));


array_push($insertData, $dateStart);
array_push($insertData, $dateEnd);



echo "<br>";

for($i=0; $i<$numElementsStudentData; $i++)
{
  array_push($insertData,$studentData[0][$i]);
}


array_push($insertData, $usernameStudent[0][0]);

echo "<br>";




echo "<br>";


for($i=0; $i<$numElementsClassData; $i++)
{
  array_push($insertData,$classData[0][$i]);
}



echo "<br>";


for($i=0; $i<$numElementsProfData; $i++)
{
  array_push($insertData,$profData[0][$i]);
}

array_push($insertData, $usernameProfessor[0][0]);

array_push($insertData, $employeeData[0][0]);

array_push($insertData, $usernameDip[0][0]);





array_push($insertData, "");

$totalElements = count($insertData);

echo "$totalElements";
$bindInsert = str_repeat('?,',  $totalElements-1) . '?';

$query->insert("stage", $bindInsert, $insertData);
*/
exit();
?>
