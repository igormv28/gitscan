var auditorias = {

  verificar: function () {
    $("#SearchResultTable").css("display", "none");
    var $palavras_chaves = $.trim($("#palavras_chaves").val());

    var $palavras_sensitivas = $.trim($("#palavras_sensitivas").val());

    var $quantidade = $palavras_chaves.split(",").length;

    //    alert($quantidade);

    if ($palavras_chaves == "") {

      alert("Você deve digitar as palavras chaves!");

      return false;

    } else if ($quantidade > 6) {

      alert("Você deve digitar no máximo 6 palavras!");

      return false;

    } else if ($palavras_sensitivas == "") {

      alert("Você deve digitar as Sensitive Keyword!");

      return false;

    } else {

      $("form").submit();

    }


  },

  mostrar: function (contador) {

    var $conteudo = $("#marcar_" + contador).parents("tr");

    $conteudo = $conteudo.find(".code_fonte").html();

    $(".modal-body div pre").html($conteudo);

  },

  csv: function (contador) {

    var tableToExcel = (function () {

      var uri = 'data:application/vnd.ms-excel;base64,',
        template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
        base64 = function (s) {
          return window.btoa(unescape(encodeURIComponent(s)))
        },
        format = function (s, c) {
          return s.replace(/{(\w+)}/g, function (m, p) {
            return c[p];
          })
        }

      return function (table, name, fileName) {

        var $linha = $("#marcar_" + contador).parents("tr");

        var $owner = $linha.find("#owner").html();
        //        $owner = $owner.replace(/<br\s*[\/]?>/gi, "\r");

        var $repository = $linha.find("#repository").html();
        //        $repository = $repository.replace(/<br\s*[\/]?>/gi, "\r");

        var $filename = $linha.find("#filename").html();
        //        $filename = $filename.replace(/<br\s*[\/]?>/gi, "\r");

        var $codigo_fonte = $linha.find(".code_fonte").html();
        $codigo_fonte = $codigo_fonte.replace(/(?:\r\n|\r|\n)/g, '<br>');

        var re = new RegExp('class="logins"', 'g');
        $codigo_fonte_found = $codigo_fonte.replace(re, 'style="background-color:yellow;color:black"');

        var re = new RegExp('class="senhas"', 'g');
        $codigo_fonte_sensitive = $codigo_fonte.replace(re, 'style="background-color:red;color:white"');

        var $quantidade_found = $linha.find("#quantidade_found").html();
        var $quantidade_sensitive = $linha.find("#quantidade_sensitive").html();

        var $resultado = '';

        if ($quantidade_sensitive == 1) {

          $resultado = "One";

        } else if ($quantidade_sensitive >= 2 && $quantidade_sensitive <= 4) {

          $resultado = "Some";

        } else if ($quantidade_sensitive >= 5 && $quantidade_sensitive <= 9) {

          $resultado = "Multiple";

        } else if ($quantidade_sensitive >= 10 && $quantidade_sensitive <= 20) {

          $resultado = "Several";

        } else if ($quantidade_sensitive >= 21) {

          $resultado = "Numerous";

        }

        var csv = '<tr><td colspan="3" style="border:1px solid #CCC;"><span style="background-color:red;color:white;">' + $resultado + '</span>&nbsp;&nbsp;(' + $quantidade_sensitive + ') secrets were exposed in GitHub Enterprise repositories that could be accessed by any intranet user. For example: </td></tr>';

        csv += '<tr><td style="border:1px solid #CCC;background-color:blue;color:white">PASTA</td><td style="border:1px solid #CCC;background-color:blue;color:white">FILENAME</td><td style="border:1px solid #CCC;background-color:blue;color:white">SENSITIVE</td></tr>';

        csv += '<tr><td style="border:1px solid #CCC">' + $repository + '</td><td style="border:1px solid #CCC">' + $filename + '</td><td style="border:1px solid #CCC">' + $codigo_fonte_sensitive + '</td></tr>';

        csv += '<tr><td colspan="3">&nbsp;</td></tr><tr><td colspan="3" style="border:1px solid #CCC;"> <span style="background-color:yellow;color:black;">' + $quantidade_found + '</span> information found were exposed in GitHub Enterprise repositories that could be accessed by any intranet user. For example: </td></tr>';

        csv += '<tr><td style="border:1px solid #CCC">' + $repository + '</td><td style="border:1px solid #CCC">' + $filename + '</td><td style="border:1px solid #CCC">' + $codigo_fonte_found + '</td></tr>';

        if (!table.nodeType) table = document.getElementById(table)
        var ctx = {
          worksheet: name || 'Worksheet',
          table: csv
        }

        var link = document.createElement("A");
        link.href = uri + base64(format(template, ctx));
        link.download = fileName || 'Workbook.xls';
        link.target = '_blank';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

      }
    })();

    tableToExcel('table-data', 'ReportCoin', 'fileName.xls');

    //
    //      var caption = '';
    //

    //      var uri = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
    //
    //      var download_link = document.createElement('a');
    //
    //      download_link.href = uri;
    //
    //      var ts = new Date().getTime();
    //
    //      if (caption == "") {
    //        download_link.download = ts + ".csv";
    //      } else {
    //        download_link.download = caption + "-" + ts + ".csv";
    //      }
    //
    //      document.body.appendChild(download_link);
    //
    //      download_link.click();
    //
    //      document.body.removeChild(download_link);

  },

  marcarTodos: function (contador) {

    if ($("#marcarTodos:checked").val()) {

      //      $("input:checkbox").prop("checked", true);
      $("input:checkbox").attr("checked", true);

    } else {

      //      $("input:checkbox").prop("checked", false);
      $("input:checkbox").attr("checked", false);

    }

  },

  allCsvs: function () {
	  
    if ($("table tbody input:checked").length != 0) {

      //      $("input:checked").each(function () {
      //
      //        $conteudo += '"' + $(this).parents("tr").find("#code_fonte").html() + '"' + ',"' + $(this).parents("tr").find("#owner").html() + '"' + '\n';
      //
      //      });

      var tableToExcel = (function () {

        var uri = 'data:application/vnd.ms-excel;base64,',
          template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
          base64 = function (s) {
            return window.btoa(unescape(encodeURIComponent(s)))
          },
          format = function (s, c) {
            return s.replace(/{(\w+)}/g, function (m, p) {
              return c[p];
            })
          }

        return function (table, name, fileName) {

          var $csv = '';
          var $listagem1 = '';
          var $listagem2 = '';

          var $quantidade_found = 0;
          var $quantidade_sensitive = 0;

          var $quantidade_found_total = 0;
          var $quantidade_sensitive_total = 0;

          $("table tbody input:checked").each(function () {

            var $linha = $(this).parents("tr");

            var $owner = $linha.find("#owner").html();
            //        $owner = $owner.replace(/<br\s*[\/]?>/gi, "\r");

            var $repository = $linha.find("#repository").html();
            //        $repository = $repository.replace(/<br\s*[\/]?>/gi, "\r");

            var $filename = $linha.find("#filename").html();
            //        $filename = $filename.replace(/<br\s*[\/]?>/gi, "\r");

            var $codigo_fonte = $linha.find(".code_fonte").html();
            $codigo_fonte = $codigo_fonte.replace(/(?:\r\n|\r|\n)/g, '<br>');

            var re = new RegExp('class="logins"', 'g');
            $codigo_fonte_found = $codigo_fonte.replace(re, 'style="background-color:yellow;color:black"');

            var re = new RegExp('class="senhas"', 'g');
            $codigo_fonte_sensitive = $codigo_fonte.replace(re, 'style="background-color:red;color:white"');

            var $quantidade_found = parseInt($linha.find("#quantidade_found").html());
            var $quantidade_sensitive = parseInt($linha.find("#quantidade_sensitive").html());

            $quantidade_found_total += $quantidade_found;
            $quantidade_sensitive_total += $quantidade_sensitive;

            if ($quantidade_sensitive != "0") {

              $listagem1 += '<tr><td style="border:1px solid #CCC">' + $repository + '</td><td style="border:1px solid #CCC">' + $filename + '</td><td style="border:1px solid #CCC">' + $codigo_fonte_sensitive + '</td></tr>';

            }

            if ($quantidade_found != "0") {

              $listagem2 += '<tr><td style="border:1px solid #CCC">' + $repository + '</td><td style="border:1px solid #CCC">' + $filename + '</td><td style="border:1px solid #CCC">' + $codigo_fonte_found + '</td></tr>';

            }

          });

          var $resultado = '';

          if ($quantidade_sensitive_total == 1) {

            $resultado = "One";

          } else if ($quantidade_sensitive_total >= 2 && $quantidade_sensitive_total <= 4) {

            $resultado = "Some";

          } else if ($quantidade_sensitive_total >= 5 && $quantidade_sensitive_total <= 9) {

            $resultado = "Multiple";

          } else if ($quantidade_sensitive_total >= 10 && $quantidade_sensitive_total <= 20) {

            $resultado = "Several";

          } else if ($quantidade_sensitive_total >= 21) {

            $resultado = "Numerous";

          }

          $csv += '<tr><td colspan="3" style="border:1px solid #CCC;"><span style="background-color:red;color:white;">' + $resultado + '</span>&nbsp;&nbsp;(' + $quantidade_sensitive_total + ') secrets were exposed in GitHub Enterprise repositories that could be accessed by any intranet user. For example: </td></tr>';

          $csv += '<tr><td style="border:1px solid #CCC;background-color:blue;color:white">PASTA</td><td style="border:1px solid #CCC;background-color:blue;color:white">FILENAME</td><td style="border:1px solid #CCC;background-color:blue;color:white">SENSITIVE</td></tr>';

          $csv += $listagem1;

          $csv += '<tr><td colspan="3">&nbsp;</td></tr><tr><td colspan="3" style="border:1px solid #CCC;"> <span style="background-color:yellow;color:black;">' + $quantidade_found_total + '</span> information found were exposed in GitHub Enterprise repositories that could be accessed by any intranet user. For example: </td></tr>';

          $csv += '<tr><td style="border:1px solid #CCC;background-color:blue;color:white">PASTA</td><td style="border:1px solid #CCC;background-color:blue;color:white">FILENAME</td><td style="border:1px solid #CCC;background-color:blue;color:white">SENSITIVE</td></tr>';

          $csv += $listagem2;

          if (!table.nodeType) table = document.getElementById(table)
          var ctx = {
            worksheet: name || 'Worksheet',
            table: $csv
          }

          var link = document.createElement("A");
          link.href = uri + base64(format(template, ctx));
          link.download = fileName || 'Workbook.xls';
          link.target = '_blank';
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);

        }
      })();

      tableToExcel('table-data', 'ReportCoin', 'fileName.xls');


    } else {

      alert("Selecione pelo menos uma linha!");

    }

  },

  Filtrar: function () {

    if (event.keyCode == 13) {

      var $search = $.trim($("#search").val());

      $("#table-data tr .code_fonte .filtrar").each(function () {

        $(this).replaceWith($(this).html());

      });

      $("#table-data tr .code_fonte").each(function () {

        var $remover = $(this).html();

        if ($remover.toLowerCase().indexOf($search.toLowerCase()) > -1 && $search != "") {

          var re = new RegExp($search, 'g');

          $remover = $remover.replace(re, '<a class="filtrar" href="https://github.com/search?q=' + $search + '&type=' + $search + '" target="_blank">' + $search + '</a>');

          //			alert($remover);
          //			alert($search);

          $(this).html($remover);

        }

      });


    }

  },

  // Serch the Test Result
  searchTest: function() {

    $("#table-data").css("display", "none");
    var list = $.trim($("#palavras_chaves").val());
    var list_arr = list.split(",");
    list_arr.sort();
    list = String(list_arr);

    var keyword = $.trim($("#palavras_sensitivas").val());
    var keyword_arr = keyword.split(",");
    keyword_arr.sort();
    keyword = String(keyword_arr);
    
    $.ajax({
      url: "getSearchResult.php?list=" + list + "&keyword=" + keyword, 
      success: function(result){
        if (result != "") {
          var resjson = JSON.parse(result);
          
          var sens_str = "";
          var found_str = "";
          resjson.forEach(function(item) {
            var listarr = list.split(",");
            var keywordarr = keyword.split(",");

            // tbody
            var sensarr = item['fonte_sensitive'].split("||||");
            var foundarr = item['fonte_found'].split("||||");
            
            if (sensarr.length - 1 > 0) {
              sens_str += "<tr>";
              sens_str += "<td rowspan='" + sensarr.length + "'><a href='" + item['owner_link'] + "' target='_blank'>" + item['owner_name'] + "</a></td>";
              sens_str += "<td rowspan='" + sensarr.length + "'><a href='" + item['repo_link'] + "' target='_blank'>" + item['repo_name'] + "</a></td>";
              sens_str += "<td rowspan='" + sensarr.length + "'><a href='" + item['file_link'] + "' target='_blank'>" + item['file_name'] + "</a></td>";
              sens_str += "</tr>";
              for(var i=0; i<sensarr.length-1; i++) {
                sens_str += "<tr><td>" + sensarr[i] + "</td></tr>";
              }
              
            }

            
            if (foundarr.length - 1 > 0) {
              found_str += "<tr>";
              found_str += "<td rowspan='" + foundarr.length + "'><a href='" + item['owner_link'] + "' target='_blank'>" + item['owner_name'] + "</a></td>";
              found_str += "<td rowspan='" + foundarr.length + "'><a href='" + item['repo_link'] + "' target='_blank'>" + item['repo_name'] + "</a></td>";
              found_str += "<td rowspan='" + foundarr.length + "'><a href='" + item['file_link'] + "' target='_blank'>" + item['file_name'] + "</a></td>";
              found_str += "</tr>";
              for(var i=0; i<foundarr.length-1; i++) {
                found_str += "<tr><td>" + foundarr[i] + "</td></tr>";
              }
              
            }

            var sensitive_count = item['sensitive_count'];
            var found_count = item['found_count'];

            $("#fonte_sensitive_cnt").text(sensitive_count);
            $("#fonte_found_cnt").text(found_count);
          });
          
          $("#fonte_sensitive_table tbody").html(sens_str);
          $("#fonte_found_table tbody").html(found_str);

          $("#SearchResultTable").css("display", "block");
        } else {
          $("#fonte_sensitive_table tbody").html("");
          $("#fonte_found_table tbody").html("");
          $("#fonte_sensitive_cnt").html(0);
          $("#fonte_found_cnt").html(0);
        }
      }
    });
  },
  // insert in to postgresql db
  allDBs: function () {
    
    if ($("table tbody input:checked").length != 0) {

      //      $("input:checked").each(function () {
      //
      //        $conteudo += '"' + $(this).parents("tr").find("#code_fonte").html() + '"' + ',"' + $(this).parents("tr").find("#owner").html() + '"' + '\n';
      //
      //      });

      var tableToPGSQLDB = (function () {
        return function (table, name, fileName) {

          var $csv = '';
          var $listagem1 = '';
          var $listagem2 = '';

          var $quantidade_found = 0;
          var $quantidade_sensitive = 0;

          var $quantidade_found_total = 0;
          var $quantidade_sensitive_total = 0;

          $("table tbody input:checked").each(function () {

            var $linha = $(this).parents("tr");

            var $owner = $linha.find("#owner").html();
            //        $owner = $owner.replace(/<br\s*[\/]?>/gi, "\r");

            var $repository = $linha.find("#repository").html();
            //        $repository = $repository.replace(/<br\s*[\/]?>/gi, "\r");

            var $filename = $linha.find("#filename").html();
            //        $filename = $filename.replace(/<br\s*[\/]?>/gi, "\r");

            var $codigo_fonte = $linha.find(".code_fonte").html();
            $codigo_fonte = $codigo_fonte.replace(/(?:\r\n|\r|\n)/g, '<br>');

            var re = new RegExp('class="logins"', 'g');
            $codigo_fonte_found = $codigo_fonte.replace(re, 'style="background-color:yellow;color:black"');

            var re = new RegExp('class="senhas"', 'g');
            $codigo_fonte_sensitive = $codigo_fonte.replace(re, 'style="background-color:red;color:white"');

            var $quantidade_found = parseInt($linha.find("#quantidade_found").html());
            var $quantidade_sensitive = parseInt($linha.find("#quantidade_sensitive").html());

            $quantidade_found_total += $quantidade_found;
            $quantidade_sensitive_total += $quantidade_sensitive;

            var $codigo_fonte_sensitive_str = "";
            var $codigo_fonte_found_str = "";

            if ($quantidade_sensitive != "0") {

              $listagem1 += '<tr><td style="border:1px solid #CCC">' + $repository + '</td><td style="border:1px solid #CCC">' + $filename + '</td><td style="border:1px solid #CCC">' + $codigo_fonte_sensitive + '</td></tr>';

              var $arr = $codigo_fonte_sensitive.split("<br>");
                for(var i=0; i<$arr.length; i++) {
                  if ($arr[i] != "") {
                    div = document.createElement('div');
                    div.innerHTML = $arr[i];                 
                    $codigo_fonte_sensitive_str += div.innerText.trim();
                    if (i < $arr.length - 1) {
                      $codigo_fonte_sensitive_str += "||||";
                    }
                  }
                }
            }

            if ($quantidade_found != "0") {

              $listagem2 += '<tr><td style="border:1px solid #CCC">' + $repository + '</td><td style="border:1px solid #CCC">' + $filename + '</td><td style="border:1px solid #CCC">' + $codigo_fonte_found + '</td></tr>';
             
              var $arr = $codigo_fonte_found.split("<br>");
              for(var i=0; i<$arr.length; i++) {
                if ($arr[i] != "") {
                  div = document.createElement('div');
                  div.innerHTML = $arr[i];                 
                  $codigo_fonte_found_str += div.innerText.trim();
                  if (i < $arr.length - 1) {
                      $codigo_fonte_found_str += "||||";
                    }
                }
              }

              
              
            }

            var $palavras_chaves = $.trim($("#palavras_chaves").val());
            var $palavras_chaves_arr = $palavras_chaves.split(",");
            $palavras_chaves_arr.sort();
            $palavras_chaves = String($palavras_chaves_arr);
            var $palavras_sensitivas = $.trim($("#palavras_sensitivas").val());
            var $palavras_sensitivas_arr = $palavras_sensitivas.split(",");
            $palavras_sensitivas_arr.sort();
            $palavras_sensitivas = String($palavras_sensitivas_arr);
            var $owner_str = $linha.find("#owner")[0].innerText.replace("\n", "");
            var $owner_link = $linha.find("#owner")[0].parentElement.href;
            var $repository_str = $linha.find("#repository")[0].innerText.replace("\n", "");
            var $repository_link = $linha.find("#repository")[0].parentElement.href;
            var $filename_str = $linha.find("#filename").text();
            var $filename_link = $linha.find("#filename")[0].href;
            var $quantidade_found_totais = $("#quantidade_found_totais").text();
            var $quantidade_sensitive_totais = $("#quantidade_sensitive_totais").text();

            var datajson = {
              "palavras_chaves": $palavras_chaves,
              "palavras_sensitivas": $palavras_sensitivas,
              "owner_name": $owner_str,
              "owner_link": $owner_link,
              "repo_name": $repository_str,
              "repo_link": $repository_link,
              "file_name": $filename_str,
              "file_link": $filename_link,
              "fonte_sensitive": $codigo_fonte_sensitive_str,
              "fonte_found": $codigo_fonte_found_str,
              'sensitive_count': Number($quantidade_sensitive_totais),
              'found_count': Number($quantidade_found_totais)
            }
            // Save into the postgresql database
            $.ajax({
              url: "saveResultToDB.php", 
              type: "post",
              data: datajson,
              success: function(result){
                if (result == 1) {
                  console.log('The search result have been saved into database successfully!');
                } else {
                  console.log(result);
                  alert("Failed!");
                }
            }});

          });

          var $resultado = '';

          if ($quantidade_sensitive_total == 1) {

            $resultado = "One";

          } else if ($quantidade_sensitive_total >= 2 && $quantidade_sensitive_total <= 4) {

            $resultado = "Some";

          } else if ($quantidade_sensitive_total >= 5 && $quantidade_sensitive_total <= 9) {

            $resultado = "Multiple";

          } else if ($quantidade_sensitive_total >= 10 && $quantidade_sensitive_total <= 20) {

            $resultado = "Several";

          } else if ($quantidade_sensitive_total >= 21) {

            $resultado = "Numerous";

          }

          $csv += '<tr><td colspan="3" style="border:1px solid #CCC;"><span style="background-color:red;color:white;">' + $resultado + '</span>&nbsp;&nbsp;(' + $quantidade_sensitive_total + ') secrets were exposed in GitHub Enterprise repositories that could be accessed by any intranet user. For example: </td></tr>';

          $csv += '<tr><td style="border:1px solid #CCC;background-color:blue;color:white">PASTA</td><td style="border:1px solid #CCC;background-color:blue;color:white">FILENAME</td><td style="border:1px solid #CCC;background-color:blue;color:white">SENSITIVE</td></tr>';

          $csv += $listagem1;

          $csv += '<tr><td colspan="3">&nbsp;</td></tr><tr><td colspan="3" style="border:1px solid #CCC;"> <span style="background-color:yellow;color:black;">' + $quantidade_found_total + '</span> information found were exposed in GitHub Enterprise repositories that could be accessed by any intranet user. For example: </td></tr>';

          $csv += '<tr><td style="border:1px solid #CCC;background-color:blue;color:white">PASTA</td><td style="border:1px solid #CCC;background-color:blue;color:white">FILENAME</td><td style="border:1px solid #CCC;background-color:blue;color:white">SENSITIVE</td></tr>';

          $csv += $listagem2;

          if (!table.nodeType) table = document.getElementById(table);
        }
      })();

      tableToPGSQLDB('table-data', 'ReportCoin', 'fileName.xls');


    } else {

      alert("Selecione pelo menos uma linha!");

    }

  },  

};
