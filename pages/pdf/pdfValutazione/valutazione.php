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
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>valutazione</title>
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
        <thead>
            <th>
                   PERCORSO PER LE COMPETENZE TRASVERSALI E PER L'ORIENTAMENTO
                   
            </th>
            <th>
                A.S.<?php $date = date("Y"); echo $date; ?>/<?php echo $date+1;?>

Indirizzo: <?php  echo $datiStudente[0]["indirizzo"];?>
             </th>
        </thead>            
    </table>

    <table id="table-3">
        <thead>
            <th colspan="2">SCHEDA VALUTAZIONE STUDENTE</th>
        </thead>
        <tr>
            <td>Studente: <?php echo $datiStudente[0]["cognome"] . " " . $datiStudente[0]["nome"];?> cl. <?php echo $datiStudente[0]["classe"]; ?> sez. <?php echo $datiStudente[0]["sezione"]; ?></td>
            <td>
            Ente/Azienda

            UFFICIO/SERVIZIO _______________________________

            RESPONSABILE    _________________________________

            QUALIFICA       _________________________________
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Alternanza Scuola-Lavoro: <?php echo $dateStart; ?> - <?php echo $dateEnd; ?>- n° settimane _________

                DENOMINAZIONE DEL PROGETTO SVOLTO DALLO STUDENTE:

                RUOLO/MANSIONE DELLO STUDENTE __________________________
            </td>
        </tr>
    </table>
    RELAZIONE SINTETICA GUIDATA SULL'ATTIVITA' DI ASL
    
        <table id="table-4">
                <tr>
                <td>Principali attività svolte dallo studente nel periodo:</td>
            </tr>
            <tr>
                <td>
                        _______________________________________________________________________________

                </td>
            </tr>
            <tr>
                <td>
                        _______________________________________________________________________________
                </td>
                
        
            </tr>
            <tr>
                <td>
                        _______________________________________________________________________________
                </td>
                
        
            </tr>
            <tr>
                <td>
                        _______________________________________________________________________________
                </td>
            
            </tr>
        </table>
        <table id="table-5">
            <tr>
                <td>Il giudizio complessivo sull'organizzazione del progetto Alternzanza Scuola Lavoro è</td>
            </tr>
            <tr>
                    <td>
                            _______________________________________________________________________________
                    </td>
                
                </tr>
                <tr>
                        <td>
                                _______________________________________________________________________________
                        </td>
                    
                    </tr>
        </table>
        <table id="table-6">
                <tr>
                    <td>Il livello di collaborazione del tutor scolastico nell'attività di Alternanza Scuola Lavoro è</td>
                </tr>
                <tr>
                        <td>
                                _______________________________________________________________________________
                        </td>
                    
                    </tr>
                    <tr>
                            <td>
                                    _______________________________________________________________________________
                            </td>
                        
                        </tr>
            </table>
            <table id="table-6">
                    <tr>
                        <td>Il livello di collaborazione del tutor scolastico nell'attività di Alternanza Scuola Lavoro è</td>
                    </tr>
                    <tr>
                            <td>
                                    _______________________________________________________________________________
                            </td>
                        
                        </tr>
                     
            </table>
            <table id="table-7">
                    <tr>
                        <td>L'azienda e/o Ente sarebbe disponibile a ripetere l'esperienza nel corso del prossimo A.S? ___________</td>
                    </tr>
                    <tr>
                            <td>
                                 SI    NO   Perchè?  
                                </td>  
                        </tr>
                <tr>
                        <td>
                                _______________________________________________________________________________
                        </td>
                    
                    </tr>
                    <tr>
                            <td>
                                    _______________________________________________________________________________
                            </td>
                        
                        </tr>
                        <tr>
                                <td>
                                        _______________________________________________________________________________
                                </td>
                            
                            </tr>
                     
            </table>

            <table id="table-9">
                <thead>
                <th>Studente:</th>
<th><?php echo $datiStudente[0]["cognome"]; ?></th>
<th><?php echo $datiStudente[0]["nome"]; ?></th>
<th></th>
<th>Classe: <?php echo $datiStudente[0]["classe"]; ?></th>
<th>sez.<?php echo $datiStudente[0]["sezione"]; ?></th>
                </thead>
               
            </table>
            RUBRICA DELLE COMPETENZE – PRIMA PARTE GENERALE
            Livelli: 5=Avanzato 4=Intermedio 3=Base, 2=Parziale, 1=Minimo, (0=Nullo, inserire eventuale commento)
            <table id="table-10">
                <thead>
                    <th colspan="2">
                        Comportamenti
                    </th>
                </thead>
                <tr>
                    <td>
                            COLLABORAZIONE
                    </td>
                    <td>
                            LIVELLO
                    </td> 
                    <td>
                            EVENTUALE COMMENTO
                    </td>
                </tr>
                <tr>
                    <td>
                        E' disponibile a lavorare con i colleghi. | Offre spontaneamente il proprio aiuto
                    </td>
                    <td>
                        5 4 3 2 1 0
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                        <td>
                                RISPETTO DELLE REGOLE GENERALI DELL'AMBIENTE DI LAVORO
                        </td>
                        <td>
                                LIVELLO
                        </td> 
                    <td></td>
                    </tr>
                    <tr>
                        <td>
                                Rispetta le regole generali dell’ambiente di lavoro, i colleghi e i formatori   
                        </td>
                        <td>
                            5 4 3 2 1 0
                        </td>
                        <td>
    
                            </td>
                    </tr>
                <tr>
                        <td>
                        OSSERVANZA DELLA NORMATIVA IN MATERIA DI SICUREZZA                       </td>
                        <td>
                                LIVELLO
                        </td> 
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                                Osserva scrupolosamente la normativa vigente in materia di Sicurezza sui luoghi di lavoro

                        </td>
                        <td>
                            5 4 3 2 1 0
                        </td>
                        <td>
    
                            </td>
                    </tr>
                    <tr>
                            <td>
                                   METODO DI LAVORO E ORDINE                            </td>
                            </td> 
                            <td>
                                LIVELLO
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>
                                    Organizza in modo razionale il proprio lavoro
Si prende cura degli strumenti di lavoro a lui affidati    
                            </td>
                            <td>
                                5 4 3 2 1 0
                            </td>
                            <td>
    
                                </td>
                        </tr>
                        <tr>
                            <td>
                                PUNTEGGIO COMPORTAMENTI
                            </td>
                            <td>______/20</td>
                        </tr>
            </table>
            <table id="table-11">
                    <thead>
                        <th colspan="2">
                                Competenze chiave di Cittadinanza
                        </th>
                    </thead>
                    <tr>
                        <td>
                               SPIRITO DI INIZIATIVA E DI IMPRENDITORIALITA'
                        </td>
                        <td>
                                LIVELLO
                        </td> 
                        <td>
                                EVENTUALE COMMENTO
                        </td>
                    </tr>
                    <tr>
                        <td>
                                Agisce in prima persona prendendo l’iniziativa per migliorare le prassi lavorative                        </td>
                        <td>
                            5 4 3 2 1 0
                        </td>
                        <td>
    
                            </td>
                    </tr>
                    <tr>
                            <td>
                                    E’ interessato all’attività in cui è inserito al fine di cogliere le opportunità lavorative disponibili                            <td>
                                5 4 3 2 1 0
                            </td>
                            <td>
        
                                </td> 
                    </tr>
                       
                    </tr>
                    <tr>
                            <td>
                                   IMPARARE AD IMPARARE                           </td>
                            <td>
                                    LIVELLO
                            </td> 
                        <td></td>
                        </tr>
                        <tr>
                            <td>
Riesamina il lavoro (processo) svolto insieme agli esperti al fine di imparare.
Capisce di quali ulteriori conoscenze e competenze ha bisogno per portare avanti il compito
                         </td>
                            <td>
                                5 4 3 2 1 0
                            </td>
                            <td>
    
                                </td>
                        </tr>
                    <tr>
                        <td>Sa documentarsi e svolgere ricerche per migliorare le proprie competenze lavorative</td>
                        <td>
                                5 4 3 2 1 0
                            </td>
                            <td>
    
                                </td>
                    </tr>
                
                    <tr>
                            <td>
                                COMUNICARE
                            </td> 
                            <td>
                                    LIVELLO
                            </td> 
                        <td></td>
                        </tr>
                    <tr>
                            <td>
                                    Utilizza registri comunicativi adeguati ai diversi contesti anche in lingua straniera (formale/informale; superiore/collega)                 
                            </td> 
                            <td>
                                    5 4 3 2 1 0
                                </td>
                                <td></td>
                        </tr>
                        <tr>
                                <td>
                                        Chiede spiegazioni in caso di difficoltà e/o necessità mostrando un atteggiamento costruttivo                                </td> 
                                <td>
                                        5 4 3 2 1 0
                                    </td>
                                    <td></td>
                            </tr>
                       
                            <tr>
                                <td>
                                    PUNTEGGIO COMPETENZE DI CITTADINANZA
                                </td>
                                <td>______/30</td>
                                <td></td>
                            </tr>
                </table>

                <table id="table-12">
                    <tr>
                        <td>Eventuali suggerimenti e/o osservazioni sull’Alternanza Scuola Lavoro</td>
                        <td>
___________________________________________________________________________
___________________________________________________________________________
___________________________________________________________________________
___________________________________________________________________________
___________________________________________________________________________</td>
                    </tr>
                </table>

                <table id="table-13">
                    <thead>
                        <th>TOTALE PUNTEGGIO RUBRICA DELLE COMPETENZE – PARTE GENERALE: ________/50</th>
                    </thead>
                </table>
                <table id="table-14">
                    <thead>
                        <th>Luogo e Data</th>
                        <th>Timbro dell'Azienda</th>
                        <th>Firma del Responsabile</th>

                    </thead>
                 
                </table>

</body>
</html>