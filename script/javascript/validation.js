

/* THIS FILE VALIDATE THE USER INPUT FOR THE LOGIN. */

/* ***  FUNCTION CALLS:  ************************************************************************************** */

validateUser();

validatePassword();

redirectToLogin();

validateInsert();

/* ******************************************  START VALIDATION  ************************************************ */

// Validate the user and check if the input contain only letters and numbers.



function validateUser()
{
    // Get the form id:
        var idForm = document.getElementById("validate-submit");

    // Use of idForm for the event Submit:
        idForm.addEventListener("submit", function(e){

            // Create regular expression that match only letters and number:
                var regularExpression = new RegExp("[a-zA-Z0-9]");

            // Create id's for show error:
                var inputUser = document.getElementById("input-username");

                var errorMessage = document.getElementById("error-message-usr");

                var errorIcon = document.getElementById("error-icon-usr");

            // Control the value of input user field:
                if(!regularExpression.test(inputUser.value))
                {
                    // Disable the redirect to login.php page:
                        e.preventDefault();

                    // Set the error:
                        inputUser.classList.add("is-invalid");

                        errorMessage.classList.add("error-message");

                        errorIcon.classList.add("fas");

                        errorIcon.classList.add("fa-exclamation-triangle");

                        errorMessage.textContent = " Il campo username non può essere vuoto e non devi inserire caratteri speciali.";

                }

    }, false);

}


// Validate the password and check if the input contain only letters and numbers.
function validatePassword()
{
    // Get the form id:
        var idForm = document.getElementById("validate-submit");

    // Use of idForm for the event Submit:
        idForm.addEventListener("submit", function(e){

            // Create regular expression that match only letters and number:
                var regularExpression = new RegExp("[a-zA-Z0-9]");

            // Create id's for show error:
                var inputPwd = document.getElementById("input-password");

                var errorMessage = document.getElementById("error-message-pwd");

                var errorIcon = document.getElementById("error-icon-pwd");

            // Control the value of input password field
                if(!regularExpression.test(inputPwd.value))
                {
                    // Disable the redirect to login.php page:
                        e.preventDefault();

                    // Set the error:
                        inputPwd.classList.add("is-invalid");

                        errorMessage.classList.add("error-message");

                        errorIcon.classList.add("fas");

                        errorIcon.classList.add("fa-exclamation-triangle");

                        errorMessage.textContent = " Il campo password non può essere vuoto e non devi inserire caratteri speciali.";

                }

    }, false);
}

// Function for redirect to the login form
function redirectToLogin()
{
    var param = location.search.split('er=')[1];
    jQuery.noConflict();

    if(param==="1")
    {
        jQuery('.nav-list').each(function()
        {
              // Get the nav-list stored in variable:
              var $this = jQuery(this);

              // Get the active link:
                  var $tab = $this.find('li.active-link');
              // Find the link of the pages and the href value:
                  var id = "#login";
                  var $link = $tab.find('a');
                  var $panel = jQuery($link.attr('href'));
                  if(id && !$link.is('active-tab'))
                    {

                            // Remove add previus style for the links not active:
                                $panel.removeClass('active-tab');
                                $tab.removeClass("active-link");
                                $panel.addClass("ds-tabs");

                            // Add new style for the navbar active link and display it:
                                $panel = jQuery(id).addClass('active-tab');
                                jQuery('.show').removeClass("show");


                    }
        });


    }
    else
    {
        if(param==="2")
        {
            jQuery('.nav-list').each(function()
            {
                // Get the nav-list stored in variable:
                var $this = jQuery(this);

                // Get the active link:
                    var $tab = $this.find('li.active-link');
                // Find the link of the pages and the href value:
                    var id = "#login";
                    var $link = $tab.find('a');
                    var $panel = jQuery($link.attr('href'));
                    if(id && !$link.is('active-tab'))
                    {

                            // Remove add previus style for the links not active:
                                $panel.removeClass('active-tab');
                                $tab.removeClass("active-link");
                                $panel.addClass("ds-tabs");

                            // Add new style for the navbar active link and display it:
                                $panel = jQuery(id).addClass('active-tab');
                                jQuery('.show').removeClass("show");


                    }
            });
            var errorMessage = document.getElementById("error-message");
            jQuery("#error-icon").addClass("fas");
            jQuery("#error-icon").addClass("fa-exclamation-triangle");
            errorMessage.textContent = "Username o password errati";
            errorMessage.classList.add("error-message-dialog");

            }
        }
}



function validateInsert()
{
  var fields = {};
  var nFields = document.querySelectorAll("#field").length;

  for(var i=0; i<nFields; i++)
  {
      fields[i]['value'] = $("#" + i).val();
      fields[i]['type'] = $("#" + i).attr("type");
  }

  
}




/* ******************************************  END VALIDATION  ************************************************ */
