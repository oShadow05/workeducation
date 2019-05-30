<?php
    /*
        This file has the components for estabilish connection to
        the database.
        Contains methods_handler for the database.
    */

    class RequestDatabaseHandler extends PDO
    {
        // ATTRIBUTES:
            protected static $conn;
            private $hostIp;
            private $usernameRoot;
            private $passwordRoot;
            private $databaseType;
            private $databaseName;
            private $dataSourceName;

        // METHODS:
            public function __CONSTRUCT($ipHost, $typeDatabase, $nameDatabase, $rootUsername="", $rootPassword="")
            {
                $this->hostIp = $ipHost;
                $this->usernameRoot = $rootUsername;
                $this->passwordRoot = $rootPassword;
                $this->databaseType = $typeDatabase;
                $this->databaseName = $nameDatabase;
                $this->dataSourceName = $this->databaseType . ":host=" . $this->hostIp . ";dbname=" . $this->databaseName;
            }

        // Main request to create pdo object:
            public function request()
            {
                try
                {
                    self::$conn = new PDO($this->dataSourceName, $this->usernameRoot, $this->passwordRoot);
                    self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                }
                catch(PDOException $e)
                {
                    echo "Errore " . $e->getMessage();
                }
            }

        // Exit:
            public function quit()
            {
                self::$conn = NULL;
            }



    }

    class SendQuery extends RequestDatabaseHandler
    {
        // ATTRIBUTES:
            private $select;

            private $insert;

            private $update;

            private $delete;

            private $view;

            private $recordView;

        // METHODS:
            public function __CONSTRUCT()
            {
                $this->select = NULL;
                $this->insert = NULL;
                $this->update = NULL;
                $this->delete = NULL;
                $this->view   = NULL;
            }

        // METHODS FOR EXECUTE QUERY:


            public function login($userName, $pwd, $tableName)
            {
                try
                {

                  $this->select = self::$conn->prepare("SELECT * FROM $tableName WHERE Username = :user ");

                  $this->select->bindParam(":user", $userName);


                  $this->select->execute();

                  $result = $this->select->fetchAll(PDO::FETCH_ASSOC);

                  $count = $this->select->rowCount();

                  if($count==1 && password_verify($pwd, $result[0]["Pwd"]))
                  {

                    $livello = $result[0]["Livello"];
                    return ($livello);

                  }
                  else
                  {


                    return(false);

                  }

                }
                catch (PDOException $e)
                {


                  echo "<h1>Errore:</h1>" . $e->getMessage();
                  echo "<h2>Clicca <a href=" . $SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

                }

            }


        // Check: id already been used:
          public function check($tableName, $fieldName, $id)
          {
            try
            {

              $this->select = self::$conn->prepare("SELECT $fieldName FROM $tableName WHERE $fieldName = :d");
              $this->select->bindParam(":d", $id);
              $this->select->execute();
              $count = $this->select->rowCount();

              if($count==1)
              {
                  // LIVELLO DA INSERIRE

                return(true);

              }
              else
              {

                return(false);

              }

            }
            catch (PDOException $e)
            {


              echo "<h1>Errore:</h1>" . $e->getMessage();
              echo "<h2>Clicca <a href=" . $SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

            }
          }

             // Check: id already been used:
             public function checkClassAlreadyUsed($class, $sezione)
             {
               try
               {
                    $prova = addslashes($sezione);
                 $this->select = self::$conn->prepare("SELECT classi.id_classe as id FROM classi WHERE classi.classe = $class AND classi.sezione = :s");
                 $this->select->bindParam(":s", $sezione);
                 $this->select->execute();
                 $id = $this->select->fetchAll(PDO::FETCH_ASSOC);
                 $count = $this->select->rowCount();

                 if($count>=1)
                 {
                     // LIVELLO DA INSERIRE

                   return($id);

                 }
                 else
                 {

                   return(false);

                 }

               }
               catch (PDOException $e)
               {


                 echo "<h1>Errore:</h1>" . $e->getMessage();
                 echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

               }
             }




        // Insert query:
            public function insert($tableName, $bind, $data)
            {
                try
                {
                    $this->insert = self::$conn->prepare("INSERT INTO $tableName VALUES($bind)");
                    $this->insert->execute($data);
                    return true;
                }
                catch (PDOException $e)
                {

                    echo "<h1>Errore $tableName:</h1>" . $e->getMessage();
                    echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";
                    return false;
                }

            }




        // Delete query:
            public function delete($tableName, $fieldName, $id)
            {
                try
                {
                    $this->delete = self::$conn->prepare("DELETE FROM $tableName WHERE $fieldName = :d");
                    $this->delete->bindParam(":d", $id);
                    $this->delete->execute();


                }
                catch (PDOException $e)
                {

                    echo "<h1>Errore $tableName:</h1>" . $e->getMessage();
                    echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";
                  }

            }

             // Update query:
             public function update($tableName, $fieldName, $inputValue, $idFieldName, $id)
             {
                 try
                 {
                     $this->update = self::$conn->prepare("UPDATE $tableName SET $fieldName = :val WHERE $idFieldName = :d");
                     $this->update->bindParam(":val", $inputValue);
                     $this->update->bindParam(":d", $id);

                     $this->update->execute();

                    return true;
                 }
                 catch (PDOException $e)
                 {

                     echo "<h1>Errore $tableName:</h1>" . $e->getMessage();
                     echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";
                     return false;
                 }

             }

             // Update query:
             public function updateStage($tableName, $fieldName, $inputValue, $idStudent, $idClass)
             {
                 try
                 {
                   $stringStudent = $tableName . ".matricola";
                   $stringClass = $tableName . ".Id_Classe";

                     $this->update = self::$conn->prepare("UPDATE $tableName SET $fieldName = :val WHERE stage.matricola = $idStudent AND
                                                           stage.Id_Classe = $idClass");

                     $this->update->bindParam(":val", $inputValue);

                     $this->update->execute();

                    return true;
                 }
                 catch (PDOException $e)
                 {

                     echo "<h1>Errore $tableName:</h1>" . $e->getMessage();
                     echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";
                     return false;
                 }

             }

        // Get fields name:
            public function getFieldsName($tableName)
            {
                try
                {

                    $this->select = self::$conn->prepare("DESCRIBE $tableName");
                    $this->select->execute();
                    $result =  $this->select->fetchAll(PDO::FETCH_COLUMN);
                    if(!$result)
                    {
                        die("Errore tabella non trovata");
                    }
                    else
                        return $result;

                }
                catch (PDOException $e)
                {


                echo "<h1>Errore $tableName:</h1>" . $e->getMessage();
                echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

                }

            }



        // Get id values for create dropdown menu:
           public function getId($tableName)
           {
             try
             {
                 $this->select = self::$conn->prepare("DESCRIBE $tableName");
                 $this->select->execute();

                 $arrayId = $this->select->fetchAll(PDO::FETCH_COLUMN);
                 $id = $arrayId[0];
                 $fistFieldVal = $arrayId[1];
                 $secondFieldVal = $arrayId[2];


                 $string = $tableName. "." . $id;

                 if($tableName=="classi")
                 {
                     $thirdFieldVal = $arrayId[3];

                     $this->select = self::$conn->prepare("SELECT $string, $fistFieldVal, $secondFieldVal, $thirdFieldVal FROM $tableName");
                     $this->select->execute();
                     $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);
                     if(!$result)
                     {
                         die("Errore tabella oppure la tabella è vuota");
                     }
                     else
                         return $result;


                 }
                 else
                 {

                    $this->select = self::$conn->prepare("SELECT $id, $fistFieldVal, $secondFieldVal FROM $tableName");

                    $this->select->execute();
                    $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);
                    if(!$result)
                    {
                        die("Errore tabella non trovata oppure la tabella è vuota");
                    }
                    else
                        return $result;
                 }


             }
             catch (PDOException $e)
             {


               echo "<h1>Errore:</h1>" . $e->getMessage();
               echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

             }
           }



           // Get id prof:
            public function getIdProf($tableName)
            {
                try
             {
                 $this->select = self::$conn->prepare("DESCRIBE $tableName");
                 $this->select->execute();

                 $arrayId = $this->select->fetchAll(PDO::FETCH_COLUMN);
                 $id = $arrayId[0];
                 $fistFieldVal = $arrayId[1];
                 $secondFieldVal = $arrayId[2];
                $this->select = self::$conn->prepare("SELECT $id, $fistFieldVal, $secondFieldVal FROM $tableName");

                $this->select->execute();
                $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);
                if(!$result)
                {
                    die("Errore tabella non trovata oppure la tabella è vuota");
                }
                else
                    return $result;



             }
             catch (PDOException $e)
             {


               echo "<h1>Errore:</h1>" . $e->getMessage();
               echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"]. "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

             }
            }

            public function selectEmployeeForStage($code)
            {
                try
                {

                    $this->select = self::$conn->prepare("SELECT dipendenti_azienda.id_dipendente FROM dipendenti_azienda WHERE dipendenti_azienda.id_dipendente = :c");
                    $this->select->bindParam(":c", $code);
                    $this->select->execute();
                    $result =  $this->select->fetchAll(PDO::FETCH_NUM);

                    $count = $this->select->rowCount();


                    if($count>=1)
                        return $result;

                }
                catch (PDOException $e)
                {


                    echo "<h1>Errore:</h1>" . $e->getMessage();
                    echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

                }

            }



            // Get id Dip:
             public function getIdDipendente()
             {
                 try
                {

                    $this->select = self::$conn->prepare("SELECT dipendenti_azienda.id_dipendente, filiali.nome, aziende.ragione_sociale
                                                          FROM dipendenti_azienda, filiali, aziende
                                                           WHERE aziende.id_azienda = filiali.id_azienda AND dipendenti_azienda.id_filiale = filiali.id_filiale");

                    $this->select->execute();
                    $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);
                    if(!$result)
                    {
                        die("Errore tabella non trovata oppure la tabella è vuota");
                    }
                    else
                        return $result;



                 }
                    catch (PDOException $e)
                    {


                        echo "<h1>Errore:</h1>" . $e->getMessage();
                        echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

                    }
             }

              // Get id filiali:
              public function getFilialiAz($codeAz)
              {
                  try
               {

                  $this->select = self::$conn->prepare("SELECT DISTINCT filiali.id_filiale, filiali.nome FROM filiali, aziende WHERE filiali.Id_Azienda = :cod");
                  $this->select->bindParam(":cod", $codeAz);
                  $this->select->execute();
                  $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);
                  if(!$result)
                  {
                      die("Errore tabella non trovata oppure la tabella è vuota");
                  }
                  else
                      return $result;



               }
               catch (PDOException $e)
               {


                 echo "<h1>Errore:</h1>" . $e->getMessage();
                echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

               }
              }

            // Get id for delete filiale:
            public function getIdDeleteFiliale()
            {
                try
                {

                   $this->select = self::$conn->prepare("SELECT filiali.id_filiale, filiali.nome, aziende.ragione_sociale FROM filiali, aziende WHERE filiali.Id_Azienda = aziende.id_azienda");
                   $this->select->execute();
                   $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);
                   if(!$result)
                   {
                       die("Errore tabella non trovata oppure la tabella è vuota");
                   }
                   else
                       return $result;



                }
                catch (PDOException $e)
                {


                  echo "<h1>Errore:</h1>" . $e->getMessage();
                  echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

                }
            }


           // Get id values for create dropdown menu:
            public function getIdStudent($tableName, $idClass)
            {
                $this->select = self::$conn->prepare("DESCRIBE $tableName");
                $this->select->execute();

                $arrayId = $this->select->fetchAll(PDO::FETCH_COLUMN);
                $id = $arrayId[0];
                $fistFieldVal = $arrayId[1];
                $secondFieldVal = $arrayId[2];


                $stringId = $tableName . "." . $id;
                $this->select = self::$conn->prepare("SELECT $stringId, $fistFieldVal, $secondFieldVal
                                                      FROM $tableName, studenti_classi, classi
                                                      WHERE studenti.Matricola = studenti_classi.Matricola
                                                            AND classi.Id_classe = studenti_classi.Id_classe
                                                            AND classi.Id_classe = $idClass");

                $this->select->execute();
                $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);
                if(!$result)
                {
                    die("Errore tabella non trovata");
                }
                else
                    return $result;


            }
        // Select Query:
            public function select($tableName)
            {
                try
                {

                    $this->select = self::$conn->prepare("SELECT * FROM $tableName");
                    $this->select->execute();
                    $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);

                    $count = $this->select->rowCount();


                    if($count>=1)
                      return $result;

                }
                catch (PDOException $e)
                {


                  echo "<h1>Errore:</h1>" . $e->getMessage();
                  echo "<h2>Clicca <a href=" . $SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

                }

            }

            // Select Query:
            public function selectStudenti()
            {
                try
                {

                    $this->select = self::$conn->prepare("SELECT studenti.*, classi.Classe, classi.Sezione, classi.Indirizzo as PercorsoStudi
                                                          FROM classi, studenti, studenti_classi
                                                          WHERE studenti_classi.Matricola = studenti.Matricola AND studenti_classi.Id_Classe = classi.Id_Classe");
                    $this->select->execute();
                    $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);

                    $count = $this->select->rowCount();


                    if($count>=1)
                      return $result;

                }
                catch (PDOException $e)
                {


                  echo "<h1>Errore:</h1>" . $e->getMessage();
                  echo "<h2>Clicca <a href=" . $SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

                }

            }

        // Select Query:
        public function selectDipendente()
        {
            try
            {

                $this->select = self::$conn->prepare("SELECT aziende.id_azienda, aziende.ragione_sociale, filiali.nome FROM aziende, filiali WHERE aziende.id_azienda = filiali.id_azienda ");
                $this->select->execute();
                $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);

                $count = $this->select->rowCount();


                if($count>=1)
                  return $result;

            }
            catch (PDOException $e)
            {


              echo "<h1>Errore:</h1>" . $e->getMessage();
              echo "<h2>Clicca <a href=" . $SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

            }

        }
        // Select Query: get student name and surname:
            public function selectStudentForStage($studentCode)
            {
                try
                {

                    $this->select = self::$conn->prepare("SELECT studenti.matricola, studenti.nome, studenti.cognome FROM studenti WHERE studenti.matricola = $studentCode");
                    $this->select->execute();
                    $result =  $this->select->fetchAll(PDO::FETCH_NUM);

                    $count = $this->select->rowCount();


                    if($count>=1)
                      return $result;

                }
                catch (PDOException $e)
                {


                  echo "<h1>Errore:</h1>" . $e->getMessage();
                  echo "<h2>Clicca <a href=" . $SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

                }

            }

        // Select Query: get prof id for stage:
            public function selectProfForStage($profCode)
            {
                try
                {

                    $this->select = self::$conn->prepare("SELECT docenti.Id_docente FROM docenti WHERE docenti.Id_docente = $profCode");
                    $this->select->execute();
                    $result =  $this->select->fetchAll(PDO::FETCH_NUM);

                    $count = $this->select->rowCount();


                    if($count>=1)
                      return $result;

                }
                catch (PDOException $e)
                {


                  echo "<h1>Errore:</h1>" . $e->getMessage();
                  echo "<h2>Clicca <a href=" . $SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

                }
            }

        // selectUsernameStudent:
        public function selectUsernameStudent($code)
        {
            try
            {

                $this->select = self::$conn->prepare("SELECT credenziali.username FROM studenti, credenziali WHERE credenziali.username = studenti.username
                                                        AND studenti.matricola = :cod");
                $this->select->bindParam(":cod", $code);
                $this->select->execute();
                $result =  $this->select->fetchAll(PDO::FETCH_NUM);

                $count = $this->select->rowCount();


                if($count>=1)
                  return $result;

            }
            catch (PDOException $e)
            {


              echo "<h1>Errore:</h1>" . $e->getMessage();
              echo "<h2>Clicca <a href=" . $SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

            }
        }

        public function selectUsernameProfessor($code)
        {
            try
            {

                $this->select = self::$conn->prepare("SELECT credenziali.username FROM docenti, credenziali WHERE credenziali.username = docenti.username
                                                      AND docenti.id_docente = :cod");
                $this->select->bindParam(":cod", $code);
                $this->select->execute();
                $result =  $this->select->fetchAll(PDO::FETCH_NUM);

                $count = $this->select->rowCount();


                if($count>=1)
                  return $result;

            }
            catch (PDOException $e)
            {


              echo "<h1>Errore:</h1>" . $e->getMessage();
              echo "<h2>Clicca <a href=" . $SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

            }
        }

        public function selectCodeProfessor($code)
        {
            try
            {

                $this->select = self::$conn->prepare("SELECT docenti.id_docente FROM docenti WHERE
                                                      AND docenti.id_docente = :cod");
                $this->select->bindParam(":cod", $code);
                $this->select->execute();
                $result =  $this->select->fetchAll(PDO::FETCH_NUM);

                $count = $this->select->rowCount();


                if($count>=1)
                  return $result;

            }
            catch (PDOException $e)
            {


              echo "<h1>Errore:</h1>" . $e->getMessage();
              echo "<h2>Clicca <a href=" . $SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

            }
        }

        public function selectUsernameDipendente($code)
        {
            try
            {

                $this->select = self::$conn->prepare("SELECT credenziali.username FROM dipendenti_azienda, credenziali WHERE credenziali.username = dipendenti_azienda.username");
                $this->select->execute();
                $result =  $this->select->fetchAll(PDO::FETCH_NUM);

                $count = $this->select->rowCount();


                if($count>=1)
                  return $result;

            }
            catch (PDOException $e)
            {


              echo "<h1>Errore:</h1>" . $e->getMessage();
              echo "<h2>Clicca <a href=" . $SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

            }
        }


        // Select Query: get student class
        public function selectClassForStage($classCode)
        {
            try
            {

                $this->select = self::$conn->prepare("SELECT classi.id_classe, classi.classe, classi.sezione FROM classi WHERE classi.id_classe = $classCode");
                $this->select->execute();
                $result =  $this->select->fetchAll(PDO::FETCH_NUM);

                $count = $this->select->rowCount();


                if($count>=1)
                  return $result;

            }
            catch (PDOException $e)
            {


              echo "<h1>Errore:</h1>" . $e->getMessage();
              echo "<h2>Clicca <a href=" . $SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

            }

        }

    // Select Query: user select:
        public function selectForUserPage($user)
        {
          try
          {
              $this->select = self::$conn->prepare("SELECT *
                                                    FROM stage
                                                    WHERE stage.UsernameStudente = :u
                                          ");
              $this->select->bindParam(":u", $user);
              $this->select->execute();
              $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);

              $count = $this->select->rowCount();


              if($count>=1)
                return $result;

          }
          catch (PDOException $e)
          {


            echo "<h1>Errore:</h1>" . $e->getMessage();
            echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

          }
        }

          // Select Query: company select:
          public function selectForAzPage($user)
          {
            try
            {
                $this->select = self::$conn->prepare("SELECT DISTINCT stage.azienda
                                                      FROM stage
                                                      WHERE stage.UsernameAzienda = :u");
                $this->select->bindParam(":u", $user);
                $this->select->execute();

                $id = $this->select->fetchAll(PDO::FETCH_ASSOC);
                $azienda = $id[0]["azienda"];
                $this->select = self::$conn->prepare("SELECT  *
                                                      FROM stage
                                                      WHERE stage.azienda = :az
                                            ");
               $this->select->bindParam(":az", $azienda);
                $this->select->execute();
                $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);

                $count = $this->select->rowCount();


                if($count>=1)
                  return $result;

            }
            catch (PDOException $e)
            {


              echo "<h1>Errore:</h1>" . $e->getMessage();
              echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

            }
          }

    // Select Query: get student by class for professors:
        public function selectForProfessor($userName)
        {
          try
          {

              $this->select = self::$conn->prepare("SELECT studenti.nome, studenti.cognome, classi.classe, credenziali.username
                                                    FROM studenti, credenziali, classi, studenti_classi, docenti
                                                    WHERE docenti.Username = $userName,
                                                    AND studenti.username = credenziali.username AND classi.id_classe = studenti_classi.id_classe
                                                    AND studenti.matricola = studenti_classi.matricola
                                          ");
              $this->select->execute();
              $result =  $this->select->fetchAll(PDO::FETCH_NUM);

              $count = $this->select->rowCount();


              if($count==1)
                return $result;

          }
          catch (PDOException $e)
          {


            echo "<h1>Errore:</h1>" . $e->getMessage();
            echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

          }
        }








        // Get column Meta
            public function columnMeta($tableName, $nFields)
            {
                $this->select = self::$conn->prepare("SELECT * FROM $tableName LIMIT $nFields");
                $this->select->execute();
                $nativeType = array();
                for($i=0; $i<$nFields; $i++)
                {
                    $meta = $this->select->getColumnMeta($i);
                    $nativeType[$i] = $meta["native_type"];
                }
                return($nativeType);
            }
        // Translate database metadata:
        public function translateNativeType($meta) {
            $trans = array(
                'VAR_STRING' => 'text',
                'STRING' => 'text',
                'BLOB' => 'number',
                'LONGLONG' => 'number',
                'LONG' => 'number',
                'SHORT' => 'number',
                'DATETIME' => 'datetime',
                'TINYINT' => 'number',
                'DATE' => 'date',
                'DOUBLE' => 'number',
                'TIMESTAMP' => 'timestamp',
                'TIME' => 'time',
                "TINY" => 'number'
            );
            return $trans[$meta];
        }

        // Create view
        public function createStage($idPrt)
        {
            $this->view = self::$conn->prepare("CREATE OR REPLACE TABLE $idPrt AS SELECT  classi.Id_Classe, periodi_stage.Data_inizio,
                  periodi_stage.Data_fine, studenti.Matricola, studenti.Username as UsernameStudente, dipendenti_azienda.username as UsernameAzienda,
                studenti.Nome, studenti.Cognome, classi.Classe, classi.Sezione, docenti.Id_Docente, docenti.nome as nomeDoc, docenti.cognome as cognomeDoc,
                  dipendenti_azienda.Id_Dipendente, aziende.Ragione_sociale as Azienda
                FROM studenti, periodi_stage, classi, studenti_classi, docenti, dipendenti_azienda, filiali, aziende
                WHERE periodi_stage.Matricola = studenti.Matricola
                AND studenti.Matricola = studenti_classi.Matricola
                AND classi.Id_Classe = studenti_classi.Id_Classe
                AND classi.Id_classe = periodi_stage.Id_classe
                AND docenti.Id_Docente = periodi_stage.Id_docente
                AND dipendenti_azienda.Id_Dipendente = periodi_stage.Id_Dipendente
                AND filiali.Id_Filiale = dipendenti_azienda.Id_Filiale
                AND filiali.Id_Azienda = aziende.Id_Azienda
                                                ");

            $this->view->execute();

            $this->view = self::$conn->prepare("SELECT * FROM $idPrt");
            $this->view->execute();



            $result = $this->view->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        }

// Methods for create pdf:
      // Methods for: 'Patto formativo' pdf
        public function getDatiStudente($matricola)
        {
          try
          {

              $this->select = self::$conn->prepare("SELECT studenti.nome, studenti.cognome, studenti.cf as codiceFiscale, classi.classe, classi.sezione,
                                                     classi.indirizzo, studenti_classi.anno_scolastico
                                                    FROM studenti, studenti_classi, classi
                                                    WHERE studenti.matricola = :code AND
                                                    studenti_classi.matricola = studenti.matricola AND
                                                    studenti_classi.id_classe = classi.id_classe");
              $this->select->bindParam(":code", $matricola);
              $this->select->execute();
              $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);

              $count = $this->select->rowCount();


              if($count>=1)
                return $result;

          }
          catch (PDOException $e)
          {


            echo "<h1>Errore:</h1>" . $e->getMessage();
            echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

          }
        }

        public function getDatiDocente($idDocente)
        {
          try
          {

              $this->select = self::$conn->prepare("SELECT docenti.cognome, docenti.nome, docenti.telefono
                                                    FROM docenti
                                                    WHERE docenti.id_docente = :code");
              $this->select->bindParam(":code", $idDocente);
              $this->select->execute();
              $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);

              $count = $this->select->rowCount();


              if($count>=1)
                return $result;

          }
          catch (PDOException $e)
          {


            echo "<h1>Errore:</h1>" . $e->getMessage();
            echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

          }
        }

        // The method also runs on convenzione.php:
        public function getDatiAzienda($idDipendente)
        {
          try
          {

              $this->select = self::$conn->prepare("SELECT dipendenti_azienda.cognome, dipendenti_azienda.nome, dipendenti_azienda.citta_nascita,
                                                           dipendenti_azienda.data_nascita, dipendenti_azienda.cf, aziende.provincia_sede_legale, aziende.p_iva, dipendenti_azienda.legale_rappresentante,
                                                           filiali.ora_ingresso_mattino as ora_in_ma, filiali.ora_uscita_mattino as ora_us_ma, filiali.ora_ingresso_pomeriggio as ora_in_po,
                                                           filiali.ora_uscita_pomeriggio as ora_us_po,
                                                           filiali.indirizzo, aziende.sede_legale, aziende.ragione_sociale
                                                    FROM dipendenti_azienda, aziende, filiali
                                                    WHERE dipendenti_azienda.id_filiale = filiali.id_filiale AND
                                                          dipendenti_azienda.id_dipendente = :idDipendente AND
                                                            aziende.id_azienda =  filiali.id_azienda
                                                            ");
              $this->select->bindParam(":idDipendente", $idDipendente);

              $this->select->execute();
              $result =  $this->select->fetchAll(PDO::FETCH_ASSOC);

              $count = $this->select->rowCount();


              if($count>=1)
                return $result;

          }
          catch (PDOException $e)
          {


            echo "<h1>Errore:</h1>" . $e->getMessage();
            echo "<h2>Clicca <a href=" . $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/index.html" . ">qui</a> per ritornare alla pagina e riprovare</h2>";

          }
        }


    }




?>
