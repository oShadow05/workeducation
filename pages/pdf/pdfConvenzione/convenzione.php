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
    <title>Convenzione</title>
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
              <td>
                  Prot. <?php echo $protocollo; ?>/<?php echo date("d-m");?>
              </td>
              <td>
                  Scandiano, <?php echo date("d/m/Y");?>
              </td>
          </tr>
      </table>
      <div id="text-1">
L’Istituto d’Istruzione Secondaria Superiore “Piero Gobetti” con sede in via della Repubblica n° 41 a Scandiano  (RE)  codice  fiscale  n.  91001560357  d’ora  in  poi  denominato  “soggetto  promotore”, rappresentato dal Dirigente Scolastico Dott. Fiorani Fausto nato a Scandiano il 09/02/1960, codice fiscale FRNFST60B09I496H.
      </div>
      <div id="text-2">
l'azienda / ente <?php echo $datiAzienda[0]["ragione_sociale"]; ?> con sede legale in <?php echo $datiAzienda[0]["sede_legale"] ?>, d’ora in poi denominato “soggetto ospitante”, rappresentato/a da <?php echo $datiAzienda[0]["legale_rappresentante"]; ?>  domiciliato/a per la sua carica presso l’azienda/ente in premessa.
      </div>Permesso che
      <div id="text-3">
* ai sensi dell’art. 1 D. Lgs. 77/05, l’alternanza costituisce una modalità di realizzazione dei corsi nel secondo ciclo del  sistema d’istruzione e formazione, per assicurare ai  giovani l’acquisizione di competenze spendibili nel mercato del lavoro;

* ai sensi della legge 13 luglio 2015 n.107, art.1, commi 33-43, i percorsi di alternanza scuola lavoro, sono organicamente inseriti nel piano triennale dell’offerta formativa dell’istituzione scolastica come parte integrante dei percorsi di istruzione;

* l’alternanza scuola-lavoro è soggetta all’applicazione del D. Lgs. 9 aprile 2008, n .81 e successive modifiche;
      </div>Si Conviene quanto segue
      <div id="text-4">
lo svolgimento di un periodo di stage rientrante nel progetto formativo del percorso di Alternanza
Scuola – Lavoro in base alla Legge 107/2015, art. 1, commi dal 33 al 43 secondo le modalità che seguono.
      </div>Art.1
      <div id="text-5">
Il soggetto ospitante, si impegna ad accogliere a titolo gratuito presso le sue strutture n° 1 soggetto in alternanza scuola-lavoro su proposta del soggetto promotore nel periodo <?php echo $dateStart . " - " . $dateEnd; ?>
      </div>Art.2
      <div id="text-6">
l soggetto ospitante si impegna ad accogliere i soggetti di cui all’art. 1 presso la struttura ubicata in <?php echo $datiAzienda[0]["indirizzo"]; ?> - <?php echo $datiAzienda[0]["provincia_sede_legale"]; ?> Il tutor incaricato dal soggetto ospitante è <?php echo $datiAzienda[0]["nome"] . " " . $datiAzienda[0]["cognome"]; ?> (tutor formativo esterno).
L’articolazione oraria è fissata in base alla disponibilità della struttura accogliente nella fascia oraria <?php echo $datiAzienda[0]["ora_in_ma"] . " " . $datiAzienda[0]["ora_us_ma"]; ?> e <?php echo $datiAzienda[0]["ora_in_po"] . " " . $datiAzienda[0]["ora_us_po"]?>.

Il tutor del soggetto promotore è il prof. <?php echo $datiProf[0]["cognome"] . " "  . $datiProf[0]["nome"];?> (d’ora in poi denominato tutor interno).
      </div>Art.3
      <div id="text-7">
1) L’accoglimento dello/degli studente/i per i periodi di apprendimento in ambiente lavorativo non
costituisce rapporto di lavoro.

2) Ai fini e agli effetti delle disposizioni di cui al D. Lgs. 81/2008, lo studente in alternanza scuola
lavoro è equiparato al lavoratore, ex art. 2, comma 1 lettera a) del decreto citato.

3) L’attività  di  formazione  ed  orientamento  del  percorso  in  alternanza  scuola  lavoro  è
congiuntamente progettata e verificata da un docente tutor interno, designato dall’istituzione
scolastica, e da un tutor formativo della struttura, indicato dal soggetto ospitante, denominato
tutor formativo esterno;

4) Per ciascun allievo beneficiario del percorso in alternanza inserito nella struttura ospitante in base
alla  presente  Convenzione  è  predisposto  un  percorso  formativo  personalizzato,  che  fa  parte
integrante della presente Convenzione, coerente con il profilo educativo, culturale e professionale
dell’indirizzo di studi.

5) La titolarità del percorso, della progettazione formativa e della certificazione delle competenze
acquisite è dell’istituzione scolastica.

6) L’accoglimento  dello/degli  studente/i  minorenni  per  i  periodi  di  apprendimento  in  situazione
lavorativa non fa acquisire agli stessi la qualifica di “lavoratore minore” di cui alla L. 977/67 e
successive modifiche.
        </div>Art.4
        <div id="text-8">
1. Il tutor interno svolge le seguenti funzioni:
    a)  elabora, insieme al tutor esterno, il percorso formativo personalizzato sottoscritto dalle parti
    coinvolte (scuola, struttura ospitante, studente/soggetti esercenti la potestà genitoriale);

    b)  assiste e guida lo studente nei percorsi di alternanza e ne verifica, in collaborazione con il
    tutor esterno, il corretto svolgimento;

    c)  gestisce le relazioni con il contesto in cui si sviluppa l’esperienza di alternanza scuola lavoro,
    rapportandosi con il tutor esterno;

    d)  monitora le attività e affronta le eventuali criticità che dovessero emergere dalle stesse;

    e)  valuta,  comunica  e  valorizza  gli  obiettivi  raggiunti  e  le  competenze  progressivamente
    sviluppate dallo studente;

    f)  promuove l’attività di valutazione sull’efficacia e la coerenza del percorso di alternanza, da
    parte dello studente coinvolto;

    g)  informa gli organi scolastici preposti (Dirigente Scolastico, Dipartimenti, Collegio dei docenti,
    Comitato  Tecnico  Scientifico/Comitato  Scientifico)  ed  aggiorna  il  Consiglio  di  classe  sullo
    svolgimento dei percorsi, anche ai fini dell’eventuale riallineamento della classe;



    h)  assiste il Dirigente Scolastico nella redazione della scheda di valutazione sulle strutture con
    le quali sono state stipulate le convenzioni per  le attività di  alternanza, evidenziandone il
    potenziale formativo e le eventuali difficoltà incontrate nella collaborazione.

2. Il tutor formativo esterno svolge le seguenti funzioni:
    a)  collabora con il tutor interno alla progettazione, organizzazione e valutazione dell’esperienza
    di alternanza;

    b)  favorisce  l’inserimento  dello  studente  nel  contesto  operativo,  lo  affianca  e  lo  assiste  nel
    percorso;

    c)  garantisce  l’informazione/formazione  dello/i  studente/i  sui  rischi  specifici  aziendali,  nel
    rispetto delle procedure interne;
    d)  pianifica ed organizza le attività in base al progetto formativo, coordinandosi anche con altre
    figure professionali presenti nella struttura ospitante;

    e)  coinvolge lo studente nel processo di valutazione dell’esperienza;

    f)  fornisce all’istituzione scolastica gli elementi concordati per valutare le attività dello studente
    e l’efficacia del processo formativo.

3. Le due figure dei tutor condividono i seguenti compiti:
    a)  predisposizione  del  percorso  formativo  personalizzato,  anche  con  riguardo  alla  disciplina
    della sicurezza e salute nei  luoghi di  lavoro. In particolare, il docente tutor  interno dovrà
    collaborare col tutor formativo esterno al fine dell’individuazione delle attività richieste dal
    progetto formativo e delle misure di prevenzione necessarie alla tutela dello studente;

    b)  controllo della frequenza e dell’attuazione del percorso formativo personalizzato;

    c)  raccordo tra le esperienze formative in aula e quella in contesto lavorativo;

    d)  elaborazione  di un  report  sull’esperienza  svolta e  sulle acquisizioni di ciascun allievo, che
    concorre  alla  valutazione  e  alla  certificazione  delle  competenze  da  parte  del  Consiglio  di
    classe;

    e)  verifica del rispetto da parte dello studente degli obblighi propri di ciascun lavoratore di cui
    all’art. 20 D. Lgs. 81/2008. In particolare la violazione da parte dello studente degli obblighi
    richiamati dalla norma citata e dal percorso formativo saranno segnalati dal tutor formativo
    esterno al docente tutor interno affinché quest’ultimo possa attivare le azioni necessarie.

        </div>Art 5
        <div id="text-9">
1. Durante lo svolgimento del percorso in alternanza scuola lavoro il/i beneficiario/i del percorso è
    tenuto/sono tenuti a:
        a)  svolgere le attività previste dal percorso formativo personalizzato;

        b)  rispettare le norme in materia di igiene, sicurezza e salute sui luoghi di lavoro, nonché tutte
        le disposizioni, istruzioni, prescrizioni, regolamenti interni, previsti a tale scopo;

        c)  mantenere la necessaria riservatezza per quanto attiene ai dati, informazioni o conoscenze
        in  merito  a  processi  produttivi  e  prodotti,  acquisiti  durante  lo  svolgimento  dell’attività
        formativa in contesto lavorativo;

        d)  seguire  le  indicazioni  dei  tutor  e  fare  riferimento  ad  essi  per  qualsiasi  esigenza  di  tipo
        organizzativo o altre evenienze;

        e)  rispettare gli obblighi di cui al D.Lgs. 81/2008, art. 20.
        </div>Art.6
        <div id="text-10">
1. L’istituzione scolastica assicura il/i beneficiario/i del percorso in alternanza scuola lavoro contro
    gli  infortuni  sul  lavoro  presso  l’INAIL,  nonché  per  la  responsabilità  civile  presso  compagnie
    assicurative  operanti  nel  settore.  In  caso  di  incidente  durante  lo  svolgimento  del  percorso  il
    soggetto ospitante si impegna a segnalare l’evento, entro i tempi previsti dalla normativa vigente,
    agli  istituti  assicurativi  (facendo  riferimento  al  numero  della  polizza  sottoscritta  dal  soggetto
    promotore) e, contestualmente, al soggetto promotore.

2. Ai fini dell’applicazione dell’articolo 18 del D. Lgs. 81/2008 il soggetto promotore si fa carico dei
    seguenti obblighi:
    * tener conto delle capacità e delle condizioni della struttura ospitante, in rapporto alla salute
    e sicurezza degli studenti impegnati nelle attività di alternanza;

    * informare / formare lo studente in materia di norme relative a igiene, sicurezza e salute sui
    luoghi  di  lavoro,  con  particolare  riguardo  agli  obblighi  dello  studente  ex  art.  20  D.  Lgs.
    81/2008;

    * designare  un  tutor  interno  che  sia  competente  e  adeguatamente  formato  in  materia  di
    sicurezza e salute nei luoghi di lavoro o che si avvalga di professionalità adeguate in materia
    (es. RSPP);

3. Il soggetto promotore dichiara:
    * che i beneficiari hanno ricevuto la Formazione prevista dal D. Lgs 81/2008 (Formazione Base e Rischi Specifici)

    *  di aver attivato le seguenti coperture assicurative:

    * Compagnia Assicurativa dell’I.S.S. “Piero Gobetti”: WIENER STÄDTISCHE Versicherung AG – Vienna Insurance Group Ag. AMBIENTE SCUOLA – servizi assicurativi per la scuola -Via Petrella, 6 - 20124 MILANO
    (Polizza Responsabilità civile e infortuni posizione n. IW/2018/00029)

    * Infortuni sul lavoro INAIL posizione Gestione Conto Stato.
        </div>Art 7
        <div id="text-11">
1. Il soggetto ospitante si impegna a:
    a)  garantire al beneficiario/ai beneficiari del percorso, per il tramite del tutor della struttura
    ospitante,  l’assistenza  e  la  formazione necessarie  al  buon  esito  dell’attività  di  alternanza,
    nonché la dichiarazione delle competenze acquisite nel contesto di lavoro;
    b)  rispettare le norme antinfortunistiche e di igiene sul lavoro;
    c)  consentire  al  tutor  del  soggetto  promotore  di  contattare  il  beneficiario/i  beneficiari  del
    percorso e il tutor della struttura ospitante per verificare l’andamento della formazione in
    contesto lavorativo, per coordinare l’intero percorso formativo e per la stesura della relazione
    finale;
    d)  informare il soggetto promotore di qualsiasi incidente accada al beneficiario/ai beneficiari;
    e)  individuare il tutor esterno in un soggetto che sia competente e adeguatamente formato in
    materia di sicurezza e salute nei luoghi di lavoro o che si avvalga di professionalità adeguate
    in materia (es. RSPP).
    f)  fornire un adeguato addestramento specifico relativamente alle condizioni di impiego delle
    eventuali attrezzature e delle situazioni anormali prevedibili (art,37. C.4, D.Lgs. 81/08)
        </div>Art 8
        <div id="text-12">
1. La  presente  convenzione  decorre  dalla  data  sotto  indicata  e  dura  fino  all’espletamento
    dell’esperienza definita da ciascun percorso formativo personalizzato presso il soggetto ospitante.

2. È in ogni caso riconosciuta facoltà al soggetto ospitante e al soggetto promotore di risolvere la
    presente convenzione in caso di violazione degli obblighi in materia di salute e sicurezza nei luoghi
    di lavoro o del piano formativo personalizzato.
        </div>Art 9
        <div id="text-13">
Tutti i dati personali di cui il soggetto ospitante verrà in possesso nel corso dello svolgimento delle
attività previste dalla presente convenzione verranno trattati nel rispetto del D.Lgs. 196/03 “Codice
in materia di protezione dei dati personali”.
        </div>
        <table id="footer-convenzione">
                <thead>
                    <th>Per l’Istituto P. Gobetti </th>
                    <th>Per l’azienda / Ente </th>
                </thead>
                <tr>
                    <td>
Dirigente Scolastico

Dott. Fausto Fiorani



______________________________________
                    </td>
                    <td>
Legale Rappresentante

<?php echo $datiAzienda[0]["legale_rappresentante"]; ?>




______________________________________
                    </td>
                </tr>



        </table>
</body>
</html>
