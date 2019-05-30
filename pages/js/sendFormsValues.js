

var updateCopyright = function(){
  var date = new Date();
  var year = date.getFullYear();
  var idCopyright = document.getElementById("copyright-year");

  idCopyright.innerText = year;

}();


jQuery.noConflict();
jQuery(document).ready(function()
{

  // Function calls:
    submitInsertStage();

    ajaxDataTables();

    showPages();

    htmlStudente();

    htmlDocente();

    htmlAzienda();

    htmlFiliale();

    htmlDipendente();

    htmlStage();

    htmlDeleteStudente();

    htmlDeleteProfessore();

    htmlDeleteAzienda();
    htmlDeleteFiliale();
    htmlUpdateStudenti();

    htmlUpdateProfessore();

    htmlModificaFilialeSelectAzienda();

    htmlUpdateAzienda();

   // sendAziendaStage();

    sendPattoFormativo();
    sendConvenzione();
    sendValutazione();

    sendRegistro();

    htmlselectAziendaUpdateDipendente();

});

function htmlselectAziendaUpdateDipendente()
{
  jQuery.noConflict();
  console.log(jQuery("#UpdateDipendente"));

  jQuery("#UpdateDipendente").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");
    jQuery("#update-studente").hide(500);
    jQuery("#update-professore").hide(500);
    jQuery("#update-azienda").hide(500);
    jQuery("#update-dipendente").hide(500);
    jQuery("#update-dipendente-values").hide(500);
    jQuery("#update-filiale-values").css("display","none");


    jQuery("#update-filiale").hide(500);
    jQuery("#update-filiale-values").hide(500);

    jQuery("#update-dipendente").hide().fadeIn(300);
    $htmlUpdateDipendente = jQuery("#update-dipendente");
    jQuery.ajax(
      {
        type: "POST",
        url: "htmlphp/htmlModifica/htmlModificaDipendenteSelectAzienda.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,
        success:function(data)
        {
          $htmlUpdateDipendente.html(jQuery(data).filter("#cred-input-form-upd")).hide().fadeIn(500);

        },
        complete: function()
        {
          htmlModificaFilialeSelectFilialeForDip();
        }
      }
    );
  });
}


function htmlModificaFilialeSelectFilialeForDip()
{
  jQuery.noConflict();

  var valAzienda;

  jQuery("#cntSubmitUpdateDipendente").click(function()
  {

  jQuery("#update-studente").hide(500);
  jQuery("#update-professore").hide(500);
  jQuery("#update-azienda").hide(500);
  jQuery("#update-filiale-values").hide().fadeIn(300);


  jQuery("#update-filiale").hide().fadeIn(300);
  jQuery("#update-dipendente").hide(500);
  jQuery("#update-dipendente-values").hide(500);


      valAzienda = jQuery("#get-id-update-az-filiale-dip").val();
      var valAziendaParsed;


      valAziendaParsed = "";
      for(i=0; i<valAzienda.length; i++)
      {
        if(valAzienda[i]==" ")
        {
          break;
        }
        else
        {

          valAziendaParsed += valAzienda[i];
        }
      }

      var jsonValAziendaParsed = JSON.stringify(valAziendaParsed);
      console.log(valAziendaParsed);
      jQuery(".disable-dip").hide(500);
      jQuery.ajax(
        {
          type: "POST",
          url: "htmlphp/htmlModifica/htmlModificaDipendenteSelectFiliale.php",
          contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
          timeout: 10000,
          data: {code_az:jsonValAziendaParsed},


          success:function(data)
          {
            $htmlUpdateFiliale.html(jQuery(data).filter("#cred-input-form-upd-dipendente")).hide().fadeIn(500);
            htmlUpdateDipendente();
          },

        }
      );
  });
}


function htmlUpdateDipendente()
{
  jQuery.noConflict();
  jQuery.noConflict();
  var $htmlUpdateDipendente = jQuery("#update-dipendente-values");
  jQuery("#continueSubmitUpdateDipendente-2").click(function()
  {

    jQuery("#update-studente").hide(500);
    jQuery("#update-professore").hide(500);
    jQuery("#update-azienda").hide(500);
    jQuery("#update-filiale-values").hide(500);


    jQuery("#update-filiale").hide(500);
    jQuery("#update-dipendente").hide(500);
    jQuery("#update-dipendente-values").hide().fadeIn(300);
    jQuery("#update-filiale-values").css("display","none");

    jQuery("#disable-dip-2").css("display", "none");

    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlModifica/htmlModificaDipendente.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success: function(data)
        {
          $htmlUpdateDipendente.html(jQuery(data).filter("#cred-input-form-dip"));
        },
        complete:function()
        {
          updateDipendenteSend();
        }
      }
    );
  });

}

function updateDipendenteSend()
{
  var valDipendente = [];
  var nModifiedFields = 0;
  var fieldsName  = [];
  var firstField = "id_dipendente";
  var length = 0;
  var idFilialeToChange;
  jQuery.noConflict();

  jQuery("#submitUpdateDipendente").click(function()
  {
    var $nFields    =  jQuery(".form-box-update-dip");

    length = document.querySelectorAll("#field-update-dipendente").length;
    var parseFilialeToChange="";
    for(i=0; i<length; i++)
    {
      if(jQuery($nFields[i]).children().eq(1).val()!="")
      {
        fieldsName.push(jQuery($nFields[i]).children().eq(0).text());
        valDipendente.push(jQuery($nFields[i]).children().eq(1).val());
        nModifiedFields++;
      }
    }

     idFilialeToChange = jQuery("#get-select-filiale-dip").val();
     for(i=0; i<idFilialeToChange.length; i++)
     {
       if(idFilialeToChange[i] == " ")
        break;
       else
       {

        parseFilialeToChange += idFilialeToChange[i];
       }
     }
     console.log(parseFilialeToChange);
     var jsonValDipendente = JSON.stringify(valDipendente);

     var jsonFirstField = JSON.stringify(firstField);

     var jsonFieldsName = JSON.stringify(fieldsName);

     var jsonFirstField = JSON.stringify(firstField);
     jQuery.ajax(
       {
        type: "POST",
        url: "scriptphp/updateScript/update.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,
        data: {inputValues:jsonValDipendente, firstField:jsonFirstField, nModifiedFields:nModifiedFields, code:parseFilialeToChange,primaryKeyFieldName:jsonFirstField, fieldsName:jsonFieldsName},
        beforeSend: function()
        {

        },
        complete: function()
        {
          console.log("ajax");
            nFields = 0;
            valDipendente = [];
            nModifiedFields = 0;
            fieldsName = [];
            ajaxDataTables();
        }

       }
     );
  });
}

function sendPattoFormativo()
{



  jQuery.noConflict();
  var getBtnList = document.querySelectorAll("#val-azienda");
  var getNumberBtnList = getBtnList.length;
  var $html;

  for(i=0; i<getNumberBtnList; i++)
  {
    var btn = "#patto" + i;


      jQuery(btn).click(function()
      {
          var parse = this.id;
          var temp = parse.substring(parse.length-1, parse.length);


        var matricola = jQuery("#mtr" + temp).text();
        var dateStart = jQuery("#date-start" + temp).text();
        var dateEnd = jQuery("#date-end" + temp).text();
        var docente =  jQuery("#dct" + temp).text();
        var idDipendente = jQuery("#dpn" + temp).text();



        var jsonMatricola = JSON.stringify(matricola);
        var jsonDocente = JSON.stringify(docente);
        var jsonDipendente = JSON.stringify(idDipendente);
        var jsonDateStart = JSON.stringify(dateStart);
        var jsonDateEnd = JSON.stringify(dateEnd);

        jQuery.ajax(
          {
            type: "POST",
            url: "pdf/pdfPattoFormativo/pattoFormativo.php",
            contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
            timeout: 10000,
            data: {matricola:jsonMatricola, idDocente:jsonDocente, idDipendente:jsonDipendente, dateStart: jsonDateStart, dateEnd:jsonDateEnd},

            success: function(data)
            {
              $html = jQuery(data);
              var doc = new jsPDF();

              // Create script for insert text:
                var text    =  $html.filter("#text-patto");
                var table1  =  $html.filter("#table-1")[0];
                var table2  =  $html.filter("#table-2")[0];
                var table3  =  $html.filter("#table-3")[0];
                var table4  =  $html.filter("#table-4")[0];
                var table5  =  $html.filter("#table-5")[0];
                var table6  =  $html.filter("#table-6")[0];


                var footer  =  $html.filter("#footer");


                var notaPatto = $html.filter("#nota-patto");

                var image   = "data:image/png;base64,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";

              // Formatting table 1:
                doc.autoTable({
                  html:table1,
                  theme:"grid",
                  styles: {
                    lineColor: [0, 97, 255],
                    lineWidth: 0.55,
                    halign:"center",
                    fontSize: 10,
                    cellPadding:5
                },
                columnStyles:
                {
                  0: {cellWidth: 50},

                },
                  startY: 15});


                doc.addImage(image, "JPEG", 25, 17, 30, 30);

              // ------------------------------

               // Formatting table 2:
               doc.autoTable({
                html:table2,
                theme:"plain",
                styles: {
                  lineWidth: 0.55,
                  halign:"right",
                  fontSize: 10,
              },
              columnStyles:
              {
                1: {cellWidth: 30, halign:"left"},
                3: {cellWidth: 33, halign:"left"},

              },
              headStyles:
              {
                lineWidth:0,
                halign:"left"
              },
                startY: 70});



            // ------------------------------


            // Formatting table 3:
            doc.autoTable({
              html:table3,
              theme:"plain",
              styles: {
                lineWidth: 0.55,
                halign:"right",
                fontSize: 10,
            },
            columnStyles:
            {
              1: {cellWidth: 30, halign:"left"},
              3: {cellWidth: 33, halign:"left"},

            },
            headStyles:
            {
              lineWidth:0,
              halign:"left"
            },
              startY: 98});

        // Nota Patto
        doc.setFontSize("11");
        var splitText = doc.splitTextToSize(notaPatto.text(), 180);
        var pageHeight= doc.internal.pageSize.height;
        y = 170;
        for(j=0; j<splitText.length; j++)
        {
            if(y>=pageHeight)
            {
              y = 15;
              doc.addPage();
            }
            else
            {

              y += 5;

              doc.text(15, y, splitText[j]);

            }
        }
        // ---------------------------------

          // ------------------------------

          // Formatting table 4 :
          doc.autoTable({
            html:table4,
            theme:"plain",
            styles: {
              lineWidth: 0.55,
              halign:"right",
              fontSize: 10,
          },
          columnStyles:
          {
            1: {cellWidth: 40, halign: "center"},
          },
          headStyles:
          {
            lineWidth:0,
            halign:"left"
          },
            startY: 125});



        // ------------------------------

         // Formatting table 5:
         doc.autoTable({
          html:table5,
          theme:"plain",
          styles: {
            lineWidth: 0.55,
            halign:"right",
            fontSize: 10,
        },
        columnStyles:
        {
          1: {cellWidth: 40, halign:"left"},
        },
        headStyles:
        {
          lineWidth:0,
          halign:"left"
        },
          startY: 183});



      // ------------------------------







                var textWidth = doc.getStringUnitWidth("PATTO FORMATIVO") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                var textOffset = (doc.internal.pageSize.width - textWidth) / 3;

                    doc.setFontSize("30");
                    doc.text(textOffset, 65, "PATTO FORMATIVO");
                    doc.setFontSize("11");
                    var splitText = doc.splitTextToSize(text.text(), 180);
                    var pageHeight= doc.internal.pageSize.height;
                    y = 203;
                    for(j=0; j<splitText.length; j++)
                    {
                        if(y>=pageHeight)
                        {
                          y = 15;
                          doc.addPage();
                        }
                        else
                        {

                          y += 5;

                          doc.text(15, y, splitText[j]);

                        }
                    }

                  // Formatting table 6 :
                      doc.autoTable({
                        html:table6,
                        theme:"plain",
                        styles: {
                          lineWidth: 0.55,
                          halign:"right",
                          fontSize: 9,
                      },
                      columnStyles:
                      {
                        1: {cellWidth: 40, halign:"left"},
                      },
                      headStyles:
                      {
                        lineWidth:0,
                        halign:"left"
                      },
                        startY: 246});
                // ----------------------------------------------------------

                        var splitText = doc.splitTextToSize(footer.text(), 180);
                        var pageHeight= doc.internal.pageSize.height;
                        y = 290;
                        for(j=0; j<splitText.length; j++)
                        {
                            if(y>=pageHeight)
                            {
                              y = 15;
                              doc.addPage();
                            }
                            else
                            {

                              y += 5;

                              doc.text(15, y, splitText[j]);

                            }
                        }

                    doc.save("patto_formativo_" + dateStart  + "_" + dateEnd + ".pdf");
              // ------------------------------------------------------

            }
          }
        )
      });
  }




  }

  function sendValutazione()
{



  jQuery.noConflict();
  var getBtnList = document.querySelectorAll("#val-azienda");
  var getNumberBtnList = getBtnList.length;
  var $html;

  for(i=0; i<getNumberBtnList; i++)
  {
    var btn = "#valutazione" + i;


      jQuery(btn).click(function()
      {
          var parse = this.id;
          var temp = parse.substring(parse.length-1, parse.length);


        var matricola = jQuery("#mtr" + temp).text();
        var dateStart = jQuery("#date-start" + temp).text();
        var dateEnd = jQuery("#date-end" + temp).text();
        var docente =  jQuery("#dct" + temp).text();
        var idDipendente = jQuery("#dpn" + temp).text();
        var protocollo = jQuery("#protClasse" + temp).text();



        var jsonMatricola = JSON.stringify(matricola);
        var jsonProtocollo = JSON.stringify(protocollo);
        var jsonDocente = JSON.stringify(docente);
        var jsonDipendente = JSON.stringify(idDipendente);
        var jsonDateStart = JSON.stringify(dateStart);
        var jsonDateEnd = JSON.stringify(dateEnd);

        jQuery.ajax(
          {
            type: "POST",
            url: "pdf/pdfValutazione/valutazione.php",
            contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
            timeout: 10000,
            data: {matricola:jsonMatricola, idDocente:jsonDocente, idDipendente:jsonDipendente, dateStart: jsonDateStart, dateEnd:jsonDateEnd, codProtocollo:jsonProtocollo},

            success: function(data)
            {
              $html = jQuery(data);
              var doc = new jsPDF();

              // Create script for insert text:
                var text    =  $html.filter("#text-patto");
                var table1  =  $html.filter("#table-1")[0];
                var table2  =  $html.filter("#table-2")[0];
                var table3  =  $html.filter("#table-3")[0];
                var table4  =  $html.filter("#table-4")[0];
                var table5  =  $html.filter("#table-5")[0];
                var table6  =  $html.filter("#table-6")[0];
                var table7  =  $html.filter("#table-7")[0];

                var table8  =  $html.filter("#table-8")[0];

                var table9  =  $html.filter("#table-9")[0];
                var table10  =  $html.filter("#table-10")[0];
                var table11 =  $html.filter("#table-11")[0];
                var table12  =  $html.filter("#table-12")[0];
                var table13  =  $html.filter("#table-13")[0];
                var table14  =  $html.filter("#table-14")[0];


                var footer  =  $html.filter("#footer");


                var notaPatto = $html.filter("#nota-patto");

                var image   = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAFkAAABTCAIAAAB78jyeAAAACXBIWXMAAAsSAAALEwHLxk+9AAATD0lEQVR4nN2cCXROV7vHT+LVmmuISFBDYkijhsYciap5DNEaLjW1q0W19KvSQfupr1R1ULV0oZZFhYv6qF660uriGiq95sasuFXUmCBEEgnJ/eX8ZffkTWjrvkk0z1qO8+5zzj77+e9n3vvEdfPmzbS0tJSUlOXLly9evHjPnj3JycnFixevVavW4MGDu3btWrJkyVKlStFStGhRb29vLy8vq5CSCyCSkpJ69+69a9cu+O/Xr5+Pj8+lS5diY2MnTJiwYsWKiRMn0l62bFkQAY4iRYoU9JjzilxIBEAcOnRo2LBhFSpUUGuJEiWqVq3apk2bqKio8ePHz5gx48aNG6CGjBQrVszlcnnZVLBD9zi5vvzyy927dz/77LPMvGnNsOnBBx+MiIhYtGjRvHnzBgwYcP36dUSmdOnSIIWAFD5EXEuWLAkKCnIDIj09/datW2kpcTcvr380IO1/Ni/79dDqKpUf6ty1T/M2wx966CEERIgUJgviwkxgI8xvAYFBTTy/fuWaHXWrZ4x40nqsrhV3JeXbmJR//mtW4IIFk6Ytrlq9HmCBCLJTaCyIC8NpzIRlYwGTADFn0fYlk60+7X+/tWML641hVu9x1/8xqt+0T6JqBDZEIgCi0IiGC2d58eJFZtgyQnEj/svVO+a+aT3Vzv3uiuWsf39gdRyV+l/LJvV/bs4DNgEHtqMAxu5pcoWEhOA+a9SoYWUJxdULW6v4ZgyLyP2BSuWtt561Rk491D4yTnZUalIIRMMVGRn5+uuvh4eHly9fXlgcO/oL6nAX6h5uDf5nxtG9//bxGVGuXDkeya/R5i25unXrRkBFxNmzZ88qVaqgI4lJN6v73+2Z4g9aZUtbqampxCYEHRhaQCwMckE0OXPmTEQDONCU4OBgbMa5+D94LCnFSr+V6XfBDiDyZah5Ti6sJn7k3XffXbt27bp16zZt2tQoIO27H613nr/jM/+907qebJWv+oS3TYVAIkSZfkSBFoYjNDT03Llzp/932+fz5kfHZHQJzeWB+ARr3KdWtzblsZpK2AqH4YTwhpmiwfTiDjghpgSap7pv7/v63rUzrMdD3B8Y8Z516ap3/yGjuBP9UnpSECP3PLk0q2DBDDPPwIGnLNVvWmray73GHkE0/jHQalDLSky21my2Js+3ihdzDRnU19e/FppVpkwZsCg8csE/6TwsAQexU3GbBg6fF9J89bpvFncdffHqdXytFRzgat3i4XpNBwGEv7+/r68vWBSqGFz/KeMEiKI2cQKTJUoMqFG3U7+EBDJUHCc30IjUEFOQsBKPYDKUrRYsD54id1WHMbDQCYjAOUDcuHFDAZX0qJRNaJMC8AIYdd6QOxaqXHACk0iBZfNv4ggalYOgVkiKANIjkiynl/XKTrSrMb9Z/NOUDQtYMuXPGzbBLfGlLnHMLGqkpdEOY6bMce3atatXr3IV84H6gKB3Dipik1vj/VYKyoYFvMHquHGRBw4ct+WAf77JyTc18w9UOHn1coqNguWXfjMlDjFxgRRBuE/pYnsTy3ApOTkZtcIr41/8/PwIZCtVqoSV5aR69erol8smpbZFssjgUrDQuGPBnO/ff6xjR5+wMP/k5Ftjxvxcu3btrl270j5v6ateRdMjRlo3U60fplrnEqwlHTNFZvTmjNSU5PPnk9XJlStXTp06ZfokDJEN4oj3qVmzZsOGDR955JF69eqBWtEsMhgVYCzrjoU0ok6dss2a+V65koo4VKxYkaFjQS0vq2QZq0Y9KzUZN2yVcFkt/DKfKlU00yuXKVNKgQaSJX4uX77M1YSEBNP/hQsXYmNjifTRI8ANCAho2rQpGdDjjz/OWx7IIkGj3vITlFzsRda5dfNmumkHJnNbeo4cHTPxH12fQh3QAn4CKNJx6dIljmfOnElMTDx//rysL9Ak2cRt+21COjBPQUFBYWFhnTt3Rl7oBBUzoOSbmLj7EZvnjKzzjGztWb8yLHPLbWK4uFg/m7CgTOktm+RrdPztt99Idjj+/PPPJ06cwLLIPGN66WHfvn2HDx9eunQpZqVv376dOnVCUohfBEr+VBLd5SLX82yU4Q6EZTtg7CU2skqVKpwwmXIxBgsIY8ExNYuQFISCtBgI4DPTBqelXbEJsObMmdOnT59evXoBjbIeIZKncHgmrSqSaS8yHSpJCkfGnZ5Fik0MIgYOJKhu3bpYZfTlm2+++f777y9evChrhchgfWfPnv3tt9+OHDmyXbt2xLiquedpmOsZLAikUHJl8aqAZjhIlkLQCA6FLaqMgcXgwYOxFNHR0evXrz99+rT6BJGDBw+OHz9+1KhRQ4cO5VkFbHkX6XoGC287tXMLNN3ukdI55UVxHSYDtpl5TC+SMmXKlEyflUVcioqKQlOQDsQtT02px0oPfzhEXVVwZWVF7jKxCIhK6uHh4SEhIVu2bHE+iGVBZBo3bqzl/ryrrd4rFtkHcw+DM0kKU63MmJ+oTK42G+lAlZAg1Znvccx/RH8Fizvw6223e2SuYmJidu3a5daIE2nSpEk+VJjvVS5yDOwexvr7InZaGoGZFvQRAec9iExoaKgCsLxeyvaAvSAi+0tAOC2FdsLgUBcuXIhEEFw478RPt23btlu3bphV8pq8Lh3ljgU+wZyr7nD73OHOXNmHZAofuZLTiciDYC/j4+O/++67mTNnkqc40xbLLkkHBgYSaxGbK5wlbFGae1/LhZUpGhluK4mGebfIAkEgDN+xY8fq1at3796NUKj2IVLNlVSwQ4cOYAH/ROI+Pj6c5ENtNXcs3DORLHJOfLrjfhjGyCuOhvSUIk5BQEyJCpCkbtiwAR8JBE5BgH/CSnhu2bIlGT2xBpyjFEDAkXPFb3ldW/WMXMA2ARIzDIcMl0Ej9iQaJ0+e3Lt3LydxcXFcxUA6n9LmHmwBggAE5DJalID5zHUJm5Sz5s8GIM9gQa7JhGs/JCJAPiqjSLvExJCWVJjw4ODgQJsk/DQKGh0lCJIFJakeGefdyTNYJF2/vnHdulwvaWLhqnLlyvXr169WrVpAQACNKk/oknJzcyekpcl8XoXy5PIfQzc7HsncERCtJ3S1iRbn4ouTnBUtA0H+l/k8gwUQNG5c7+GHHyaJqlmzJpk7zoIsi0uwikXAUqAXiIYqEc5anuG/wFftPYNF6dJlgsLDwQJumX/42bhxoywFVhB0sIuKl0DElHkN/9b9sW7iGSyKPlAUj+jv7w8WMIxb2bRpE4kWl0jDEZNKNnGCaRAEzrjrLj0rfzNHj4z2TuQZLJhlFbUIjRCExMTEY8eOWbbhrFOnDp4CYVFWjmqowgxpXzVw3ClgVeUGJTIO5W8QXzBr8KmIgHEjFPBPQMHo5TVkU6UOCsDat29v4rE7duvlhQGaPn063dK/NgN4ZMC5ksf8iJbCGC68bdmyRZE1UqDypylJWVmrc6Tnf6Zb4jQSNklHXm968XDvWm1CLvQTaBRKuEk44tC8eXPuxOkSm6IsqAmihE3hZtMb9xOPmK2Cnh1qTvI8Foo79dMItnOBQ1xFRUURnk+bNk18AlarVq0IRmEefyQRQxac3yR4dqg5yZNYqCrBPJuQWZU7Z+BgihenT58eO3bsmTNnwAJr0rp1axIzGWBtp1PooahUhZy/hx8RickjR47Im0I4lHQHqX7DVYzFhAkTlLaAV6dOnbQI4uvrq09UlJ6LjB/J66zEwzoCHErJ9RNDAMOIvQr/KuHgFxYtWkRgatlRaWhoaEREBOLgaxNWw1mz+fvFFyIFDr/88otpIU+Njo4OCgq6fPkycrF///5Zs2aRzqqWB889evQgVQEI4jRiE1Qjr4tXdyEPYwHFxcWZFjRi586dqEODBg0AIj4+/uzZs7qERHSxCaXAfXAkYDWpnQdH9efJw1godnA2oi8HbXI2YiMjIyPDwsJQCgEhicgHA3kX8nz0Qox49xuY/EGDBjVu3Bil8PPzMxJRsEBYnsVCFo5kbOvWrW7SIYLb2rVrP/3000QQRiLwGgVoI5yUDQvnaHIZmQI/r1wW0LwdC4J4x1WrVhFxud2Dy2zSpAnuU/k7WKApcp/3AxBWTrmwfbjXtm0XiAavXcvcDfHrr7+SXyhkuHzeit1opd7AKFpXU61VxzMfiU+xAr29VZvh2KhRIyzi8uXL8aOWvdKB/ONWtf9INX4ZCLNb9n4AwsopFww9KKjGtm3HY2LiyadxdszwypUr8QglKpZJuJy0/j+9029ZfqVvVb5lTd+XmTWWKeHl4+un3TMQLa+++iqp+po1axISErRlr2bNmhiF8jaBgoKI++3z1mxYeNvTO27cXDyf1rIQB20CUZWBE2UTqiwo11BdmxhBX3iLvV69ehFWE3cScXCPKv2Qsu/8iSP/KrljwSiZQMtevCBSJEwEBQOBcLGyh4PApy8tZAVlNeAfnrVzWNupVezOn6rMvZE7FlrCYqxMIEAoiTDjVjRl5tNsGlLKoFq+WmQmVL8TOqbMad0f1c2clIu9ECLKpsy+d8uxB97tEZOJOnd5CyAndveVaciVcvlmwmwjumcy25H+P53kPxWST8U8Qu57Xc1eGbNdoKBGlqfk1GuzTJfLHujdu3drx8zdt5f8rUnM169fH8dnyuvucgEWzz33HP4vf8qtBUhAsGLFCjk+2fVcvrEi4iayIMoCDulI4QPFeH3nN+juPtVsuOS8EIuGogeRcfa55GYKE7XXv7DaTrev4NSYiYXbTm2phsKqnIvgRlLc9n3n1Ca3jxONkzLPGtvsfMp06/Rimka9S27OOQy3UeXk3Fx1vsjkWXokUyEMCtp2xjXsRWjo75/15+TZwGR2DBgHbF62d+9ezhs0aGBWiZze2rQ4O9RP07PWIh+2SUDQleCLjY3l6qOPPqqbZePIhvVtm8HdLUp2w10BsQyHVvZuY7Fhw4bOnTvv27evb9++hw4dCgoKat++/axZs7ja3KZt27aNGTNmwIAB6mj06NG0LFu2jHtiYmJefvll88eYdu7c+cILL2zfvp1zEvalS5f6+vryIjJXraG+8cYbzzzzTO3atZcsWTJw4EBamjZt2qxZs88++4xz3jt79uwjR46MGDFC30/07t17+vTpWkAjdWYM6odH6GHHjh3cqeXbN998c+jQoYMGDWJs/Jw5cyb9qNvIyMivvvpKT2ls0IQJE6ZMmXLq1Knbf6SAJi1bcEIXAMFYw8LCSDqTkpL27Nnz8ccfL1y4kHtq1ar1+eefP//885s3b/7iiy8Qori4ODwOJzA2b948nDHzExUVdfDgwfnz55OhA9nbb789bdo02KAHnr1y5QqerHv37rxO2/rgkxmGK4QItt95552zZ89++OGHML9y5UrOX3zxxUaNGoEaVoz37t+/f+3atTy7cePG48ePjx07Njw8/KWXXoqOjn7vvfcee+wxeBkyZAgjByb6b9iw4SeffOJlb5v66aefPvroI8QBBmfMmCFRoKvbTsOyK/faqVqnTh20Y+rUqQEBAe+//z5MIjIgoq9ftPnKskvbalGBQ5/rmkvIBY/7+fkhfu3atWPoPKiPn7/++uvExMQOHTpwtOxVNY6vvPJKcHAwcBw7duyDDz4AJvA6fPhwx44dgQOUwejEiRP0zGDi4+MZJPOECCDkKAVgtW7dms67dOny6aefgg5jAzJ6rly5Mj2gUG3btgUmscM4BYH5MJ2e6ZCrt22nrBTXIiIigJmZPHPmjFsYbswBx8DAQN6HDOs2E4loHri0detWwEYsO3XqxGukt0waQKCAulNDYcJhjxFXrFgR1JBVJhY06QGMLly4gOnp1q2bdvDAHmIPUi1btpw7dy7tKCCS2L9/f0l+hQoVGB7yVa5cOWQTdqpVqzZ48GB/f39mxRSiZJgysj7GFmsuY64su7Q5efJkpovgtG7duogZ7WYbiTbcWfbqeYsWLZBblBNNYzYUklj2Uhj6zOQwD/ykH+4xWzOqVq0KD6ruWPZyEUe0A56xfCVLlsToIBohISGvvfYawo+2yl7Aszp58sknf/zxx+HDh9Pes2fPVq1aweqkSZPeeustRoKIwTMvWrVqFYPEAvLUyZMnYYrxqHqiPRB6u2bIfOeYiQVniBlyiMxjRGU7aMRYatAMS8g98cQTGBSV7RYsWMCduoFjmzZtmC79aQi0bOLEiagbltVUtDC0uio/Qj9o1g8//IDFoYWBZth/O6BHjx6qlXE/ygKHmg99e8e7UH5sivZb8xNpQvqwnZgnzTPyoq9upPsjR45UMQWlE9scjx49ynvpGWERQLf9iKJRnWjjh+Wo6+hELkqc8wLadaeJIAS2nLY+PD1w4AB3woCmgmedJULOaacTVc/Us8ka9UbkXH5Rf6FE0bD8n9y/HC2Pg4gzCBAKihXMbkGzJUadKyvTS29vmLGySnsagTPWNFVJaZAcsvHPChZMAKKbdRVkNVZICwWKdp0On8dVBDSdOLVVP03B2WwD1YTJEpswxzlmTZ6pyJl4zyvrTweawM8ZyKnz/wP5L7/SYG3M1AAAAABJRU5ErkJggg==";

              // Formatting table 1:
                doc.autoTable({
                  html:table1,
                  theme:"grid",
                  styles: {
                    lineColor: [0, 97, 255],
                    lineWidth: 0.55,
                    halign:"center",
                    fontSize: 10,
                    cellPadding:5
                },
                columnStyles:
                {
                  0: {cellWidth: 50},

                },
                  startY: 15});


                doc.addImage(image, "JPEG", 25, 17, 30, 30);

              // ------------------------------

               // Formatting table 2:
               doc.autoTable({
                html:table2,
                theme:"plain",
                styles: {
                  lineWidth: 0.55,
                  fontSize: 10,
                  cellPadding:5
              },

              headStyles:
              {
                lineWidth:0.55,
                halign:"left"
              },
                startY: 60});

                 // Formatting table 3:
               doc.autoTable({
                html:table3,
                theme:"plain",
                styles: {
                  lineWidth: 0.55,
                  fontSize: 10,
                  cellPadding: 5
              },

              headStyles:
              {
                lineWidth:0,
                halign:"left"
              },
                startY: 90});

               // Formatting table 4:
               doc.autoTable({
                html:table4,
                theme:"plain",
                styles: {
                  fontSize: 10,
                  cellPadding:1
              },
              columnStyles:
              {


              },
              headStyles:
              {
                lineWidth:0,
                halign:"left"
              },
                startY: 200});




            // ------------------------------

             // Formatting table 5:
             doc.autoTable({
              html:table5,
              theme:"plain",
              styles: {
                fontSize: 10,
                cellPadding:1
            },

            headStyles:
            {
              lineWidth:0,
              halign:"left"
            },
              startY: 235});

                 // Formatting table 6:
             doc.autoTable({
              html:table6,
              theme:"plain",
              styles: {
                fontSize: 10,
                cellPadding:1
            },

            headStyles:
            {
              lineWidth:0,
              halign:"left"
            },
              startY: 260});




          // ------------------------------
          doc.setFontSize("16");

          var textWidth = doc.getStringUnitWidth("RELAZIONE SINTETICA GUIDATA SULL’ATTIVITA’ DI ASL") * doc.internal.getFontSize() / doc.internal.scaleFactor;
          var textOffset = (doc.internal.pageSize.width - textWidth) / 2;

              doc.text(textOffset, 194, "RELAZIONE SINTETICA GUIDATA SULL’ATTIVITA’ DI ASL");





            doc.addPage();
            // Formatting table 7:
            doc.autoTable({
              html:table7,
              theme:"plain",
              styles: {
                fontSize: 10,
                cellPadding:1
            },

            headStyles:
            {
              lineWidth:0,
              halign:"left"
            },
              startY: 15});




          // ------------------------------

             // Formatting table 12:
             doc.autoTable({
              html:table12,
              theme:"plain",
              styles: {
                lineWidth:0.55,
                fontSize: 10,
                cellPadding:3
            },
            columnStyles:{
              0:{cellWidth:30}
            },

            headStyles:
            {
              lineWidth:0.55,
              halign:"left"
            },
              startY: 50});




          // ------------------------------

          // ------------------------------
            doc.addPage();
             // Formatting table 9:
             doc.autoTable({
              html:table9,
              theme:"plain",
              styles: {
                fontSize: 10,
                cellPadding:3
            },
            columnStyles:{
              0:{cellWidth:40}
            },

            headStyles:
            {
              lineWidth:0.55,
              halign:"left"
            },
              startY: 15});

              doc.setFontSize("16");

              var textWidth = doc.getStringUnitWidth("RUBRICA DELLE COMPETENZE – PRIMA PARTE GENERALE") * doc.internal.getFontSize() / doc.internal.scaleFactor;
              var textOffset = (doc.internal.pageSize.width - textWidth) / 2;

                  doc.text(textOffset, 40, "RUBRICA DELLE COMPETENZE – PRIMA PARTE GENERALE");

              doc.setFontSize("9");

                  var textWidth = doc.getStringUnitWidth("Livelli: 5=Avanzato 4 = Intermedio 3= Base, 2= Parziale, 1= Minimo, (0 = nullo, inserire eventuale commento)") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                  var textOffset = (doc.internal.pageSize.width - textWidth) / 2;

                      doc.text(textOffset, 45, "Livelli: 5=Avanzato 4 = Intermedio 3= Base, 2= Parziale, 1= Minimo, (0 = nullo, inserire eventuale commento)");
                  // Formatting table 10:
                  doc.autoTable({
                   html:table10,
                   theme:"plain",
                   styles: {
                     lineWidth:0.55,
                     fontSize: 10,
                     cellPadding:1
                 },
                 columnStyles:{
                   0:{cellWidth:60}
                 },

                 headStyles:
                 {
                   lineWidth:0.55,
                   halign:"left"
                 },
                   startY: 50});







          // ------------------------------

            // Formatting table 11:
            doc.autoTable({
              html:table11,
              theme:"plain",
              styles: {
                lineWidth:0.55,
                fontSize: 10,
                cellPadding:1
            },
            columnStyles:{
              0:{cellWidth:60}
            },

            headStyles:
            {
              lineWidth:0.55,
              halign:"left"
            },
              startY: 147});



              // Formatting table 13:
              doc.autoTable({
                html:table13,
                theme:"plain",
                styles: {
                  fontSize: 10,
                  cellPadding:1
              },



                startY: 252});


            // Formatting table 14:
              doc.autoTable({
                html:table14,
                theme:"plain",
                styles: {
                  fontSize: 10,
                  cellPadding:5
              },

              headStyles:
              {
                lineWidth:0.55,
                halign:"left"
              },


                startY: 265});








                    doc.save("valutazione_" + dateStart  + "_" + dateEnd + ".pdf");
              // ------------------------------------------------------

            }
          }
        )
      });
    }
  }



function sendRegistro()
{



  jQuery.noConflict();
  var getBtnList = document.querySelectorAll("#val-azienda");
  var getNumberBtnList = getBtnList.length;
  var $html;

  for(i=0; i<getNumberBtnList; i++)
  {
    var btn = "#registro" + i;


      jQuery(btn).click(function()
      {
          var parse = this.id;
          var temp = parse.substring(parse.length-1, parse.length);


        var matricola = jQuery("#mtr" + temp).text();
        var dateStart = jQuery("#date-start" + temp).text();
        var dateEnd = jQuery("#date-end" + temp).text();
        var docente =  jQuery("#dct" + temp).text();
        var idDipendente = jQuery("#dpn" + temp).text();
        var protocollo = jQuery("#protClasse" + temp).text();


        var jsonMatricola = JSON.stringify(matricola);
        var jsonProtocollo = JSON.stringify(protocollo);

        var jsonDocente = JSON.stringify(docente);
        var jsonDipendente = JSON.stringify(idDipendente);
        var jsonDateStart = JSON.stringify(dateStart);
        var jsonDateEnd = JSON.stringify(dateEnd);

        jQuery.ajax(
          {
            type: "POST",
            url: "pdf/pdfRegistro/registro.php",
            contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
            timeout: 10000,
            data: {matricola:jsonMatricola, idDocente:jsonDocente, idDipendente:jsonDipendente, dateStart: jsonDateStart, dateEnd:jsonDateEnd, codProtocollo: jsonProtocollo},

            success: function(data)
            {
              $html = jQuery(data);
              var doc = new jsPDF();

              // Create script for insert text:
                var text    =  $html.filter("#text-1");
                var text2   =  $html.filter("#text-2");

                var table1  =  $html.filter("#table-1")[0];
                var table2  =  $html.filter("#table-2")[0];
                var table3  =  $html.filter("#table-3")[0];
                var table4  =  $html.filter("#table-4")[0];
                var table5  =  $html.filter("#table-5")[0];
                var table6  =  $html.filter("#table-6")[0];



                var image   = "data:image/png;base64,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";

              // Formatting table 1:
                doc.autoTable({
                  html:table1,
                  theme:"grid",
                  styles: {
                    lineColor: [0, 97, 255],
                    lineWidth: 0.55,
                    halign:"center",
                    fontSize: 10,
                    cellPadding:5
                },
                columnStyles:
                {
                  0: {cellWidth: 50},

                },
                  startY: 15});


                doc.addImage(image, "JPEG", 25, 17, 30, 30);

              // ------------------------------

               // Formatting table 2:
               doc.autoTable({
                html:table2,
                theme:"plain",
                styles: {
                  lineWidth: 0.55,
                  halign:"left",
                  fontSize: 8,
                  cellPadding: 3
              },
              columnStyles:
              {
                1:{cellWidth:20},
                3:{cellWidth:16},
                6:{cellWidth:15}
              },


                startY: 65});





            // ------------------------------




            doc.setFontSize("20");

                var textWidth = doc.getStringUnitWidth("MODULO REGISTRO ALTERNANZA SCUOLA-LAVORO") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                var textOffset = (doc.internal.pageSize.width - textWidth) / 2;

                    doc.text(textOffset, 185, "MODULO REGISTRO ALTERNANZA SCUOLA-LAVORO");
                    doc.setFontSize("11");
                    var splitText = doc.splitTextToSize(text.text(), 180);
                    var pageHeight= doc.internal.pageSize.height;
                    y = 185;
                    for(j=0; j<splitText.length; j++)
                    {
                        if(y>=pageHeight)
                        {
                          y = 15;
                          doc.addPage();
                        }
                        else
                        {

                          y += 5;

                          doc.text(15, y, splitText[j]);

                        }
                    }


                // ----------------------------------------------------------




                // Formatting table 3:
               doc.autoTable({
                html:table3,
                theme:"plain",
                styles: {
                  lineWidth: 0.55,
                  halign:"center",
                  fontSize: 8,
                  cellPadding: 6
              },
              columnStyles:
              {
                5:{cellWidth:60},
                6:{cellWidth:25}
              },
              headStyles:
              {
                fontSize:10,
                cellPadding:1
              },


                startY: 200});


                doc.autoTable({
                  html:table4,
                  theme:"plain",
                  styles: {
                    lineWidth: 0.55,
                    halign:"center",
                    fontSize: 8,
                    cellPadding: 6
                },
                columnStyles:
                {
                  5:{cellWidth:60},
                  6:{cellWidth:25}
                },
                headStyles:
                {
                  fontSize:10,
                  cellPadding:1
                },


                  startY: 230});

                  var splitText = doc.splitTextToSize(text2.text(), 180);
                  var pageHeight= doc.internal.pageSize.height;
                  y = 260;
                  for(j=0; j<splitText.length; j++)
                  {
                      if(y>=pageHeight)
                      {
                        y = 15;
                        doc.addPage();
                      }
                      else
                      {

                        y += 5;

                        doc.text(15, y, splitText[j]);

                      }
                  }

                doc.autoTable({
                  html:table5,
                  theme:"plain",
                  styles: {
                    halign:"right",
                    fontSize: 10,
                    cellPadding: 5
                },
                columnStyles:
                {

                },
                headStyles:
                {
                  fontSize:10,
                  cellPadding:1
                },


                  startY: 250});
              // ------------------------------------------------------
                                  doc.save("registro_" + dateStart  + "_" + dateEnd + ".pdf");


            }
          }
        )
      });
  }




  }



function sendConvenzione()
{



  jQuery.noConflict();
  var getBtnList = document.querySelectorAll("#val-azienda");
  var getNumberBtnList = getBtnList.length;
  var $html;

  for(i=0; i<getNumberBtnList; i++)
  {
    var btn = "#conv" + i;


      jQuery(btn).click(function()
      {
          var parse = this.id;
          var temp = parse.substring(parse.length-1, parse.length);


        var matricola = jQuery("#mtr" + temp).text();
        var dateStart = jQuery("#date-start" + temp).text();
        var dateEnd = jQuery("#date-end" + temp).text();
        var docente =  jQuery("#dct" + temp).text();
        var idDipendente = jQuery("#dpn" + temp).text();
        var codiceProtocollo = jQuery("#protClasse" + temp).text();


        var jsonMatricola = JSON.stringify(matricola);
        var jsonProtocollo = JSON.stringify(codiceProtocollo);

        var jsonDocente = JSON.stringify(docente);
        var jsonDipendente = JSON.stringify(idDipendente);
        var jsonDateStart = JSON.stringify(dateStart);
        var jsonDateEnd = JSON.stringify(dateEnd);

        jQuery.ajax(
          {
            type: "POST",
            url: "pdf/pdfConvenzione/convenzione.php",
            contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
            timeout: 10000,
            data: {matricola:jsonMatricola, idDocente:jsonDocente, idDipendente:jsonDipendente, dateStart: jsonDateStart, dateEnd:jsonDateEnd, codProtocollo:jsonProtocollo},

            success: function(data)
            {
              $html = jQuery(data);
              var doc = new jsPDF();

              // Create script for insert text:
                var text    =  $html.filter("#text-1");
                var text2    =  $html.filter("#text-2");
                var text3   =  $html.filter("#text-3");
                var text4   =  $html.filter("#text-4");
                var text5    =  $html.filter("#text-5");
                var text6    =  $html.filter("#text-6");
                var text7    =  $html.filter("#text-7");
                var text8    =  $html.filter("#text-8");
                var text9   =  $html.filter("#text-9");
                var text10    =  $html.filter("#text-10");
                var text11   =  $html.filter("#text-11");
                var text12    =  $html.filter("#text-12");
                var text13    =  $html.filter("#text-13");


                var table1  =  $html.filter("#table-1")[0];
                var table2 = $html.filter("#table-2")[0];

                var footer  =  $html.filter("#footer-convenzione")[0];



                var image   = "data:image/png;base64,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";

              // Formatting table 1:
              doc.autoTable({
                html:table1,
                theme:"grid",
                styles: {
                  lineColor: [0, 97, 255],
                  lineWidth: 0.55,
                  halign:"center",
                  fontSize: 10,
                  cellPadding:5
              },
              columnStyles:
              {
                0: {cellWidth: 50},

              },
                startY: 15});


              doc.addImage(image, "JPEG", 25, 17, 30, 30);

              // ------------------------------


          // Formatting table 2:
              doc.autoTable({
                html:table2,
                theme:"plain",
                styles: {

                  halign:"left",
                  fontSize: 10,

              },
              columnStyles:{
                1:{halign:"right"}
              },

                startY: 65});


              doc.addImage(image, "JPEG", 25, 17, 30, 30);

              // ------------------------------


            // ------------------------------


            doc.setFontSize("14");
                var textWidth = doc.getStringUnitWidth("CONVENZIONE TRA ISTITUZIONE SCOLASTICA E SOGGETTO OSPITANTE ") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                var textOffset = (doc.internal.pageSize.width - textWidth) / 2;


                    doc.text(textOffset, 85, "CONVENZIONE TRA ISTITUZIONE SCOLASTICA E SOGGETTO OSPITANTE ");
                    var textWidth = doc.getStringUnitWidth("TRA") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                    doc.text(textOffset, 93, "TRA");

                    doc.setFontSize("11");
                    var splitText = doc.splitTextToSize(text.text(), 180);
                    var pageHeight= doc.internal.pageSize.height;
                    y = 95;
                    for(j=0; j<splitText.length; j++)
                    {
                        if(y>=pageHeight)
                        {
                          y = 15;
                          doc.addPage();
                        }
                        else
                        {

                          y += 5;

                          doc.text(15, y, splitText[j]);

                        }
                    }

                    doc.setFontSize("14");
                    var textWidth = doc.getStringUnitWidth("E") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                    var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                    doc.text(textOffset, 127, "E");
                    doc.setFontSize("11");

                        var splitText = doc.splitTextToSize(text2.text(), 180);
                        var pageHeight= doc.internal.pageSize.height;
                        y = 127;
                        for(j=0; j<splitText.length; j++)
                        {
                            if(y>=pageHeight)
                            {
                              y = 15;
                              doc.addPage();
                            }
                            else
                            {

                              y += 5;

                              doc.text(15, y, splitText[j]);

                            }
                        }

                        doc.setFontSize("14");
                        var textWidth = doc.getStringUnitWidth("PERMESSO CHE") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                        doc.text(textOffset, 160, "PERMESSO CHE");
                        doc.setFontSize("11");

                        var splitText = doc.splitTextToSize(text3.text(), 180);
                        var pageHeight= doc.internal.pageSize.height;
                        y = 162;
                        for(j=0; j<splitText.length; j++)
                        {
                            if(y>=pageHeight)
                            {
                              y = 15;
                              doc.addPage();
                            }
                            else
                            {

                              y += 5;

                              doc.text(15, y, splitText[j]);

                            }
                        }

                        doc.setFontSize("14");
                        var textWidth = doc.getStringUnitWidth("SI CONVIENE QUANTO SEGUE") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                        doc.text(textOffset, 228, "SI CONVIENE QUANTO SEGUE");
                        doc.setFontSize("11");

                        var splitText = doc.splitTextToSize(text4.text(), 180);
                        var pageHeight= doc.internal.pageSize.height;
                        y = 228;
                        for(j=0; j<splitText.length; j++)
                        {
                            if(y>=pageHeight)
                            {
                              y = 15;
                              doc.addPage();
                            }
                            else
                            {

                              y += 5;

                              doc.text(15, y, splitText[j]);

                            }
                        }

                        doc.setFontSize("14");
                        var textWidth = doc.getStringUnitWidth("ART. 1") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                        doc.text(textOffset, 255, "ART. 1");
                        doc.setFontSize("11");

                        var splitText = doc.splitTextToSize(text5.text(), 180);
                        var pageHeight= doc.internal.pageSize.height;
                        y = 255;
                        for(j=0; j<splitText.length; j++)
                        {
                            if(y>=pageHeight)
                            {
                              y = 15;
                              doc.addPage();
                            }
                            else
                            {

                              y += 5;

                              doc.text(15, y, splitText[j]);

                            }
                        }

                        doc.setFontSize("14");
                        doc.addPage();
                        var textWidth = doc.getStringUnitWidth("ART. 2") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                        doc.text(textOffset, 15, "ART. 2");
                        doc.setFontSize("11");

                        var splitText = doc.splitTextToSize(text6.text(), 180);
                        var pageHeight= doc.internal.pageSize.height;
                        y = 15;
                        for(j=0; j<splitText.length; j++)
                        {
                            if(y>=pageHeight)
                            {
                              y = 15;
                              doc.addPage();
                            }
                            else
                            {

                              y += 5;

                              doc.text(15, y, splitText[j]);

                            }
                        }

                        doc.setFontSize("14");
                        var textWidth = doc.getStringUnitWidth("ART. 3") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                        doc.text(textOffset, 60, "ART. 3");
                        doc.setFontSize("11");

                        var splitText = doc.splitTextToSize(text7.text(), 180);
                        var pageHeight= doc.internal.pageSize.height;
                        y = 60;
                        for(j=0; j<splitText.length; j++)
                        {
                            if(y>=pageHeight)
                            {
                              y = 15;
                              doc.addPage();
                            }
                            else
                            {

                              y += 5;

                              doc.text(15, y, splitText[j]);

                            }
                        }

                        doc.setFontSize("14");
                        var textWidth = doc.getStringUnitWidth("ART. 4") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                        doc.text(textOffset, 180, "ART. 4");
                        doc.setFontSize("11");

                        var splitText = doc.splitTextToSize(text8.text(), 180);
                        var pageHeight= doc.internal.pageSize.height;
                        y = 180;
                        for(j=0; j<splitText.length; j++)
                        {
                            if(y>=pageHeight)
                            {
                              y = 15;
                              doc.addPage();
                            }
                            else
                            {

                              y += 5;

                              doc.text(15, y, splitText[j]);

                            }
                        }

                        doc.setFontSize("14");
                        var textWidth = doc.getStringUnitWidth("ART. 5") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                        doc.text(textOffset, 218, "ART. 5");
                        doc.setFontSize("11");

                        var splitText = doc.splitTextToSize(text9.text(), 180);
                        var pageHeight= doc.internal.pageSize.height;
                        y = 213;
                        for(j=0; j<splitText.length; j++)
                        {
                            if(y>=pageHeight)
                            {
                              y = 15;
                              doc.addPage();
                            }
                            else
                            {

                              y += 5;

                              doc.text(15, y, splitText[j]);

                            }
                        }

                        doc.setFontSize("14");
                        doc.addPage();
                        var textWidth = doc.getStringUnitWidth("ART. 6") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                        doc.text(textOffset, 15, "ART. 6");
                        doc.setFontSize("11");

                        var splitText = doc.splitTextToSize(text10.text(), 180);
                        var pageHeight= doc.internal.pageSize.height;
                        y = 15;
                        for(j=0; j<splitText.length; j++)
                        {
                            if(y>=pageHeight)
                            {
                              y = 15;
                              doc.addPage();
                            }
                            else
                            {

                              y += 5;

                              doc.text(15, y, splitText[j]);

                            }
                        }

                        doc.setFontSize("14");
                        var textWidth = doc.getStringUnitWidth("ART. 7") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                        doc.text(textOffset, 190, "ART. 7");
                        doc.setFontSize("11");

                        var splitText = doc.splitTextToSize(text11.text(), 180);
                        var pageHeight= doc.internal.pageSize.height;
                        y = 190;
                        for(j=0; j<splitText.length; j++)
                        {
                            if(y>=pageHeight)
                            {
                              y = 15;
                              doc.addPage();
                            }
                            else
                            {

                              y += 5;

                              doc.text(15, y, splitText[j]);

                            }
                        }


                        doc.setFontSize("14");
                        doc.addPage();
                        var textWidth = doc.getStringUnitWidth("ART. 8") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                        doc.text(textOffset, 15, "ART. 8");
                        doc.setFontSize("11");

                        var splitText = doc.splitTextToSize(text12.text(), 180);
                        var pageHeight= doc.internal.pageSize.height;
                        y = 15;
                        for(j=0; j<splitText.length; j++)
                        {
                            if(y>=pageHeight)
                            {
                              y = 15;
                              doc.addPage();
                            }
                            else
                            {

                              y += 5;

                              doc.text(15, y, splitText[j]);

                            }
                        }

                        doc.setFontSize("14");
                        var textWidth = doc.getStringUnitWidth("ART. 9") * doc.internal.getFontSize() / doc.internal.scaleFactor;
                        var textOffset = (doc.internal.pageSize.width - textWidth) / 2;
                        doc.text(textOffset, 60, "ART. 9");
                        doc.setFontSize("11");

                        var splitText = doc.splitTextToSize(text13.text(), 180);
                        var pageHeight= doc.internal.pageSize.height;
                        y = 60;
                        for(j=0; j<splitText.length; j++)
                        {
                            if(y>=pageHeight)
                            {
                              y = 15;
                              doc.addPage();
                            }
                            else
                            {

                              y += 5;

                              doc.text(15, y, splitText[j]);

                            }
                        }
                      // Formatting table footer:
                      doc.autoTable({
                        html:footer,
                        theme:"plain",
                        styles: {

                          halign:"center",
                          fontSize: 10,
                      },
                      headStyles:
                      {
                        halign:"center"
                      },
                        startY: 100});



                      // ------------------------------


                    doc.save("convenzione_" + dateStart  + "_" + dateEnd + ".pdf");
              // ------------------------------------------------------

            }
          }
        )
      });
  }




  }







// Function deleteFiliale
function htmlDeleteFiliale()
{
  jQuery.noConflict();
  var $htmlDeleteFiliale = jQuery("#delete-filiale");
  jQuery("#DeleteFiliale").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");

    jQuery("#delete-studente").hide(500);
    jQuery("#delete-professore").hide(500);
    jQuery("#delete-azienda").hide(500);
    jQuery("#delete-filiale").hide().fadeIn(500);
    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlElimina/htmlDeleteFiliale.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success: function(data)
        {
          $htmlDeleteFiliale.html(jQuery(data).filter("#cred-input-form")).hide().fadeIn(500);
        },

        complete: function()
        {
          deleteFiliale();
          ajaxDataTables();

        }

      }
    );
  });
}


// Delete filiale:
function deleteFiliale()
{
  jQuery.noConflict();
  var idFiliale;
  var parseFiliale;
  jQuery("#submitDeleteFiliale").click(function()
  {
    idFiliale = jQuery("#codiceFiliale").val();
    parseFiliale = "";
    for(i=0; i<idFiliale.length; i++)
    {
      if(idFiliale[i] == " ")
        break;
      else
      {
        parseFiliale += idFiliale[i];
      }
    }

    var jsonFiliale = JSON.stringify(parseFiliale);
    jQuery.ajax(
      {
        type: "POST",
        url: "scriptphp/deleteScript/delete.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,
        data: {data: jsonFiliale},
        beforeSend: function()
        {
          jQuery("#show-loading-delete-filiale").empty();
          jQuery("#show-loading-delete-filiale").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");
        },
        complete: function()
        {
          jQuery("#show-loading-delete-filiale").empty();
          jQuery("#show-loading-delete-filiale").append("<i class='fa fa-edit'></i> Modifica</span>");
        }
      }
    );
  });
}



// Function htmlModificaFilialeSelectAzienda:
function htmlModificaFilialeSelectAzienda()
{
  jQuery.noConflict();
  $htmlUpdateFiliale = jQuery("#update-filiale");

  jQuery("#UpdateFiliale").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");
    jQuery("#update-studente").hide(500);
    jQuery("#update-professore").hide(500);
    jQuery("#update-azienda").hide(500);
    jQuery("#update-dipendente-values").hide(500);
    jQuery("#update-filiale-values").css("display","none");


    jQuery("#update-filiale").hide().fadeIn(300);
    jQuery("#update-dipendente").hide(500);

    jQuery.ajax(
      {
        type: "POST",
        url: "htmlphp/htmlModifica/htmlModificaFilialeSelectAzienda.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,
        success:function(data)
        {
          $htmlUpdateFiliale.html(jQuery(data).filter("#cred-input-form-upd")).hide().fadeIn(500);

        },
        complete: function()
        {
          htmlModificaFilialeSelectFiliale();
        }
      }
    );
  });
}


// Function htmlModificaFilialeSelectFiliale():
function htmlModificaFilialeSelectFiliale()
{
  jQuery.noConflict();

  var valAzienda;

  jQuery("#cntSubmitUpdateFiliale").click(function()
  {

  jQuery("#update-studente").hide(500);
  jQuery("#update-professore").hide(500);
  jQuery("#update-azienda").hide(500);
  jQuery("#update-dipendente-values").hide(500);


  jQuery("#update-filiale").hide().fadeIn(300);
  jQuery("#update-dipendente").hide(500);

      valAzienda = jQuery("#get-id-update-az-filiale").val();
      var valAziendaParsed;


      valAziendaParsed = "";
      for(i=0; i<valAzienda.length; i++)
      {
        if(valAzienda[i]==" ")
        {
          break;
        }
        else
        {

          valAziendaParsed += valAzienda[i];
        }
      }

      var jsonValAziendaParsed = JSON.stringify(valAziendaParsed);
      console.log(valAziendaParsed);
      jQuery(".disable").hide(500);
      jQuery.ajax(
        {
          type: "POST",
          url: "htmlphp/htmlModifica/htmlModificaFilialeSelectFiliale.php",
          contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
          timeout: 10000,
          data: {code_az:jsonValAziendaParsed},


          success:function(data)
          {
            $htmlUpdateFiliale.html(jQuery(data).filter("#cred-input-form-upd-filiale")).hide().fadeIn(500);
            htmlUpdateFiliale();
          },

        }
      );
  });
}

// function htmlUpdateFiliale():
function htmlUpdateFiliale()
{
  jQuery.noConflict();
  var $htmlUpdateFiliale = jQuery("#update-filiale-values");
  jQuery("#continueSubmitUpdateFiliale-2").click(function()
  {

    jQuery("#update-studente").hide(500);
    jQuery("#update-professore").hide(500);
    jQuery("#update-azienda").hide(500);

    jQuery("#update-filiale").hide(500);
    jQuery("#update-filiale-values").hide().fadeIn(300);

    jQuery("#update-dipendente").hide(500);
    jQuery("#update-dipendente-values").hide(500);



    jQuery("#disable-2").css("display", "none");

    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlModifica/htmlModificaFiliale.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success: function(data)
        {
          console.log();
          $htmlUpdateFiliale.html(jQuery(data).filter("#cred-input-form-upd-fi"));
        },
        complete:function()
        {
          updateFilialeSend();
        }
      }
    );
  });

}

// Function updateFiliale:
function updateFilialeSend()
{
  jQuery.noConflict();
  var valFiliale = [];
  var nModifiedFields = 0;
  var fieldsName  = [];
  var firstField = "id_filiale";
  var length = 0;
  var idFilialeToChange;
  jQuery.noConflict();

  jQuery("#submitUpdateFiliale").click(function()
  {
    var $nFields    =  jQuery(".form-box-update");

    length = document.querySelectorAll("#field-update-filiale").length;
    var parseFilialeToChange="";
    for(i=0; i<length; i++)
    {
      if(jQuery($nFields[i]).children().eq(1).val()!="")
      {
        fieldsName.push(jQuery($nFields[i]).children().eq(0).text());
        valFiliale.push(jQuery($nFields[i]).children().eq(1).val());
        nModifiedFields++;
      }
    }
    console.log(valFiliale);
    console.log(fieldsName);

     idFilialeToChange = jQuery("#get-select-filiale").val();
     for(i=0; i<idFilialeToChange.length; i++)
     {
       if(idFilialeToChange[i] == " ")
        break;
       else
       {

        parseFilialeToChange += idFilialeToChange[i];
       }
     }
     console.log(parseFilialeToChange);
     var jsonValFiliale = JSON.stringify(valFiliale);

     var jsonFirstField = JSON.stringify(firstField);

     var jsonFieldsName = JSON.stringify(fieldsName);

     var jsonFirstField = JSON.stringify(firstField);
     jQuery.ajax(
       {
        type: "POST",
        url: "scriptphp/updateScript/update.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,
        data: {inputValues:jsonValFiliale, firstField:jsonFirstField, nModifiedFields:nModifiedFields, code:parseFilialeToChange,primaryKeyFieldName:jsonFirstField, fieldsName:jsonFieldsName},
        beforeSend: function()
        {

        },
        complete: function()
        {
          console.log("ajax");
            nFields = 0;
            valFiliale = [];
            nModifiedFields = 0;
            fieldsName = [];
            ajaxDataTables();
        }

       }
     );
  });
}

function htmlDipendente()
{
  jQuery.noConflict();

  jQuery("#InsertDipendente").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");

    jQuery("#insert-studente").hide(500);
    jQuery("#insert-docente").hide(500);
    jQuery("#insert-azienda").hide(500);
    jQuery("#insert-dipendente").hide().fadeIn(300);
    jQuery("#insert-filiale").hide(500);
    jQuery("#insert-stage").hide(500);

    var $htmlDipendente = jQuery("#insert-dipendente");
    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlinserisci/htmlDipendente.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success:function(data)
        {
          $htmlDipendente.html(jQuery(data).filter("#cred-input-form")).hide().fadeIn(300);

        },
        complete: function()
        {
          sendInsertDipendente();
        }
      }
    );
  });
}


function sendInsertDipendente()
{

  jQuery.noConflict();

  // Array values for insert employee:
    var valuesCred, valuesDipendente;

    var nFieldCred, nFieldDip, nFieldCnt;


  // Click event: (#insertDipContinue-d)
     jQuery("#insertDipContinue-d").click(function()
     {
         // Array init:
    valuesCred       = [];

        nFieldCred = document.querySelectorAll("#field-cred-d").length;
        nFieldDip = document.querySelectorAll("#field-dip-d").length;

       for(i=0; i<nFieldCred; i++)
       {
         valuesCred.push(jQuery("#cred-d" + i).val());
       }

       // Set username for employee:
          jQuery("#input-readonly-user-d").empty();
          jQuery("#input-readonly-user-d").append("<input readonly type='text' class='form-control form-control-lg' id='da-d12' value='" + valuesCred[0] + "'>");

       jQuery(".show-first-d").hide(500);
       jQuery(".insert-show-when-pressed-d-1").hide().fadeIn(500);
     });



  // Click event: (#submitInsertDip):
     jQuery("#submitInsertDip").click(function(){
      valuesDipendente = [];

     for(i=0; i<nFieldDip; i++)
     {
       if(i==nFieldDip-2)
       {
         valuesDipendente.push(jQuery("#codeFiliale").val());
       }
       else
       {
        
           valuesDipendente.push(jQuery("#da-d" + i).val());
        
       }
     }

     console.log(valuesDipendente + "fdsaer");

     jQuery(".insert-show-when-pressed-d-1").hide(500);
     jQuery(".insert-show-when-pressed-d-2").hide().fadeIn(500);

     jQuery("#input-readonly-dip-d").append("<input readonly type='text' class='form-control form-control-lg' id='cnt-d0' value='" + valuesDipendente[0] + "'>");



        var jsonValCred     = JSON.stringify(valuesCred);
        var jsonValDip      = JSON.stringify(valuesDipendente);

        jQuery.ajax(
          {
            type: "POST",
            url: "scriptphp/insertScript/inserisciCred.php",
            contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
            timeout: 10000,
            data:{credValues:jsonValCred, nCredFields:nFieldCred},

            beforeSend: function()
            {
              jQuery("#show-loading-dip").empty();
              jQuery("#show-loading-dip").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");
            },

            complete: function()
            {
              jQuery.ajax(
                {
                  type: "POST",
                  url: "scriptphp/insertScript/inserisciDipendente.php",
                  contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
                  timeout: 10000,
                  data:{valDipendente:jsonValDip, nFieldsDipendente:nFieldDip},
                  complete: function()
                  {


                          jQuery("#show-loading-dip").empty();
                          jQuery("#show-loading-dip").append("<i class='fa fa-plus'></i> Inserisci");



                  }
                }
              );
            }
          }
        );

     });


}



function htmlFiliale()
{
  jQuery.noConflict();

  jQuery("#InsertFiliale").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");

    jQuery("#insert-studente").hide(500);
    jQuery("#insert-docente").hide(500);
    jQuery("#insert-azienda").hide(500);
    jQuery("#insert-dipendente").hide(500);
    jQuery("#insert-filiale").hide().fadeIn(300);
    jQuery("#insert-stage").hide(500);

    var $htmlFiliale = jQuery("#insert-filiale");
    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlinserisci/htmlFiliale.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success:function(data)
        {
          $htmlFiliale.html(jQuery(data).filter("#cred-input-form")).hide().fadeIn(300);

        },
        complete: function()
        {
          sendInsertFiliale();
        }
      }
    );
  });
}


function sendInsertFiliale()
{
  jQuery.noConflict();
  jQuery("#submitInsertFiliale").click(function()
  {
    var valFiliale = [];
    var nFields = document.querySelectorAll("#field-filiale-f").length;
    for(i=0; i<nFields; i++)
    {
      if(i==1)
      {
        var getCode = jQuery("#codeAzienda").val();
        var stringCode = "";

        for(j=0; j<getCode.length; j++)
        {
          if(getCode[j]==" ")
          {
            break;
          }
          else
            stringCode += getCode[j];


        }
        valFiliale.push(stringCode);
      }
      else {
        valFiliale.push(jQuery("#ff" + i).val());
      }
    }


    var jsonValFiliale = JSON.stringify(valFiliale);
    jQuery.ajax(
      {
        type: "POST",
        url: "scriptphp/insertScript/inserisciFiliale.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,
        data:{valFiliale:jsonValFiliale, nFieldsFiliale:nFields},
        beforeSend:function()
        {
          jQuery("#show-loading-insert-filiale").empty();
          jQuery("#show-loading-insert-filiale").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");
        },
        complete: function()
        {
          jQuery("#show-loading-insert-filiale").empty();
          jQuery("#show-loading-insert-filiale").append("<span><i class='fas fa-plus'></i> Inserisci</span>");

        }
      }
    );
  });


}

/*
function sendAziendaStage()
{
  jQuery.noConflict();
  var getBtnList = document.querySelectorAll("#val-azienda");
  var getNumberBtnList = getBtnList.length;


  for(i=0; i<getNumberBtnList; i++)
  {
    var btn = "#" + i;


      jQuery(btn).click(function()
      {
          var temp = this.id;


        var matricola = jQuery("#mtr" + temp).text();
        var idClasse = jQuery("#cls" + temp).text();

        var azienda = jQuery("#company-val-znd" + temp).val();


        var id = "#show-loading" + temp;
        jQuery.ajax(
          {
            type: "POST",
            url: "scriptphp/stageScript/insertAziendaStage.php",
            contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
            timeout: 10000,
            data:{matricola:matricola, idClasse:idClasse, azienda:azienda},
            beforeSend:function()
            {
              jQuery(id).empty();
              jQuery(id).append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");
            },
            complete: function()
            {
              jQuery("#removed" + temp).empty();
              jQuery("#company-field" + temp).append(azienda);

            }
          }
        )
      });


  }

}

*/
function htmlStudente()
{
  jQuery.noConflict();

  jQuery("#insertStudente").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");

    jQuery("#insert-studente").hide().fadeIn(300);
    jQuery("#insert-docente").hide(500);
    jQuery("#insert-azienda").hide(500);
    jQuery("#insert-dipendente").hide(500);
    jQuery("#insert-filiale").hide(500);
    jQuery("#insert-stage").hide(500);

    var $htmlStudente = jQuery("#insert-studente");
    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlinserisci/htmlStudente.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success:function(data)
        {
          $htmlStudente.html(jQuery(data).filter("#cred-input-form")).hide().fadeIn(300);

        },
        complete: function()
        {
          sendInsertStudenti();
        }
      }
    );
  });


}

function htmlDocente()
{
  jQuery.noConflict();
  jQuery("#InsertProfessore").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");

    jQuery("#insert-studente").hide(500);
    jQuery("#insert-docente").hide().fadeIn(300);
    jQuery("#insert-azienda").hide(500);
    jQuery("#insert-stage").hide(500);
    jQuery("#insert-dipendente").hide(500);
    jQuery("#insert-filiale").hide(500);

    var $htmlProfessore = jQuery("#insert-docente");
    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlinserisci/htmlDocente.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success:function(data)
        {
          $htmlProfessore.html(jQuery(data).filter("#cred-input-form")).hide().fadeIn(300);

        },
        complete: function()
        {
          sendInsertDocenti();

        }
      }
    );
  });


}
function htmlAzienda()
{


  jQuery.noConflict();

  jQuery("#InsertAzienda").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");

    jQuery("#insert-studente").hide(500);
    jQuery("#insert-docente").hide(500);
    jQuery("#insert-azienda").hide().fadeIn(300);
    jQuery("#insert-stage").hide(500);
    jQuery("#insert-dipendente").hide(500);
    jQuery("#insert-filiale").hide(500);
    var $htmlAzienda = jQuery("#insert-azienda");
    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlinserisci/htmlAzienda.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success:function(data)
        {
          $htmlAzienda.html(jQuery(data).filter("#cred-input-form")).hide().fadeIn(300);

        },
        complete: function()
        {
          sendInsertAz();

        }
      }
    );
  });


}


function htmlStage()
{
  jQuery.noConflict();
  jQuery("#InsertPeriodoStage").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");

    jQuery("#insert-studente").hide(500);
    jQuery("#insert-docente").hide(500);
    jQuery("#insert-azienda").hide(500);
    jQuery("#insert-stage").hide().fadeIn(300);
    jQuery("#insert-dipendente").hide(500);
    jQuery("#insert-filiale").hide(500);


    var $htmlStage = jQuery("#insert-stage");
    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlinserisci/htmlStage.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success:function(data)
        {
          $htmlStage.html(jQuery(data).filter("#cred-input-form")).hide().fadeIn(300);

        },
        complete: function()
        {
          submitInsertStage();

        }
      }
    );
  });
}


function htmlDeleteStudente()
{
  jQuery.noConflict();
  jQuery("#DeleteStudente").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");

    jQuery("#delete-studente").hide().fadeIn(300);
    jQuery("#delete-professore").hide(500);
    jQuery("#delete-azienda").hide(500);
    jQuery("#delete-filiale").hide(500);

    var $htmlDeleteStudente = jQuery("#delete-studente");
    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlElimina/htmlDeleteStudente.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success:function(data)
        {
          $htmlDeleteStudente.html(jQuery(data).filter("#cred-input-form")).hide().fadeIn(300);

        },
        complete: function()
        {

          sendDelete();


        }
      }
    );
  });
}

function htmlDeleteProfessore()
{
  jQuery.noConflict();
  jQuery("#DeleteProfessore").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");

    jQuery("#delete-studente").hide(500)
    jQuery("#delete-professore").hide().fadeIn(300);
    jQuery("#delete-azienda").hide(500);
    jQuery("#delete-filale").hide(500);

    var $htmlDeleteDocente = jQuery("#delete-professore");
    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlElimina/htmlDeleteProfessore.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success:function(data)
        {
          $htmlDeleteDocente.html(jQuery(data).filter("#cred-input-form")).hide().fadeIn(300);

        },
        complete: function()
        {
          sendDeleteProfessor();
        }
      }
    );
  });
}

function htmlDeleteAzienda()
{
  jQuery.noConflict();
  jQuery("#DeleteAzienda").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");

    jQuery("#delete-studente").hide(500);
    jQuery("#delete-professore").hide(500);
    jQuery("#delete-azienda").hide().fadeIn(300);

    jQuery("#delete-filiale").hide(500);

    var $htmlDeleteAzienda = jQuery("#delete-azienda");
    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlElimina/htmlDeleteAzienda.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success:function(data)
        {
          $htmlDeleteAzienda.html(jQuery(data).filter("#cred-input-form")).hide().fadeIn(300);

        },
        complete: function()
        {
          sendDeleteAzienda();
        }
      }
    );
  });
}

function htmlUpdateStudenti()
{
  jQuery.noConflict();
  jQuery("#UpdateStudente").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");

    jQuery("#update-studente").hide().fadeIn(300);
    jQuery("#update-professore").hide(500);
    jQuery("#update-azienda").hide(500);
    jQuery("#update-dipendente-values").hide(500);


    jQuery("#update-filiale").hide(500);
    jQuery("#update-dipendente").hide(500);

    var $htmlUpdateStudente = jQuery("#update-studente");
    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlModifica/htmlModificaStudente.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success:function(data)
        {
          $htmlUpdateStudente.html(jQuery(data).filter("#cred-input-form")).hide().fadeIn(300);

        },
        complete: function()
        {
          sendUpdateStudente();
        }
      }
    );
  });
}


function htmlUpdateProfessore()
{
  jQuery.noConflict();
  jQuery("#UpdateProfessore").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");

    jQuery("#update-studente").hide(500);
    jQuery("#update-professore").hide().fadeIn(300);
    jQuery("#update-azienda").hide(500);
    jQuery("#update-filiale").hide(500);
    jQuery("#update-dipendente").hide(500);
    jQuery("#update-dipendente-values").hide(500);
    jQuery("#update-filiale-values").css("display","none");



    var $htmlUpdateProfessore = jQuery("#update-professore");
    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlModifica/htmlModificaProfessore.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success:function(data)
        {
          $htmlUpdateProfessore.html(jQuery(data).filter("#cred-input-form")).hide().fadeIn(300);

        },
        complete: function()
        {
          sendUpdateProfessore();
        }
      }
    );
  });
}

function htmlUpdateAzienda()
{
  jQuery.noConflict();
  jQuery("#UpdateAzienda").click(function()
  {
    jQuery('#cred-input-form').trigger("reset");

    jQuery("#update-studente").hide(500);
    jQuery("#update-professore").hide(500);
    jQuery("#update-azienda").hide().fadeIn(500);
    jQuery("#update-filiale").hide(500);
    jQuery("#update-dipendente").hide(500);
    jQuery("#update-dipendente-values").hide(500);
    jQuery("#update-filiale-values").css("display","none");


    var $htmlUpdateAzienda = jQuery("#update-azienda");
    jQuery.ajax(
      {
        type: "GET",
        url: "htmlphp/htmlModifica/htmlModificaAzienda.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,

        success:function(data)
        {
          $htmlUpdateAzienda.html(jQuery(data).filter("#cred-input-form")).hide().fadeIn(300);

        },
        complete: function()
        {
          sendUpdateAzienda();
        }
      }
    );
  });
}


// Call the dataTables jQuery plugin
function ajaxDataTables()
{

    jQuery.noConflict();
    var $html;
    var $tableStudent= jQuery("#studenti-data");
    var $tableDocenti = jQuery("#docenti-data");
    var $tableAziende = jQuery("#aziende-data");

    jQuery.ajax(
    {
        type: "GET",
        url: "scriptphp/createTableScript/createTableData.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,
        beforeSend: function()
        {
            jQuery("#show-message-ajax").append("<div id='load'><i>Caricamento...</i><i class='fas fa-spinner  fa-spin '></i></div>");
            jQuery("#show-message-ajax-docenti").append("<div id='load-docenti'><i>Caricamento...</i><i class='fas fa-spinner  fa-spin '></i></div>");
            jQuery("#show-message-ajax-aziende").append("<div id='load-aziende'><i>Caricamento...</i><i class='fas fa-spinner  fa-spin '></i></div>");

        },
        complete: function()
        {
          jQuery("#load").remove();
          jQuery("#load-docenti").remove();
          jQuery("#load-aziende").remove();

          jQuery('#dataTableStudenti').DataTable();

          jQuery('#dataTableDocenti').DataTable();
          jQuery('#dataTableAziende').DataTable();
          jQuery('#dataTableStage').DataTable();

        },
        success: function(data)
        {
            $html = jQuery(data);
            console.log($html.filter("#tab-student"))
            $tableStudent.html($html.filter("#tab-student")).hide().fadeIn(1000);

            $tableDocenti.html($html.filter("#tab-docenti")).hide().fadeIn(1000);
            $tableAziende.html($html.filter("#tab-aziende")).hide().fadeIn(1000);
        }
    });
}





function sendInsertStudenti()
{

  jQuery.noConflict();

  var valuesCredential = [];

  var values = [];

  var valuesClass = [];

  var valuesYear = [];


  var nfield, nFieldsCred, nValuesClass, nValuesYear;

  var matricola;

      jQuery("#insertStudentContinue").click(function()
      {

        nfield = 0;
        nFieldsCred= 0;
        nValuesClass= 0;
        nValuesYear= 0;

          jQuery("#input-readonly").empty();
           valuesCredential = [];

           values = [];

           valuesClass = [];

           valuesYear = [];

          nFieldsCred = document.querySelectorAll("#field").length;

          for(i=0; i<nFieldsCred; i++)
          {
            if(jQuery("#" + i).val() != "" || jQuery("#" + i).val() != null )
            {
              valuesCredential.push(jQuery("#" + i).val());

            }
          }




          jQuery('.insert-show-when-pressed').hide().fadeIn(300);
          jQuery('.show-first').hide(500);


            jQuery("#input-readonly").append("<input type='text' class='form-control form-control-lg' id='s13' readonly value='" +  valuesCredential[0] + "'>");




      });

      jQuery("#insertStudentContinue2").click(function()
      {
        console.log(nFieldsCred);
        valuesClass = [];
        nValuesClass = document.querySelectorAll("#field-class").length;

        for(i=0; i<nValuesClass-1; i++)
        {
          valuesClass.push(jQuery("#c" + i).val());
        }

        valuesClass.push(jQuery("#class-address").val());


        jQuery('.insert-show-when-pressed2').hide().fadeIn(300);
        jQuery('.insert-show-when-pressed').hide(500);






      });

      jQuery("#insertStudentContinue3").click(function()
      {

        nfield = document.querySelectorAll("#field-values").length;
        console.log(nfield);
        for(i=0; i<nfield; i++)
        {
          values.push(jQuery("#s" + i).val());
          console.log("#s" + i);
        }





        matricola = values[0];
        console.log("matricola: " + matricola);
        jQuery('.insert-show-when-pressed3').hide().fadeIn(30);
        jQuery('.insert-show-when-pressed2').hide(50);
        jQuery("#input-readonly-matr").append("<input type='text' class='form-control form-control-lg' id='sc0' readonly value='" +  matricola + "'>");


      });


      jQuery("#submitInsertStudent").click(function()
      {
        var jsonValuesCredential = JSON.stringify(valuesCredential);
        valuesYear = [];


        nValuesYear = document.querySelectorAll("#field-year").length;
        for(i=0; i<nValuesYear; i++)
        {
          valuesYear.push(jQuery("#sc" + i).val());
        }





        var jsonValues = JSON.stringify(values);
        var jsonClass = JSON.stringify(valuesClass);
        var jsonYear = JSON.stringify(valuesYear);
        jQuery.ajax({
          type: "POST",
              url: "scriptphp/insertScript/inserisciCred.php",
              contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
              timeout: 10000,
              data: {credValues: jsonValuesCredential, nCredFields: nFieldsCred},

          beforeSend:function()
          {
            jQuery("#show-loading").empty();
            jQuery("#show-loading").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");
          },
          complete:function(){
            jQuery.ajax({
              type: "POST",
              url: "scriptphp/insertScript/inserisciStClass.php",
              contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
              timeout: 10000,
              data:{valuesClass: jsonClass, nValuesClass: nValuesClass},
              complete:function()
              {
                jQuery.ajax({
                  type: "POST",
                  url: "scriptphp/insertScript/inserisciStudente.php",
                  contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
                  timeout: 10000,
                  data: {values: jsonValues, nValuesFields: nfield},
                  complete: function()
                  {
                    jQuery.ajax({
                      type: "POST",
                      url: "scriptphp/insertScript/inserisciStudenteClasse.php",
                      contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
                      timeout: 10000,
                      data: {valuesYear: jsonYear, nValuesYear: nValuesYear},
                      complete: function()
                      {
                        ajaxDataTables();
                      }
                    });
                  }



            });

          },

            });

            jQuery("#show-loading").empty();
            jQuery("#show-loading").append("<i class='fa fa-plus'></i> Inserisci</span>");
            values = [];
            valuesCredential = [];
            valuesClass = [];


            nFieldsCred = 0;
            nFieldsValues = 0;
            nValuesClass = 0;


            jQuery('.insert-show-when-pressed').hide(500);
            jQuery('.insert-show-when-pressed2').hide(500);
            jQuery('.insert-show-when-pressed3').hide(500);

            jQuery('.show-first').hide(500);

            jQuery('#cred-input-form').trigger("reset");

            ajaxDataTables();


          }


        })

      });





}


function sendInsertDocenti()
{


  jQuery.noConflict();


  var valuesE = [];

  var nFieldsValues, nFieldsCred;

  var valuesCredentialProf = [];

  var fieldsUsername;

      jQuery("#insertProfessorContinue").click(function()
      {

         valuesE = [];

         nFieldsValues=0
         nFieldsCred=0;
         fieldsUsername = "";



         valuesCredentialProf = [];
          jQuery("#input-readonly-prof").empty();


          nFieldsCred = document.querySelectorAll("#field-doc-ins").length;
          console.log(nFieldsCred);

          for(i=0; i<nFieldsCred; i++)
          {
            valuesCredentialProf.push(jQuery("#prof" + i).val());
          }


          fieldsUsername = nFieldsValues - 1;

          jQuery('.insert-show-when-pressed').hide().fadeIn(300);
          jQuery('.show-first').hide(500);


            jQuery("#input-readonly-prof").append("<input type='text' class='form-control form-control-lg' id='doc5" + "' readonly value='" +  valuesCredentialProf[0] + "'>");







      });


      jQuery("#submitInsertProfessor").click(function()
      {
        var jsonValuesCredential = JSON.stringify(valuesCredentialProf);

        nFieldsValues = document.querySelectorAll("#field-values-ins-doc").length;

        for(i=0; i<nFieldsValues; i++)
        {
          valuesE.push(jQuery("#doc" + i).val());
        }




        var jsonValues = JSON.stringify(valuesE);

        jQuery.ajax({
          type: "POST",
          url: "scriptphp/insertScript/inserisciProf.php",
          contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
          timeout: 10000,
          data: {credValues: jsonValuesCredential, values:jsonValues, nCredFields: nFieldsCred, nValFields: nFieldsValues},
          beforeSend: function()
          {
            jQuery("#show-loading").empty();
            jQuery("#show-loading").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");
          },
          complete: function()
          {
            jQuery("#show-loading").empty();
            jQuery("#show-loading").append("<i class='fa fa-plus'></i> Inserisci</span>");
            valuesE = [];
            valuesCredentialProf = [];
            nFieldsCred = 0;
            nFieldsValues = 0;

            ajaxDataTables();

            jQuery('.insert-show-when-pressed').hide(500);
            jQuery('.show-first').hide(500);

            jQuery('#cred-input-form').trigger("reset");

          }


        })

      });




}



function sendInsertAz()
{
  var valAzienda = [];

  var valFiliale = [];

  var valDipendente = [];

  var valCred = [];


  var nFieldsAzienda, nFieldsDipendente, nFieldsCred, nFieldsContatti, nFieldsFiliale;

  var idAzienda, username, idDipendente, idFiliale;

  jQuery.noConflict();

  jQuery("#insertAziendaContinue").click(function()
  {
    valAzienda = [];
    valFiliale = [];
    valCred    = [];
    valDipendente = [];
    valContatti = [];
    nFieldsAzienda = document.querySelectorAll("#field-azienda").length;
    console.log("nFieldAzienda" + nFieldsAzienda);

    for(i=0; i<nFieldsAzienda; i++)
    {
      valAzienda.push(jQuery("#a" + i).val());
    }

    console.log("valAzienda: " + valAzienda );

    idAzienda = valAzienda[0];

    jQuery("#input-readonly-azienda").append("<input type='text' class='form-control form-control-lg' readonly value='" + idAzienda + "' id='f1'>");
    jQuery(".insert-show-when-pressed").hide().fadeIn(300);

    jQuery(".show-first").hide(500);


  });

  jQuery("#insertAziendaContinue2").click(function()
  {
    nFieldsFiliale =  document.querySelectorAll("#field-filiale").length;
    console.log("nFieldsFiliale: " + nFieldsFiliale);

    for(i=0; i<nFieldsFiliale; i++)
    {
      valFiliale.push(jQuery("#f" + i).val());
    }

    idFiliale = valFiliale[0];
    console.log(idFiliale);

    jQuery("#input-readonly-filiale").append("<input type='text' class='form-control form-control-lg' readonly value='" + idFiliale + "' id='da11'>");
    jQuery(".insert-show-when-pressed2").hide().fadeIn(300);
    jQuery(".insert-show-when-pressed").hide(500);


  })



  jQuery("#insertAziendaContinue3").click(function()
  {
    nFieldsCred =  document.querySelectorAll("#field-cred").length;
    console.log("nFieldsCred: " + nFieldsCred);

    for(i=0; i<nFieldsCred; i++)
    {
      valCred.push(jQuery("#cred" + i).val());
    }

    username = valCred[0];
    console.log(username);
    console.log(valCred);

    jQuery("#input-readonly-user").append("<input type='text' class='form-control form-control-lg' readonly value='" + username + "' id='da12'>");

    jQuery(".insert-show-when-pressed3").hide().fadeIn(300);
    jQuery(".insert-show-when-pressed2").hide(500);


  })



  jQuery("#submitInsertAz").click(function()
  {
    nFieldsDipendente =  document.querySelectorAll("#field-dip").length;

    for(i=0; i<nFieldsDipendente; i++)
    {
      valDipendente.push(jQuery("#da" + i).val());
      console.log("vaDipendente:" +valDipendente);
    }

    idDipendente = valDipendente[0];


    jQuery(".insert-show-when-pressed4").hide().fadeIn(300);
    jQuery(".insert-show-when-pressed3").hide(500);




    var jsonAzienda = JSON.stringify(valAzienda);
    var jsonFiliale = JSON.stringify(valFiliale);
    var jsonCredent = JSON.stringify(valCred);
    var jsonDipende = JSON.stringify(valDipendente);

    jQuery.ajax(
      {
        type: "POST",
        url: "scriptphp/insertScript/inserisciAzienda.php",
        contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
        timeout: 10000,
        data: {valAzienda:jsonAzienda, nFieldsAzienda:nFieldsAzienda},

        beforeSend: function()
        {
          jQuery("#show-loading").empty();
          jQuery("#show-loading").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");
        },

        complete: function()
        {
          jQuery.ajax(
            {
              type: "POST",
              url: "scriptphp/insertScript/inserisciFiliale.php",
              contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
              timeout: 10000,
              data: {valFiliale:jsonFiliale, nFieldsFiliale:nFieldsFiliale},

              complete: function()
              {
                jQuery.ajax(
                  {
                    type: "POST",
                    url: "scriptphp/insertScript/inserisciCred.php",
                    contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
                    timeout: 10000,
                    data: {credValues:jsonCredent, nCredFields: nFieldsCred},

                    complete:function()
                    {
                      jQuery.ajax(
                        {
                          type: "POST",
                          url: "scriptphp/insertScript/inserisciDipendente.php",
                          contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
                          timeout: 10000,
                          data: {valDipendente:jsonDipende, nFieldsDipendente: nFieldsDipendente},

                          complete:function()
                          {


                                  ajaxDataTables();

                                  jQuery("#show-loading").empty();
                                  jQuery("#show-loading").append("<i class='fa fa-plus'></i> Inserisci</span>");
                                  valAzienda = [];
                                  valFiliale = [];
                                  valCred    = [];
                                  valDipendente = [];
                                  jQuery(".insert-show-when-pressed4").hide(500);
                                  jQuery('#cred-input-form').trigger("reset");




                          }

                        }
                      );



                    }
                  }
                );
              }
            }
          );
        },
      }
    );

  });


}

function submitInsertStage()
{
  jQuery.noConflict();
  var nFieldsStage = document.querySelectorAll("#field-stage").length;
  var $idMessage = jQuery("#message");
  var $idMessageErr = jQuery("#message-err");

  var classCodeValue = "";
  var studentCodeVal = "";
  var profCodeVal = "";
  var dipCodeVal = "";

  var valuesStage = [];

  jQuery("#continueInsertPeriodiStage").click(function()
  {


   var stringClassCode = jQuery("#class-code").val();
   for(i=0; i<stringClassCode.length; i++)
   {
      if(stringClassCode[i]==" ")
      {
        break;
      }
      else
      {
        classCodeValue += stringClassCode[i];
      }
   }




   jQuery.ajax(
    {
      type: "POST",
      url: "htmlphp/htmlinserisci/selectStudent.php",
      contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
      timeout: 10000,
      data: {classCode: classCodeValue},
      beforeSend: function(){
        jQuery("#show-loading").empty();
        jQuery("#show-loading").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");
      },
      complete: function(){

          ajaxDataTables();

        jQuery("#show-loading").empty();
        jQuery("#show-loading").append("<i class='fa fa-plus'></i> Inserisci</span>");
        jQuery(".form-box-insert-studenti").hide().fadeIn(300);
        jQuery("#continueInsertPeriodiStage").hide(500);
        jQuery(".display-prof").hide().fadeIn(500);
      },

      success: function(data)
      {
        var $displayStudent= jQuery("#display-student");

        $displayStudent.html(jQuery(data).filter("#student-code")).hide().fadeIn(1000);
      }

    }
    );
  });

 jQuery("#submitInsertPeriodiStage").click(function(){
   for(i=0; i<nFieldsStage-4; i++)
   {
     valuesStage.push(jQuery("#stg" + i).val());
   }

   var stringStudentCode = jQuery("#student-code-val").val();

   var stringProfCode = jQuery("#professor-code").val();

   var stringDipCode = jQuery("#employee-code").val();

   for(i=0; i<stringDipCode.length; i++)
   {
     if(stringDipCode[i]==" ")
     {
       break;
     }
     else
     {
       dipCodeVal += stringDipCode[i];
     }
   }

   for(i=0; i<stringStudentCode.length; i++)
   {
      if(stringStudentCode[i]==" ")
      {
        break;
      }
      else
      {
        studentCodeVal += stringStudentCode[i];
      }
   }

   for(i=0; i<stringProfCode.length; i++)
   {
      if(stringProfCode[i]==" ")
      {
        break;
      }
      else
      {
        profCodeVal += stringProfCode[i];
      }
   }




   valuesStage.push(classCodeValue);


   valuesStage.push(studentCodeVal);

   valuesStage.push(profCodeVal);
   valuesStage.push(dipCodeVal);


   var jsonValuesStage = JSON.stringify(valuesStage);

   jQuery.ajax(
     {
       type: "POST",
       url: "scriptphp/insertScript/inserisciPeriodoStage.php",
       contentType: "application/x-www-form-urlencoded;charset=ISO-8859-15",
       timeout: 10000,
       data: {nFieldsStage:nFieldsStage, valuesStage: jsonValuesStage},
       beforeSend: function(){
         jQuery("#show-loading-insert-stage").empty();
         jQuery("#show-loading-insert-stage").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");
       },
       complete: function(){
         jQuery("#show-loading-insert-stage").empty();
         jQuery("#show-loading-insert-stage").append("<i class='fa fa-plus'></i> Inserisci</span>");
         jQuery(".show-first").hide(500);
         valuesStage = [];
       },

     }
   );
  }
);





}

  function sendDelete()
  {
    jQuery.noConflict();

    var $displayError= jQuery("#display-error");
    var $displaySuccess = jQuery('#display-success');

    $displayError.empty();
    $displaySuccess.empty();
  jQuery("#submitDeleteStudent").click(function(){
      var value = jQuery("#studenteMatricola").val();
      var jsonData = JSON.stringify(value);
      jQuery.ajax(
        {
            type: "POST",
            url: "scriptphp/deleteScript/delete.php",
            timeout:10000,
            data:{data:jsonData},
            beforeSend: function()
            {
                jQuery("#show-loading").empty();
                jQuery("#show-loading").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");

            },
            complete: function()
            {
                jQuery("#show-loading").empty();
                jQuery("#show-loading").append("<i class='fa fa-trash'></i> Elimina</span>");

                value = "";
            },

            success: function(data)
            {



              $displayError.html(jQuery(data).filter("#nf")).hide().fadeIn(1000);
              $displaySuccess.html(jQuery(data).filter("#success")).hide().fadeIn(1000);

              if($displaySuccess.text()!=null)
                ajaxDataTables();
            },

            error: function()
            {
                jQuery("#show-loading").append("Errore Timeout");
            }
        }
      )
    })

}

function sendDeleteProfessor()
{
  jQuery.noConflict();
  var $displayError= jQuery("#display-error");
  var $displaySuccess = jQuery('#display-success');

  $displayError.empty();
  $displaySuccess.empty();

    jQuery("#submitDeleteProfessor").click(function(){
      var value = jQuery("#codiceDocente").val();
      var jsonData = JSON.stringify(value);

      jQuery.ajax(
        {
            type: "POST",
            url: "scriptphp/deleteScript/delete.php",
            timeout:10000,
            data:{data:jsonData},
            beforeSend: function()
            {
                jQuery("#show-loading").empty();
                jQuery("#show-loading").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");

            },
            success: function(data)
            {


               $displayError.html(jQuery(data).filter("#nf")).hide().fadeIn(1000);
              $displaySuccess.html(jQuery(data).filter("#success")).hide().fadeIn(1000);
              if($displaySuccess.text()!=null)
                ajaxDataTables();
            },
            complete: function()
            {
                jQuery("#show-loading").empty();
                jQuery("#show-loading").append("<i class='fa fa-trash'></i> Elimina</span>");

                value = "";
            },
            error: function()
            {
                jQuery("#show-loading").append("Errore Timeout");
            }
        }
      )
    })

  }
  function sendDeleteAzienda()
  {
    jQuery.noConflict();
    var $displayError= jQuery("#display-error");
    var $displaySuccess = jQuery('#display-success');

    $displayError.empty();
    $displaySuccess.empty();
    jQuery("#submitDeleteAzienda").click(function(){
      var value = jQuery("#codiceAzienda").val();
      var jsonData = JSON.stringify(value);
      console.log(jsonData);
      jQuery.ajax(
        {
            type: "POST",
            url: "scriptphp/deleteScript/delete.php",
            timeout:10000,
            data:{data:jsonData},
            beforeSend: function()
            {
                jQuery("#show-loading").empty();
                jQuery("#show-loading").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");

            },
            success: function(data)
            {
               var $displayError= jQuery("#display-error");
               var $displaySuccess = jQuery('#display-success');
               $displayError.empty();
               $displaySuccess.empty();
               $displayError.html(jQuery(data).filter("#nf")).hide().fadeIn(1000);
              $displaySuccess.html(jQuery(data).filter("#success")).hide().fadeIn(1000);
              if($displaySuccess.text()!=null)
                ajaxDataTables();
            },
            complete: function()
            {
                jQuery("#show-loading").empty();
                jQuery("#show-loading").append("<i class='fa fa-trash'></i> Elimina</span>");
                value = "";

            },
            error: function()
            {
                jQuery("#show-loading").append("Errore Timeout");
            }
        }
      )
    });


  }


function sendUpdateStudente()
{


  jQuery.noConflict();
  var fieldsName = [];
  var inputValues = [];
  var nModifiedFields = 0;
  var $inputBox = jQuery(".form-box");
  var inputBoxLength = document.querySelectorAll("#input-box").length;

  var studentCode;
  var studentCodeParse = "";

  jQuery("#updateContinue").click(function()
  {

    studentCode = jQuery("#codiceStudenteUpdate").val();
    jQuery(".show-when-pressed").fadeIn(500);
    jQuery(".show-first").css("display", "none");


  })

  jQuery("#submitUpdateStudent").click(function()
  {

    for(i=0; i<studentCode.length; i++)
    {
      if(studentCode[i]!=" ")
        studentCodeParse += studentCode[i];
      else {
        break;
      }
    }


    var studentPrimaryKeyFieldName = "Matricola";
    for(i=0; i<inputBoxLength; i++)
    {
      if(jQuery($inputBox[i]).children().eq(1).val()!="")
      {
        fieldsName.push(jQuery($inputBox[i]).children().eq(0).text());
        inputValues.push(jQuery($inputBox[i]).children().eq(1).val());
        nModifiedFields++;
      }
    }
    var jsonFieldsName = JSON.stringify(fieldsName);
    var jsonInputValues = JSON.stringify(inputValues);

    var jsonPrimaryKeyFieldName =  JSON.stringify(studentPrimaryKeyFieldName);
    jQuery.ajax({
      type: "POST",
      url: "scriptphp/updateScript/update.php",
      data: {fieldsName:jsonFieldsName, inputValues:jsonInputValues, nModifiedFields: nModifiedFields, code: studentCodeParse, primaryKeyFieldName: jsonPrimaryKeyFieldName},
      timeout:10000,
        beforeSend: function()
        {

          jQuery("#show-loading-modifica-studente").empty();
          jQuery("#show-loading-modifica-studente").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");


        },
        success: function(data)
        {
          var $displayError= jQuery("#display-error-update");
          var $displaySuccess = jQuery('#display-success-update');
          $displayError.html(jQuery(data).filter("#error-update")).hide().fadeIn(1000);
          $displaySuccess.html(jQuery(data).filter("#success-update")).hide().fadeIn(1000);
          if($displaySuccess.text()!=null)
            ajaxDataTables();
        },
        complete: function()
        {
              jQuery("#show-loading-modifica-studente").empty();
              jQuery("#show-loading-modifica-studente").append("<i class='fa fa-edit'></i> Modifica</span>");
              fieldsName = [];
              inputValues = [];
              nModifiedFields = 0;

        },

    })

  });

}
function sendUpdateProfessore()
{
  jQuery.noConflict();
  var professorCodeParse = "";
  var fieldsNameProf = [];
  var inputValuesProf = [];
  var nModifiedFieldsProf = 0;

  var $inputBoxProf = jQuery(".form-box-update-prof");

  var inputBoxLengthProf;

  jQuery("#updateContinuePr").click(function()
  {
    jQuery(".show-when-pressed").fadeIn(500);
    jQuery(".show-first").css("display", "none");

  });





  jQuery("#submitUpdateProfessor").click(function()
  {
    fieldsNameProf = [];
    inputValuesProf = [];
    nModifiedFieldsProf = 0;
    inputBoxLengthProf = document.querySelectorAll("#input-box-update-prof").length;
    console.log(inputBoxLengthProf);
    professorCode = jQuery("#codiceProfessoreUpdate").val();
    console.log(professorCode);

        for(i=0; i<professorCode.length; i++)
        {
          if(professorCode[i]!=" ")
            professorCodeParse += professorCode[i];
          else {
            break;
          }
        }
    var professorPrimaryKeyFieldName = "Id_Docente";
    var professorCode = jQuery("#codiceProfessoreUpdate").val();
    for(i=0; i<inputBoxLengthProf; i++)
    {
      if(jQuery($inputBoxProf[i]).children().eq(1).val()!="")
      {
        fieldsNameProf.push(jQuery($inputBoxProf[i]).children().eq(0).text());
        inputValuesProf.push(jQuery($inputBoxProf[i]).children().eq(1).val());
        nModifiedFieldsProf++;
      }
    }
    var jsonFieldsName = JSON.stringify(fieldsNameProf);
    var jsonInputValues = JSON.stringify(inputValuesProf);

    var jsonPrimaryKeyFieldName =  JSON.stringify(professorPrimaryKeyFieldName);
    jQuery.ajax({
      type: "POST",
      url: "scriptphp/updateScript/update.php",
      data: {fieldsName:jsonFieldsName, inputValues:jsonInputValues, nModifiedFields: nModifiedFieldsProf, code: professorCodeParse, primaryKeyFieldName: jsonPrimaryKeyFieldName},
      timeout:10000,
        beforeSend: function()
        {

          jQuery("#show-loading-update-professor").empty();
          jQuery("#show-loading-update-professor").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");


        },
        success: function(data)
        {
          var $displayError= jQuery("#display-error-update");
          var $displaySuccess = jQuery('#display-success-update');
          $displayError.html(jQuery(data).filter("#error-update")).hide().fadeIn(1000);
          fieldsNameProf = [];
              inputValuesProf = [];
              nModifiedFieldsProf = 0;
          $displaySuccess.html(jQuery(data).filter("#success-update")).hide().fadeIn(1000);
          if($displaySuccess.text()!=null)
            ajaxDataTables();
        },
        complete: function()
        {
              jQuery("#show-loading-update-professor").empty();
              jQuery("#show-loading-update-professor").append("<span><i class='fa fa-edit'></i> Modifica</span>");
              fieldsNameProf = [];
              inputValuesProf = [];
              nModifiedFieldsProf = 0;

        },

    })

  });

}

function sendUpdateAzienda()
{
  jQuery.noConflict();


  var $inputBoxAz = jQuery(".form-box-update-az");

  var aziendaPrimaryKeyFieldName = "Id_Azienda ";
  var aziendaCode;
  var idparse;
  var inputBoxLengthAz;

  jQuery("#updateContinueAzienda").click(function()
  {
     inputBoxLengthAz = document.querySelectorAll("#input-box-update-azienda").length;

    console.log("azienda");
    var id="";
    aziendaCode = jQuery("#codiceAziendaUpdate").val();
    jQuery(".show-when-pressed").fadeIn(500);
    jQuery(".show-first").css("display", "none");
    for(i=0; i<aziendaCode.length; i++)
    {
      if(aziendaCode[i]!=" ")
      id += aziendaCode[i];
    else {
      break;
    }
    idparse=id;
    }
  });

  jQuery("#submitUpdateAz").click(function()
{
  var fieldsNameAz = [];
  var inputValuesAz = [];
  var nModifiedFieldsAz = 0;
  for(i=0; i<inputBoxLengthAz; i++)
  {
    if(jQuery($inputBoxAz[i]).children().eq(1).val()!="")
    {
      fieldsNameAz.push(jQuery($inputBoxAz[i]).children().eq(0).text());
      inputValuesAz.push(jQuery($inputBoxAz[i]).children().eq(1).val());
      nModifiedFieldsAz++;
    }
  }
  var jsonFieldsName = JSON.stringify(fieldsNameAz);
  var jsonInputValues = JSON.stringify(inputValuesAz);

  var jsonPrimaryKeyFieldName =  JSON.stringify(aziendaPrimaryKeyFieldName);
  jQuery.ajax({
    type: "POST",
    url: "scriptphp/updateScript/update.php",
    data: {fieldsName:jsonFieldsName, inputValues:jsonInputValues, nModifiedFields: nModifiedFieldsAz, code: idparse, primaryKeyFieldName: jsonPrimaryKeyFieldName},
    timeout:10000,
      beforeSend: function()
      {

        jQuery("#show-loading-azienda-update").empty();
        jQuery("#show-loading-azienda-update").append("<i class='fas fa-spinner fa-pulse spinner-size'></i>");


      },
      success: function(data)
      {
        var $displayError= jQuery("#display-error-update");
        var $displaySuccess = jQuery('#display-success-update');
        $displayError.html(jQuery(data).filter("#error-update")).hide().fadeIn(1000);
        $displaySuccess.html(jQuery(data).filter("#success-update")).hide().fadeIn(1000);
        if($displaySuccess.text()!=null)
          ajaxDataTables();
      },
      complete: function()
      {
            jQuery("#show-loading-azienda-update").empty();
            jQuery("#show-loading-azienda-update").append("<i class='fa fa-edit'></i> Modifica</span>");
            fieldsNameAz = [];
            inputValuesAz = [];
            nModifiedFieldsAz = 0;

      },

  });

});

}










function showPages()
{


  jQuery.noConflict();
  jQuery("#pagesDropdown-1").click(function(){
    jQuery(".dropdown-menu").fadeIn(500);
    jQuery("#userDropdown-small").css("display", "none");
    jQuery("#userDropdown").css("display", "none");

  });
  jQuery(".close-dropdown").click(function(){
    jQuery(".dropdown-menu").hide(500);
  });

  jQuery("#sdt").click(function(){
    jQuery(".dropdown-menu").hide(500);
  });

  jQuery("#znd").click(function(){
    jQuery(".dropdown-menu").hide(500);
  });

  jQuery("#ttr").click(function(){
    jQuery(".dropdown-menu").hide(500);
  });

  jQuery("#show-user").click(function()
  {
    jQuery("#userDropdown").fadeIn(500);
  });

  jQuery("#close-dropdown-user-option").click(function()
  {
    jQuery("#userDropdown").hide(500);
  });

  // Get the nav item list:
  jQuery('#url').each(function(){

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

          // Reset pages:
            jQuery("#delete-studente").hide(500);
            jQuery("#delete-professore").hide(500);
            jQuery("#delete-dipendente").hide(500);
            jQuery("#delete-filiale").hide(500);
            jQuery("#delete-azienda").hide(500);


            jQuery("#update-studente").hide(500);
            jQuery("#update-professore").hide(500);
            jQuery("#update-filiale").hide(500);
            jQuery("#update-filiale-values").hide(500);



            jQuery("#update-azienda").hide(500);
            jQuery("#update-filiale").hide(500);
            jQuery("#update-dipendente").hide(500);
            jQuery("#update-dipendente-values").hide(500);

            jQuery("#insert-studente").hide(500);
            jQuery("#insert-docente").hide(500);
            jQuery("#insert-azienda").hide(500);
            jQuery("#insert-filiale").hide(500);
            jQuery("#insert-dipendente").hide(500);
            jQuery("#insert-stage").hide(500);






             // Get the new link:
                 var $link = jQuery(this);

             // Get the id from the link variable:
                 var id = this.hash;


                   // Update page name dreadcumb:
                       jQuery("#page-name").empty();
                       jQuery("#page-name").text(id);

                  // If the id and the link are changed the script show the new page.
                      if(id && !$link.is('active-tab'))
                      {
                        // Disable redirect:
                            e.preventDefault();
                          // Remove add previus style for the links not active:
                              $panel.removeClass('active-tab');

                              $panel.addClass("ds-tabs");

                              $tab.removeClass('active-link');

                           // Add new style for the navbar active link and display it:
                           $panel = jQuery(id).addClass('active-tab');

                           $tab = $link.parent().addClass('active-link');

                           jQuery('.show').removeClass("show");

                 }


          });
  });
}
