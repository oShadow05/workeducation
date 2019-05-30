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
         if($livello==3)
        {
            $conn = new RequestDatabaseHandler($host, $type, $dbName, $userAz, $passwordLoginAzienda);

            $conn->request();
        }
        else
        {
            if($livello==4)
            {
                $conn = new RequestDatabaseHandler($host, $type, $dbName, $userSt, $passwordLoginStandard);
        
                $conn->request();
            }
            else{
                echo "<h1>Non sei autorizzato ad accedere a questa pagina</h1>";
            }
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

    $matricola     = json_decode(stripslashes($_POST['matricola']));
    $idDocente     = json_decode(stripslashes($_POST['idDocente']));
    $idDipendente  = json_decode(stripslashes($_POST['idDipendente']));
    $dateStart     = json_decode(stripslashes($_POST['dateStart']));
    $dateEnd    = json_decode(stripslashes($_POST['dateEnd']));
    $protocollo = json_decode(stripslashes($_POST['codProtocollo']));


    $datiStudente  = $query->getDatiStudente($matricola);
    $datiProf      = $query->getDatiDocente($idDocente);
    $datiAzienda   = $query->getDatiAzienda($idDipendente);

  



?>


<!DOCTYPE html>
<html lang="it">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Registro</title>
    </head>
    <body>
        <table id="table-1">
        <tr>
         <td>
         </td>
          <td>
              I.I.S.S.''Piero Gobetti'' LICEO:  Scientifico - Linguistico TECNICO: Amministrazione Finanza Marketing - Meccanica Meccatronica Energia - Informatica e Telecom. PROFESSIONALE: Servizi Socio Sanitari - Manutenzione e Assistenza Tecnica
          </td>
          <td>
            Via della Repubblica, 41 42019 Scandiano (RE) tel. 0522 855485/854360 fax. 0522 984149 www.istitutogobetti.gov.it reis00300n@istitutogobetti.it Codice fiscale 91001560357
          </td>
        </tr>
      </table>
      <table id="table-2">
        <tr>
            <td>STUDENTE</td>
            <td>C.f.:</td>
            <td><?php echo $datiStudente[0]["codiceFiscale"]; ?></td>
            <td>Cognome</td>
            <td><?php echo $datiStudente[0]["cognome"]; ?></td>
            <td>Nome</td>
            <td><?php echo $datiStudente[0]["nome"]; ?></td>
        </tr>
        <tr>
            <td>Classe:</td>
            <td><?php echo $datiStudente[0]["classe"]; ?></td>
            <td>Sezione:</td>
            <td><?php echo $datiStudente[0]["sezione"]; ?></td>
            <td>Indirizzo</td>
            <td colspan="2"><?php echo $datiStudente[0]["indirizzo"]; ?></td>


        </tr>
        <tr>
            <td>Scuola:</td>
            <td colspan="3">IISS “PIERO GOBETTI”</td>
            <td colspan="3">Anno scolastico: <?php $date = date("Y"); $date2 = date("Y") + 1; echo $date . " - " . $date2;?></td>
        </tr>
        <tr>


<td>AZIENDA</td>
<td>Nome:</td>
<td> <?php echo strtoupper($datiAzienda[0]["ragione_sociale"]); ?></td>
<td>P.i:</td>
<td colspan="3"><?php echo $datiAzienda[0]["p_iva"]; ?></td>
        </tr>
         <tr>
            <td>TUTOR AZIENDALE:</td>
            <td><?php  echo $datiAzienda[0]["nome"] . " " . $datiAzienda[0]["cognome"];?></td>
            <td>TUTOR SCOLASTICO:</td>
            <td colspan="4"><?php echo $datiProf[0]["nome"] . " " . $datiProf[0]["cognome"]; ?></td>
        </tr>
         <tr>
            <td>PERIODO:</td>
            <td>Dal <?php   echo $dateStart;?> al <?php echo $dateEnd; ?></td>
            <td>Protocollo</td>
            <td><?php echo $protocollo; ?> del <?php echo date("d/m"); ?></td>
            <td>Foglio</td>
            <td colspan="2">Registro settimane 1, 2 e 3</td>
        </tr>
        <tr >
            <td>NOTE:</td>
            <td colspan="6" >

            </td>
        </tr>
      </table>

      <table id="table-3">
      <thead>
            <th>Data</th>
            <th>*</th>
            <th>Dalle</th>
            <th>Alle</th>
            <th>Ore</th>
<th>Descrizione lavoro</th>
            <th>Firma tutor</th>
            <th>Firma studente</th>
      </thead>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
 <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
     <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      </table>

      <div id="text-1">
        (*) M: mattino  P: pomeriggio. Nella data specificare giorno/mese (es. 10/02 per il 10 febbraio)
      </div>


      <table id="table-4">
      <thead>
            <th>Data</th>
            <th>*</th>
            <th>Dalle</th>
            <th>Alle</th>
            <th>Ore</th>
            <th>Descrizione lavoro</th>
            <th>Firma tutor</th>
            <th>Firma studente</th>
      </thead>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
 <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
     <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>M</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      <tr>
        <td></td>
        <td>P</td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
     </tr>
      </table>

      <div id="text-2">
        luogo e data: ............................... ...../...../..........
      </div>

      <table id="table-5">
        <tr>
          <td>
          Firma tutor aziendale: <?php echo strtoupper($datiAzienda[0]["nome"]) . " " . strtoupper($datiAzienda[0]["cognome"]);?>
          </td>
        </tr>
        <tr>
          <td>
          Timbro azienda: <?php echo strtoupper($datiAzienda[0]["ragione_sociale"]); ?>
          </td>
        </tr>
      </table>
    </body>
</html>
