
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


  // Request data:
    $matricola     = json_decode(stripslashes($_POST['matricola']));
    $idDocente     = json_decode(stripslashes($_POST['idDocente']));
    $idDipendente  = json_decode(stripslashes($_POST['idDipendente']));
    $dateStart     = json_decode(stripslashes($_POST['dateStart']));
    $dateEnd    = json_decode(stripslashes($_POST['dateEnd']));


    $datiStudente  = $query->getDatiStudente($matricola);
    $datiProf      = $query->getDatiDocente($idDocente);
    $datiAzienda   = $query->getDatiAzienda($idDipendente);
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Patto Formativo</title>
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
          <br>
          <table id="table-2">
            <thead>
              <th>Dati Studente:</th>
            </thead>
              <tr>
                <td>Nominativo studente:</td>
                <td><?php echo $datiStudente[0]["nome"] . " " . $datiStudente[0]["cognome"];?></td>
                <td>Codice fiscale studente:</td>
                <td><?php echo $datiStudente[0]["codiceFiscale"];?></td>
              </tr>
              <tr>
                <td>Classe:</td>
                <td><?php echo $datiStudente[0]["classe"];?></td>
                <td>Sezione:</td>
                <td><?php echo $datiStudente[0]["sezione"];?></td>
                <td>Indirizzo scolastico:</td>
                <td><?php echo $datiStudente[0]["indirizzo"];?></td>
                <td>Nell'anno scolastico:</td>
                <td><?php echo $datiStudente[0]["anno_scolastico"];?></td>
              </tr>
          </table>
          <br>
          <table id="table-3">

              <thead>
                <th>Dati scuola: </th>
              </thead>

              <tr>
                <td>Scuola:</td>
                <td>IISS "Piero Gobetti" Via della Repubblica, 41 Scandiano (RE)</td>

              </tr>
              <tr>
                <td>Tutor Scolastico:</td>
                <td>Prof. <?php echo $datiProf[0]["cognome"] . " " . $datiProf[0]["nome"];?> - Tel. <?php echo $datiProf[0]["telefono"];?></td>

              </tr>
          </table>
      <br>
          <table id="table-4">
              <thead>
                <th>Periodo/i e orari in azienda:</th>
              </thead>
              <tr>
                <td>Data:</td>
              <td>dal <?php echo $dateStart ;?> al  <?php echo $dateEnd ;?></td>
              </tr>
              <tr>
                <td>
                  Orari:
                </td>
                <td>
                  Lun: dalle <?php echo  $datiAzienda[0]["ora_in_ma"];?> alle <?php echo  $datiAzienda[0]["ora_us_ma"];?>  - dalle <?php echo  $datiAzienda[0]["ora_in_po"];?>  alle <?php echo  $datiAzienda[0]["ora_us_po"]?> Mar: dalle <?php echo  $datiAzienda[0]["ora_in_ma"]?> alle <?php echo  $datiAzienda[0]["ora_us_ma"];?> - dalle <?php echo  $datiAzienda[0]["ora_in_po"];?> alle <?php echo  $datiAzienda[0]["ora_us_po"]?> Mer: dalle <?php echo  $datiAzienda[0]["ora_in_ma"]?> alle <?php echo  $datiAzienda[0]["ora_us_ma"];?> - dalle <?php echo  $datiAzienda[0]["ora_in_po"];?>  alle <?php echo  $datiAzienda[0]["ora_us_po"];?> Gio: dalle <?php echo  $datiAzienda[0]["ora_in_ma"];?> alle <?php echo  $datiAzienda[0]["ora_us_ma"];?> - dalle <?php echo  $datiAzienda[0]["ora_in_po"]?> alle  <?php echo  $datiAzienda[0]["ora_us_po"];?> Ven: dalle  <?php echo  $datiAzienda[0]["ora_in_ma"]?> alle <?php echo  $datiAzienda[0]["ora_us_ma"]?> - dalle <?php echo  $datiAzienda[0]["ora_in_po"]?> alle  <?php echo  $datiAzienda[0]["ora_us_po"];?>
                </td>
              </tr>
          </table>
          <br>
          <div id="nota-patto">
in procinto di frequentare attivita' di alternanza scuola lavoro presso la seguente struttura ospitante.</div>



          <table id="table-5">
            <thead>
              <th>Azienda ospitante:</th>
            </thead>
            <tr>
              <td>Sede/i del tirocinio:</td>
              <td><?php echo $datiAzienda[0]["indirizzo"];?></td>
            </tr>
            <tr>
              <td>Tutor aziendale:</td>
              <td><?php echo $datiAzienda[0]["cognome"] . " " . $datiAzienda[0]["nome"];?></td>
            </tr>
          </table>
          <br>

        <table id="table-6">

          <thead>
            <th>Polizze assicurative</th>
          </thead>
          <tr>
            <td>Infortuni sul lavoro:</td>
            <td> POSIZIONE INAIL IN CONTO STATO N. 2656 - COD. MINISTERO N.18800 </td>
          </tr>

          <tr>
            <td>Responsabilita' civile:</td>
            <td>polizza infortuni e R.C. GRUPPO SICUREZZA SCUOLA POLIZZA N. 24988</td>
          </tr>
          <tr>
            <td>Assicurazione :</td>
            <td>BENAQUISTA - CHARTIS EUROPE S.A.</td>
          </tr>
        </table>
        <br>
        <div id="text-patto">
          <h3>DICHIARA</h3>

- di essere a conoscenza che le attivita' che andra' a svolgere costituiscono parte integrante del
percorso formativo;

- di essere a conoscenza che la partecipazione al progetto di alternanza scuola lavoro non
comporta alcun legame diretto tra il sottoscritto e la struttura ospitante in questione e che ogni
rapporto con la struttura ospitante stessa cessera' al termine di questo periodo;

- di essere a conoscenza delle norme comportamentali previste dal C.C.N.L., le norme
antinfortunistiche e quelle in materia di privacy;

- di essere consapevole che durante i periodi di alternanza e' soggetto alle norme stabilite nel
regolamento degli studenti dell'istituzione scolastica di appartenenza,
nonche' alle regole di comportamento, funzionali e organizzative della struttura ospitante;




- di essere a conoscenza che, nel caso si dovessero verificare episodi di particolare gravita', in
accordo con la struttura ospitante si procedera' in qualsiasi momento alla sospensione
dell'esperienza di alternanza;

- di essere a conoscenza che le attivita' che andra' a svolgere costituiscono parte integrante del
percorso formativo;

- di essere a conoscenza che nessun compenso o indennizzo di qualsiasi natura gli e' dovuto
in conseguenza della sua partecipazione al programma di alternanza scuola lavoro;

- di essere a conoscenza che l'esperienza di alternanza scuola lavoro non comporta impegno di
assunzione presente o futuro da parte della struttura ospitante;

- di essere a conoscenza delle coperture assicurative sia per i trasferimenti alla sede di svolgimento
delle attivita' di alternanza scuola lavoro che per la permanenza nella struttura ospitante.


          <h4 >SI IMPEGNA</h4>

- a rispettare rigorosamente gli orari stabiliti dalla struttura ospitante per lo svolgimento delle
attivita' di alternanza scuola lavoro;

- a seguire le indicazioni dei tutor e fare riferimento ad essi per qualsiasi esigenza o evenienza;

- ad avvisare tempestivamente sia la struttura ospitante che l'istituzione scolastica se
impossibilitato a recarsi nel luogo del tirocinio;

- a presentare idonea certificazione in caso di malattia;

- a tenere un comportamento rispettoso nei riguardi di tutte le persone con le quali verra' a contatto
presso la struttura ospitante;

- a completare in tutte le sue parti, l'apposito registro di presenza presso la struttura ospitante;

- a comunicare tempestivamente e preventivamente al coordinatore del corso eventuali trasferte al
di fuori della sede di svolgimento delle attivita' di alternanza scuola lavoro per fiere, visitepresso altre strutture del gruppo della struttura ospitante ecc.;

- a raggiungere autonomamente la sede del soggetto ospitante in cui si svolgera' l'attivita' di
alternanza scuola-lavoro;

- ad adottare per tutta la durata delle attivita' di alternanza le norme comportamentali previste dal
C.C.N.L.;

- ad osservare gli orari e i regolamenti interni dell'azienda, le norme antinfortunistiche, sulla
sicurezza e quelle in materia di privacy.

      </div>
      <div id="footer">




        Scandiano, <?php echo date("d/m/Y");?>

        Soggetto promotore - Istituto Piero Gobetti
        Il Tirocinante    - <?php echo $datiStudente[0]["cognome"] . " " . $datiStudente[0]["nome"]; ?>

        Soggetto ospitante - <?php echo $datiAzienda[0]["ragione_sociale"];?>

        dichiaro di aver preso visione di quanto riportato nel presente documento e di autorizzare
        lo/la studente/ssa

        ......................................................................................................
        a partecipare alle attivita' previste.

        IL DIRIGENTE SCOLASTICO
        Fausto Fiorani

        ..................................................................................…

        IL LEGALE RAPPRESENTANTE
        <?php  echo $datiAzienda[0]["legale_rappresentante"];?>

        ..................................................................................…

        LO STUDENTE
        <?php echo $datiStudente[0]["cognome"] . " " . $datiStudente[0]["nome"]; ?>

        .....................................................................................

        SOGGETTO ESERCENTE LA PATRIA POTESTA'

        .....................................................................................
        (scrivere cognome e nome leggibile)
</div>

  </body>
</html>
