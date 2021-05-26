<?php
error_reporting(0);
session_start();

if (isset($_GET["client_id"]) && isset($_GET["client_secret"])) {
	require_once("oidc_config.php");
	if ($_GET["client_id"] == CLIENT_ID && $_GET["client_secret"] == CLIENT_SECRET) {
		include_once( "funcoes.php" );
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>My Search App</title>
<!-- MDB icon -->
<link rel="icon" href="./img/mdb-favicon.ico" type="image/x-icon">
<!-- Font Awesome -->
<link rel="stylesheet" href="./css/all.css">
<!-- Google Fonts Roboto -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
<!-- Bootstrap core CSS -->
<link rel="stylesheet" href="./css/bootstrap.min.css?r=<?php echo rand();?>">
<!-- Material Design Bootstrap -->
<link rel="stylesheet" href="./css/mdb.min.css?r=<?php echo rand();?>">
<!-- Your custom styles (optional) -->
<link rel="stylesheet" href="./css/style.css?r=<?php echo rand();?>">
<!-- Jquery UI-->
<link rel="stylesheet" href="./js/jquery-ui-1.12.1.custom/jquery-ui.css?r=<?php echo rand();?>">
<!-- jQuery -->
<script type="text/javascript" src="./js/jquery.min.js?r=<?php echo rand();?>"></script>
</head>
<body>
<?php

require_once( "views/topo.php" );

require_once( "views/inicio.php" );

?>
<div class="rows col-md-12" style="display: none;" id="SearchResultTable">
  <h2>The Search Result</h2>
  <p>(<span id="fonte_sensitive_cnt"></span>) secrets were exposed in GitHub Enterprise repositories that could be accessed by any intranet user. For example:</p>  
  <table class="table table-striped table-bordered" id="fonte_sensitive_table">
    <thead style="background-color: #000065; color: white;">
      <tr>
        <th width="10%">OWNER</th>
        <th width="17%">PASTA</th>
        <th width="18%">FILENAME</th>
        <th width="55%">SENSITIVE</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
  <p><span id="fonte_found_cnt"></span> information found were exposed in GitHub Enterprise repositories that could be accessed by any intranet user. For example:</p>  
  <table class="table table-striped table-bordered" id="fonte_found_table">
    <thead style="background-color: #000065; color: white;">
      <tr>
        <th width="10%">OWNER</th>
        <th width="17%">PASTA</th>
        <th width="18%">FILENAME</th>
        <th width="55%">SENSITIVE</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>
</div>
<!--- controlers -->

<!-- jQuery -->
<script type="text/javascript" src="./js/jquery.min.js?r=<?php echo rand();?>"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="./js/popper.min.js?r=<?php echo rand();?>"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="./js/bootstrap.min.js?r=<?php echo rand();?>"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="./js/mdb.min.js?r=<?php echo rand();?>"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="./js/toastr.min.js?r=<?php echo rand();?>"></script>
<!-- Jquery UI -->
<script src="./js/jquery-ui-1.12.1.custom/jquery-ui.js?r=<?php echo rand();?>"></script>
<!-- Jquery UI -->
<script src="./js/jquery.tabletoCSV.js?r=<?php echo rand();?>"></script><!-- Jquery UI -->
<script>
$(document).ready(function(){	

	var maxLength = 0;

	var textlen = $('#palavras_chaves').val().length;

	$('#rchars').text(textlen);
	
	$('#palavras_chaves').keyup(function() {

		var textlen = $(this).val().length;

		$('#rchars').text(textlen);

	});
	
	
	$('.Data').datepicker({

	clearText: 'Limpar' ,

	clearStatus: 'Limpar e retornar',

	closeText: 'Sair',

	closeStatus: 'Sair datapicker',

	prevText: 'Anterior',

	nextText: 'Proximo',

	monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],

	dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S'],

	currentText: '',  

	dateFormat: 'dd/mm/yy', firstDay: 1,

	onSelect: function (dateText, inst) {

		var $form = $(window).attr("id");

		var $id = $(this).attr("id");

		$("#"+ $form + " #"+$id).val(dateText);

//				alert("#"+ $form + " #"+$id);

		$("#"+ $form + " #"+$id).parents("div").find("label").addClass("active");

	}

	});
	
	function escapeHtml(text) {
		  var map = {
			'&': '&amp;',
			'<': '&lt;',
			'>': '&gt;',
			'"': '&quot;',
			"'": '&#039;'
		  };

		  return text.replace(/[&<>"']/g, function(m) { return map[m]; });
		}

		function htmlDecode(input) {
	  var doc = new DOMParser().parseFromString(input, "text/html");
	  return doc.documentElement.textContent;
	}
	
	$(".logins,.senhas").click(function(){
		
//		alert($(this).html());
		
		window.open('https://github.com/search?q='+$(this).html(), "_blank");
		
	});
	

});
</script>

<!-- Controllers -->
<script type="text/javascript" src="./controllers/auditorias.js?r=<?php echo rand();?>"></script>
</body>
</html>
<?php
	}
}
?>