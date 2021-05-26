<?php
//developed by igormonteirovieira@gmail.com
//MONTA PÁGINAS
$url = explode( "/", $_SERVER[ "REQUEST_URI" ] );
$inicioUrl = "3";
$paginas = array();

if (isset($paginas[ "pagina" ])) {

	for ( $iUrl = 0, $jUrl = $inicioUrl + 1; $iUrl < 15; $iUrl++ ) {

	  if ( $iUrl == 0 ) {

	    $paginas[ "pagina" ] = $url[ $inicioUrl ];

	  } else if ( $iUrl != 0 and $iUrl != 1 ) {

	    $paginas[ "pagina" . $iUrl ] = $url[ "$jUrl" ];

	    $jUrl++;

	  }
	}

	extract( $paginas );
}

?>