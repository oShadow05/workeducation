<?php
    ob_start();
    session_start();
    require $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/script/php/credentials.php";

    require $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/script/php/requestHandler/RequestDatabaseHandler.php";

    $livello = $_SESSION["livello"];
    if($livello==3)
    {
        $conn = new RequestDatabaseHandler($host, $type, $dbName, $userAz, $passwordLoginAzienda);

        $conn->request();
    }
    else
    {
        echo "<h1>Non hai l'autorizzazione per accedere a questa pagina</h1>";
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



            <!-- Navbar Search -->

            <!-- Navbar -->
            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav ml-auto sm-display-none">
                    <li class="nav-item capitalize">
                        <a class="nav-link" href="#">ciao, <?php echo $_SESSION["username"]?> </a>
                    </li>
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user-circle fa-fw"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="login.php" data-toggle="modal" data-target="#logoutModal">Logout</a>
                        </div>
                    </li>
                </ul>

        </nav>

        <div id="wrapper">




            <div id="content-wrapper">
                <!-- New navbar for small devices -->

                <div class="container-fluid">
                    <div class="navbar navbar-expand navbar-dark bg-dark sm-margin-bottom sm-style lg-display-none">
                        <ul class="navbar-nav">
                            <li class="nav-item ">
                                <a class="nav-link" href="#">Ciao, Alex </a>
                            </li>
                            <li class="nav-item dropdown no-arrow">
                                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-user-circle fa-fw"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
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


                    <div class="card mb-3" id="stage">
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
                                  <th>nome</th>
                                  <th>cognome</th>


                                  <th>Id Classe</th>
                                  <th>Classe</th>
                                  <th>Docente</th>



                                </tr>
                              </thead>
                              <tfoot>
                                <tr class="capitalize">
                                <th>Id Protocollo</th>
                                  <th>inizio stage</th>
                                  <th>fine Stage</th>
                                  <th>matricola studente</th>
                                  <th>nome</th>
                                  <th>cognome</th>


                                  <th>Id Classe</th>
                                  <th>Classe</th>
                                  <th>docente</th>



                                </tr>
                              </tfoot>
                              <tbody>


                              <?php
                                  // Query studente Stage


                                    $select = $query->selectForAzPage($_SESSION["username"]);

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
                                      echo "<td id='dct$i'>" .  $row["nomeDoc"] . " " . $row["cognomeDoc"] . "</td>";




                                      echo "</tr>";

                                      $i++;

                                    }


                                  }

                                  ?>


                              </tbody>
                            </table>

                         </div>
                        </div>

                        <div class="card-footer small text-muted" id="last-update"></div>
                    </div>
                    <div id="dashboard">



                    </div>


                    </div>


                   





                    <!-- /.container-fluid -->

                    <!-- Sticky Footer -->
                    </div>
                    <footer class="sticky-footer">
                        <div class="container my-auto">
                            <div class="copyright text-center my-auto">

                                Copyright © Istituto Gobetti  <span id="copyright-year"></span>
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

            <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="ModalLabel">Vuoi veramente uscire?</h4>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Seleziona "Logout" se sei pronto per chiudere questa sessione.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancella</button>
                            <form action="" method="post">
                            <button class="btn btn-primary" name="logout">Logout</button>
                            </form>
                            <?php
                                if(isset($_POST["logout"]))
                                {
                                    $_SESSION["username"] = null;
                                    $_SESSION["password"] = null;
                                    session_destroy();
                                    $conn->quit();
                                    header("location:/dashboard/workereducation-noBlogVersion-a/index.html");
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

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

    </body>

    </html>
