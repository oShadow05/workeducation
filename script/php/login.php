<?php
    /*
        This file contains code for check if user entered valid credentials and redirect him.
    */


/* ******************************************  START LOGIN SCRIPT  ************************************************ */


// Session init:
  session_start();

// Import external files:
  require $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/script/php/credentials.php";

  require $_SERVER["DOCUMENT_ROOT"] . "/dashboard/workereducation/script/php/requestHandler/RequestDatabaseHandler.php";

// Save the username and password for the database pages:
  $_SESSION["username"] = $_POST["username"];

  $_SESSION["password"] = $_POST["password"];
  
 // Create connection to database:
  $conn = new RequestDatabaseHandler($host, $type, $dbName, $userLogin, $passwordLoginUser);

  $conn->request();




  if($_POST["username"] != NULL && $_POST["password"] != NULL)
  {

    // Create query object:
      $query = new SendQuery();


    // Send login query:
      $result = $query->login($_POST["username"], $_POST["password"], "credenziali");
      $livello = $result;

    // This if means that the user insert wrong credentials, the session variable is reset to NULL:
      if($livello==0)
      {

        header("location:../../index.html?er=2");
        $_SESSION["username"] = NULL;

        $_SESSION["password"] = NULL;


      }
      else
      {
        $livello = $result;
        $_SESSION["livello"] = $livello;
        if($livello==1)
        {
          header("location:../../pages/admin.php");

        }
        else {
          if($livello==2)
            {
              header("location:../../pages/docente.php");

            }
          if($livello==3)
          {
            header("location:../../pages/azienda.php");
          }
          else {
              if($livello==4)
              {
                header("location:../../pages/user.php");
              }
            
          }
        }
      }


    // Close php script:
      exit();


  }

// The username and the password fields are NULL and the user will be redirect in the index with an error 1:
    else
    {

      // Redirect:
        header("location:../index.html?er=1");

      // Destroy session:
        session_destroy();

      // Close php script:
        exit();

    }

/* ******************************************  END LOGIN SCRIPT  ************************************************ */


 ?>
