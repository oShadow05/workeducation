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
      $livello = $_SESSION["livello"];
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
?>
<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>WORKER EDUCATION - DATA</title>
</head>
<body>
  <div id="tab-student">
      <div class="table-responsive" id="content">
        <table class="table table-bordered" id="dataTableStudenti" width="100%" cellspacing="0">
          <thead>
            <tr class="capitalize">
              <th>Matricola</th>
              <th>Cognome</th>
              <th>Nome</th>
              <th>Codice Fiscale</th>
              <th>Data Di Nascita</th>
              <th>Comune Di Nascita</th>
              <th>Provincia Di Nascita</th>
              <th>Indirizzo</th>
              <th>C.A.P</th>
              <th>Telefono</th>
              <th>Email</th>
              <th>Username</th>
              <th>Classe</th>
              <th>Percorso Studi</th>
            </tr>
          </thead>
          <tfoot class="capitalize">
            <tr>
              <th>Matricola</th>
              <th>Cognome</th>
              <th>Nome</th>
              <th>Codice Fiscale</th>
              <th>Data Di Nascita</th>
              <th>Comune Di Nascita</th>
              <th>Provincia Di Nascita</th>
              <th>Indirizzo</th>
              <th>C.A.P</th>
              <th>Telefono</th>
              <th>Email</th>
              <th>Username</th>
              <th>Classe</th>
              <th>Percorso Studi</th>
            </tr>
          </tfoot>
          <tbody>
          <?php
                $select = $query->selectStudenti();
                if($select!=NULL)
                {
                  foreach($select as $row)
                  {
                    echo "<tr>";
                    echo "<td>" . $row["Matricola"] ."</td>";
                    echo "<td>" . $row["Cognome"] ."</td>";
                    echo "<td>" . $row["Nome"] ."</td>";
                    echo "<td>" . $row["CF"] ."</td>";
                    {
                      $date = new DateTime($row["Data_Nascita"]);
                      echo "<td>" . $date->format("d/m/Y") ."</td>";
                    }
                    echo "<td>" . $row["Comune_Nascita"] ."</td>";
                    echo "<td>" . $row["Provincia_Nascita"] ."</td>";
                    echo "<td>" . $row["Indirizzo"] ."</td>";
                    echo "<td>" . $row["CAP"] ."</td>";
                    echo "<td>" . $row["Telefono"] ."</td>";
                    echo "<td>" . $row["Email"] ."</td>";
                    echo "<td>" . $row["Username"] ."</td>";
  
                    echo "<td>" . $row["Classe"] . $row["Sezione"] ."</td>";
                    echo "<td>" . $row["PercorsoStudi"] . "</td>";
  
  
                    echo "</tr>";
                  }
                }
               

          ?>

          </tbody>
        </table>
  </div>
</div>

<div id="tab-docenti">
      <div class="table-responsive" id="content">
        <table class="table table-bordered" id="dataTableDocenti" width="100%" cellspacing="0">
          <thead>
            <tr class="capitalize">
              <th>Id docente</th>
              <th>Cognome</th>
              <th>Nome</th>
              <th>Email</th>
              <th>Telefono</th>
              <th>Username</th>
           
            </tr>
          </thead>
          <tfoot class="capitalize">
            <tr>
            <th>Id docente</th>
              <th>Cognome</th>
              <th>Nome</th>
              <th>Email</th>
              <th>Telefono</th>
              <th>Username</th>
            </tr>
          </tfoot>
          <tbody>
          <?php
                $selectDocenti = $query->select("docenti");
                if($selectDocenti!=NULL)
                {
                  foreach($selectDocenti as $row)
                  {
                    echo "<tr>";
                    echo "<td>" . $row["Id_Docente"] ."</td>";
                    echo "<td>" . $row["Cognome"] ."</td>";
                    echo "<td>" . $row["Nome"] ."</td>";
                    echo "<td>" . $row["Email"] ."</td>";
                    echo "<td>" . $row["Telefono"] ."</td>";
                    echo "<td>" . $row["Username"] ."</td>";
  
  
                    echo "</tr>";
                  }
                }
             

          ?>

          </tbody>
        </table>
  </div>
</div>

<div id="tab-aziende">
      <div class="table-responsive" id="content">
        <table class="table table-bordered" id="dataTableAziende" width="100%" cellspacing="0">
          <thead>
            <tr class="capitalize">
              <th>Id azienda</th>
              <th>ragione sociale</th>
              <th>Partita iva</th>
              <th>Codice fiscale</th>
              <th>Numero dipendenti</th>
              <th>sede legale</th>
              <th>Provincia sede legale</th>
              <th>email</th>
              <th>Telefono</th>

           
            </tr>
          </thead>
          <tfoot class="capitalize">
            <tr>
            <th>Id azienda</th>
              <th>ragione sociale</th>
              <th>Partita iva</th>
              <th>Codice fiscale</th>
              <th>Numero dipendenti</th>
              <th>sede legale</th>
              <th>Provincia sede legale</th>
              <th>email</th>
              <th>Telefono</th>
            </tr>
          </tfoot>
          <tbody>
          <?php
                $selectAziende = $query->select("aziende");
                if($selectAziende!=NULL)
                {
                  foreach($selectAziende as $row)
                  {
                    echo "<tr>";
                    echo "<td>" . $row["Id_Azienda"] ."</td>";
                    echo "<td>" . $row["Ragione_Sociale"] ."</td>";
                    echo "<td>" . $row["P_Iva"] ."</td>";
                    echo "<td>" . $row["C_F"] ."</td>";
                    echo "<td>" . $row["N_Dipendenti"] ."</td>";
                    echo "<td>" . $row["Sede_Legale"] ."</td>";
                    echo "<td>" . $row["Provincia_Sede_Legale"] ."</td>";
                    echo "<td>" . $row["Email"] ."</td>";
  
                    echo "<td>" . $row["Telefono"] ."</td>";
  
                    echo "</tr>";
                  }
                }
              

          ?>

          </tbody>
        </table>
  </div>
</div>
</body>
</html>
