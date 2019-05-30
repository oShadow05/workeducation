<?php
ob_start();
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
        echo "<h1>Non hai l'autorizzazione per accedere a questa pagina.</h1>";
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
    <html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="WORKER EDUCATION - DATABASE">
        <meta name="author" content="Alex Soglia">

        <title>WORKER EDUCATION - DATABASE</title>

        <link rel="shortcut icon" href="../images/imageshome/gobettiIcon.ico" type="image/x-icon">

        <!-- Bootstrap core CSS-->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Page level plugin CSS-->
        <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin.css" rel="stylesheet">

    </head>

    <body id="page-top">

        <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
            <div class="navbar-brand mr-1">
                <a class="navbar-brand" href="http://www.istitutogobetti.it/" target="_blank" rel="noopener noreferrer"><img class="sm-image-size" src="../images/imageshome/gobettiLogo-darkEffect.jpg" class="img-fluid" alt="Logo Gobetti"></a>
                <a class="navbar-brand sm-size-pos" href="#">WORKER EDUCATION DATABASE</a>
            </div>

            <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Navbar Search -->

            <!-- Navbar -->
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav ml-auto sm-display-none">
                    <li class="nav-item capitalize">
                        <a class="nav-link" href="#">ciao, <?php echo $_SESSION["username"]?> </a>
                    </li>
                    <li class="nav-item dropdown no-arrow">
                        <div class="nav-link dropdown-toggle" id="show-user" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle fa-fw"></i>
                        </div>
                        <div class="dropdown-menu dropdown-menu-right" id="userDropdown" aria-labelledby="userDropdown">
                            <div class="dropdown-divider"></div>
                            <!-- DA MODIFICARE SMALL DEVICES -->
                            <form action="" method="post">
                            <button class="dropdown-item" id="show-logout" name="logout">Logout</button>
                                <?php
                                if(isset($_POST["logout"]))
                                {
                                    session_destroy();
                                    $conn->quit();
                                    header("location:/dashboard/workereducation/index.html");
                                }

                                ?>
                            </form>
                            <div class="dropdown-item">
                                <span class="text-primary " id="close-dropdown-user-option">Mostra meno</span>
                            </div>
                        </div>
                    </li>
                </ul>

        </nav>

        <div id="wrapper">

            <!-- Sidebar -->
            <ul class="sidebar navbar-nav">
                <div id="url" class="item-container">
                    <li class="nav-item active active-link">
                        <a class="nav-link " href="#dashboard">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#inserisci">
                            <i class="fa fa-plus"></i>
                            <span>Inserisci</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#elimina">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                            <span>Elimina</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#modifica">
                            <i class="far fa-edit"></i>
                            <span>Modifica</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link border-stage" href="#stage">
                        <i class="far fa-handshake"></i>
                         <span>Stage</span>
                        </a>
                    </li>
                </div>
                <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="pagesDropdown-1" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-fw fa-table"></i>
                            <span>Tabelle</span>
                        </a>
                        <div class="dropdown-menu " aria-labelledby="pagesDropdown-1">
                            <h6 class="dropdown-header">LISTA TABELLE:</h6>
                            <a class="dropdown-item" id="sdt" href="#studenti">Studenti</a>
                            <a class="dropdown-item" id="znd" href="#aziende">Aziende</a>
                            <a class="dropdown-item" id="ttr" href="#docenti">Docenti</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item " role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-fw fa-table"></i>
                                <span class="text-primary close-dropdown">Mostra meno</span>
                            </a>
                        </div>
                    </li>
            </ul>

            <div id="content-wrapper">
                <!-- New navbar for small devices -->

                <div class="container-fluid">
                    <div class="navbar navbar-expand navbar-dark bg-dark sm-margin-bottom sm-style lg-display-none">
                        <ul class="navbar-nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="#"> <?php echo $_SESSION["username"] ?>  </a>
                            </li>
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user-circle fa-fw"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" id="userDropdown-small" aria-labelledby="userDropdown">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"  data-toggle="modal" data-target="#logoutModal">Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <!-- Breadcrumbs-->
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="#">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active" id="page-name">Overview</li>
                    </ol>

                    <!-- DataTables -->


                    <div class="card mb-3 ds-tabs" id="stage">
                        <div class="card-header">
                            <i class="fas fa-table"></i> Stage</div>
                        <div class="card-body" >
                         <div class="table-responsive">
                            <table  class="table table-bordered" id="dataTableStage" width="100%" cellspacing="0">
                              <thead>
                                <tr class="capitalize">
                                  <th>Id Protocollo</th>
                                  <th>inizio stage</th>
                                  <th>fine Stage</th>
                                  <th>matricola studente</th>
                                  <th>nome Studente</th>
                                  <th>Cognome Studente</th>
                                  <th>Id Classe</th>
                                  <th>Classe</th>
                                  <th>Tutor scolastico</th>
                                  <th>Tutor aziendale</th>

                                  <th class='company-space'>Azienda</th>
                                  <th>Convenzione</th>
                                  <th>Patto formativo</th>
                                  <th>Registro</th>
                                  <th>Valutazione</th>
                                </tr>
                              </thead>
                              <tfoot>
                                <tr class="capitalize">
                                  <th>Id Protocollo</th>
                                  <th>inizio stage</th>
                                  <th>fine Stage</th>
                                  <th>matricola studente</th>
                                  <th>nome Studente</th>
                                  <th>Cognome Studente</th>
                                  <th>Id Classe</th>
                                  <th>Classe</th>
                                  <th>Tutor scolastico</th>
                                  <th>Tutor aziendale</th>

                                  <th>Azienda</th>
                                  <th>Convenzione</th>
                                  <th>Patto formativo</th>
                                  <th>Registro</th>
                                  <th>Valutazione</th>
                                </tr>
                              </tfoot>
                              <tbody>
                                  <?php
                                    $select = $query->select("stage");
                                  if($select!=NULL)
                                  {
                                    $i=0;
                                    foreach($select as $row)
                                    {

                                      echo "<tr>";
                                      echo "<td id='protClasse$i'>" . $row["Id_Classe"]*100 ."</td>";
                                      {
                                        $date = new DateTime($row["Data_inizio"]);
                                        echo "<td id='date-start$i'>" . $date->format("d/m/Y") ."</td>";
                                      }
                                      {
                                        $date = new DateTime($row["Data_fine"]);
                                        echo "<td id='date-end$i'>" . $date->format("d/m/Y") ."</td>";
                                      }
                                      echo "<td id='mtr$i'>" . $row["Matricola"] ."</td>";
                                      echo "<td>" . $row["Nome"] ."</td>";
                                      echo "<td>" . $row["Cognome"] ."</td>";
                                      echo "<td id='cls$i'>" . $row["Id_Classe"] ."</td>";

                                      echo "<td>" . $row["Classe"] .  $row["Sezione"] . "</td>";
                                      echo "<td id='dct$i'>" . $row["Id_Docente"] . "</td>";
                                      echo "<td id='dpn$i'>" . $row["Id_Dipendente"] . "</td>";


                                      echo "
                                      <td id='company-field$i'>";
/*                                      Vecchio modo: scelta azienda manualmente
                                        $options = $query->getId("aziende");
                                          if($select[$i]["Azienda"]=="" || strtolower($select[$i]["Azienda"])==strtolower("NULL"))
                                          {
                                            echo "<div id='removed$i'>";
                                            echo "<select id='company-val-znd$i' class='browser-default custom-select bg-info  text-white'>";
                                            echo "<option disabled selected>Seleziona</option>";
                                            foreach ($options as $option)
                                            {
                                              echo "<option>" . $option['Ragione_Sociale'] . "</option>";

                                            }
                                            echo "</select>";
                                            echo "<div id='val-azienda'>";
                                            echo "<div id='$i' class='btn submit btn-outline-info btn-rounded btn-block waves-effect z-depth-0'><span id='show-loading$i'>OK</span></div>";
                                            echo "</div>";
                                            echo "</div>";
                                          }
                                          else {

                                          }*/
                                          echo "<div id='val-azienda'>";
                                          echo $select[$i]["Azienda"];
                                          echo "</div>";
                                      echo "</td>";
                                      echo "<td><i class='fas fa-file'></i><div id='conv$i' class='cursor text-primary'>Scarica</div></td>";
                                      echo "<td><i class='fas fa-file'></i><div id='patto$i' class='cursor text-primary'>Scarica</div></td>";
                                      echo "<td><i class='fas fa-file'></i><div id='registro$i' class='cursor text-primary'>Scarica</div></td>";
                                      echo "<td><i class='fas fa-file'></i><div id='valutazione$i' class='cursor text-primary'>Scarica</div></td>";

                                      echo "</tr>";

                                      $i++;

                                    }


                                  }

                                  ?>



                              </tbody>
                            </table>

                         </div>
                        </div>

                        <!-- MODIFICARE CON JAVASCRIPT  -->
                        <div class="card-footer small text-muted" id="last-update-stage"></div>
                    </div>
                    <div id="dashboard">

                                <div class="card mb-3">
                                    <div class="card-header" id="show-message-ajax">
                                        <i class="fas fa-table" id="studenti"></i> Tabella Studenti</div>
                                    <div class="card-body" id="studenti-data"></div>
                                    <div class="card-footer small text-muted" id="last-update"></div>
                                </div>
                                <div class="card mb-3">
                                <div class="card-header" id="show-message-ajax-docenti">
                                    <i class="fas fa-table" id="docenti"></i> Tabella Docenti</div>
                                <div class="card-body" id="docenti-data">
                                </div>
                                <div class="card-footer small text-muted" id="last-update-docenti"></div>
                              </div>

                                <div class="card mb-3">
                                <div class="card-header" id="show-message-ajax-aziende">
                                    <i class="fas fa-table" id="aziende"></i> Tabella Aziende</div>
                                <div class="card-body" id="aziende-data">
                                </div>
                                <div class="card-footer small text-muted" id="last-update-aziende"></div>
                              </div>
                      </div>
                    </div>
                         <!-- MODIFICARE CON JAVASCRIPT  -->

                   


                   


                    <!-- INSERT PAGE -->
                    <div class="card ds-tabs" id="inserisci">

                        <h5 class="card-header text-center py-4">
                          <strong><i>Inserimento Dati:</i></strong>
                        </h5>

                        <div class="card-body px-lg-5 pt-0">

                            <form class="md-form text-center container">

                                <div class="btn insertButtonStudente btn-text-color pulse" id="insertStudente" >Inserisci studente</div>
                                <div class="btn insertButtonProfessore btn-text-color pulse" id="InsertProfessore">Inserisci professore</div>
                                <div class="btn insertButtonAzienda btn-text-color pulse" id="InsertAzienda">Inserisci azienda</div>
                                <div class="btn insertButtonFiliale btn-text-color pulse" id="InsertFiliale">Inserisci filiale</div>
                                <div class="btn insertButtonDipendente btn-text-color pulse" id="InsertDipendente">Inserisci dipendente</div>
                                <div class="btn insertButtonPeriodiStage btn-text-color pulse" id="InsertPeriodoStage">Inserisci periodo stage</div>


                                <div id='message'></div>
                                <div id='message-err'></div>


                                <div class="text-center">
                                    <a type="button" class="btn-floating btn-git btn-sm" href="https://github.com/oShadow05/workeducation" target="_blank">
                                        <i class="fab fa-github"></i>
                                    </a>
                                </div>

                            </form>

                            <div id="insert-studente">

                            </div>

                            <div id="insert-docente">
                            </div>

                            <div id="insert-azienda">
                            </div>

                            <div id="insert-filiale">
                            </div>

                            <div id="insert-dipendente">
                            </div>

                             <div id="insert-stage">
                            </div>

                        </div>

                        <!-- DELETE PAGE -->
                        </div>
                        <div class="card ds-tabs" id="elimina">
                            <h5 class="card-header text-center py-4">
                            <strong><i>Scegli un'opzione</i></strong>
                            </h5>
                            <div class="card-body px-lg-5 pt-0">

                                <form class="md-form container text-center">

                                    <div class="btn  deleteButtonStudente btn-text-color pulse" id="DeleteStudente">Elimina studente</div>
                                    <div class="btn  deleteButtonProfessore btn-text-color pulse" id="DeleteProfessore">Elimina professore</div>
                                    <div class="btn  deleteButtonAzienda btn-text-color pulse" id="DeleteAzienda">Elimina azienda</div>
                                    <div class="btn  deleteButtonFiliale btn-text-color pulse" id="DeleteFiliale">Elimina filiale</div>


                                    <div class="text-center">
                                        <a type="button" class="btn-floating btn-git btn-sm" href="https://github.com/oShadow05/workeducation" target="_blank">
                                            <i class="fab fa-github"></i>
                                        </a>
                                    </div>

                                </form>
                                <div id="delete-studente"></div>

                                <div id="delete-professore"></div>

                                <div id="delete-azienda"></div>

                                <div id="delete-filiale"></div>


                                <div id="display-success"></div>

                                <div id="display-error"></div>
                            </div>

                        </div>

                         <!-- UPDATE PAGE -->
                    <div class="card ds-tabs" id="modifica">
                        <h5 class="card-header text-center py-4">
                          <strong><i>Scegli un'opzione</i></strong>
                       </h5>
                        <div class="card-body px-lg-5 pt-0">

                            <form class="md-form container text-center">

                                <div class="btn  updateButtonStudente btn-text-color pulse" id="UpdateStudente">Modifica dati studente</div>
                                <div class="btn  updateButtonProfessore btn-text-color pulse" id="UpdateProfessore">Modifica dati professore</div>
                                <div class="btn  updateButtonAzienda btn-text-color pulse" id="UpdateAzienda">Modifica dati azienda</div>
                                <div class="btn  updateButtonFiliale btn-text-color pulse" id="UpdateFiliale">Modifica dati filiale</div>
                                <div class="btn  updateButtonDipendente btn-text-color pulse" id="UpdateDipendente">Modifica dati dipendente</div>



                                <div class="text-center">
                                    <a type="button" class="btn-floating btn-git btn-sm" href="https://github.com/oShadow05/workeducation" target="_blank">
                                        <i class="fab fa-github"></i>
                                    </a>
                                </div>

                            </form>
                            <div id="update-studente"></div>
                            <div id="update-professore"></div>
                            <div id="update-azienda"></div>
                            <div id="update-filiale"></div>
                            <div id="update-filiale-values"></div>
                            <div id="update-dipendente"></div>

                            <div id="update-dipendente-values"></div>



                        </div>

                    </div>



                    </div>






                    <!-- /.container-fluid -->

                    <!-- Sticky Footer -->
                    </div>
                    <footer class="sticky-footer">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">

                                Copyright © Istituto Gobetti <span id="copyright-year"></span>
                            </div>
                        </div>
                    </footer>

                </div>
                <!-- /.content-wrapper -->

            </div>

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>


            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Page level plugin JavaScript-->
            <script src="vendor/datatables/jquery.dataTables.js"></script>
            <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin.min.js"></script>


            <!-- scripts for this page-->
            <script src="js/sendFormsValues.js"></script>

            <script src="js/jspdf.js"></script>
            <script src="js/jspdf-autotable.js"></script>


            <?php

    ?>
    </body>

    </html>
