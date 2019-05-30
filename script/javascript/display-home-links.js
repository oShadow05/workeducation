/* 

In this file the browser handle the year of the copyright and 
show different pages inside the home page. 

The ds-tabs, active-link and active-tab are css classes for dinamically 
display: none or display: block pages.

The script for display pages is written in jQuery.

*/ 
// Disable show class for small devices:
jQuery('.show').removeClass("show");

showPages();

// update copyright year, The function loads always when the home page starts
var updateCopyrightYear = (function()
{
    
    var date = new Date();
    var year = document.getElementById("copyright-year");
    year.textContent = date.getFullYear();

}());

// Run jQuery with the noConflict() method because the browser run other different javascript library:
    jQuery.noConflict();



function showPages()
{
    // Get the nav item list:
    jQuery('.nav-list').each(function(){

        // Get the nav-list stored in variable:
            var $this = jQuery(this);

        // Get the active link:
            var $tab = $this.find('li.active-link');
        
        // Find the link of the pages and the href value:
            var $link = $tab.find('a');

            var $panel = jQuery($link.attr('href'));

        // Event onClick:
            $this.on("click", ".nav-link", function(e)
            {
                // Disable redirect:
                    e.preventDefault();

                // Get the new link:
                    var $link = jQuery(this);

                // Get the id from the link variable:
                    var id = this.hash;
                
                // If the id and the link are changed the script show the new page.
                    if(id && !$link.is('active-tab'))
                    {
                        // Remove add previus style for the links not active: 
                            $panel.removeClass('active-tab');

                            $panel.addClass("ds-tabs");

                            $tab.removeClass('active-link');
                        
                        // Add new style for the navbar active link and display it:
                            $panel = jQuery(id).addClass('active-tab');

                            $tab = $link.parent().addClass('active-link');


                            if(id=="#login")
                            {
                                jQuery("footer").addClass("ds-tabs");
                            }
                            else
                            {
                                jQuery("footer").removeClass("ds-tabs");
                                jQuery("#input-username").removeClass("is-invalid");

                                jQuery("#input-username").val("");

                                jQuery("#error-message-usr").removeClass("error-message");
                                jQuery("#error-icon-usr").removeClass("fas"); 
                                jQuery("#error-icon-usr").removeClass("fa-exclamation-triangle");                     
                                jQuery("#error-message-usr").text("");

                                jQuery("#input-password").removeClass("is-invalid");
                                jQuery("#input-password").val("");

                                jQuery("#error-message-pwd").removeClass("error-message");
                                jQuery("#error-icon-pwd").removeClass("fas"); 
                                jQuery("#error-icon-pwd").removeClass("fa-exclamation-triangle");                     
                                jQuery("#error-message-pwd").text("");

                            }
                            
                       
                    }

        });
    });

}





