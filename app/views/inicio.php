<?php
session_start();

function highlightStr($haystack, $needle, $highlightColorValue) {
     // return $haystack if there is no highlight color or strings given, nothing to do.
    if (strlen($highlightColorValue) < 1 || strlen($haystack) < 1 || strlen($needle) < 1) {
        return $haystack;
    }
    preg_match_all("/$needle+/i", $haystack, $matches);
    if (is_array($matches[0]) && count($matches[0]) >= 1) {
        foreach ($matches[0] as $match) {
			
            $haystack = str_replace($match, '<a class="logins"  style="background-color:'.$highlightColorValue.';" >'.$match.'</a>', $haystack);
        }
    }
    return $haystack;
}

function highlightStr2($haystack, $needle, $highlightColorValue) {
     // return $haystack if there is no highlight color or strings given, nothing to do.
    if (strlen($highlightColorValue) < 1 || strlen($haystack) < 1 || strlen($needle) < 1) {
        return $haystack;
    }
    preg_match_all("/$needle+/i", $haystack, $matches);
    if (is_array($matches[0]) && count($matches[0]) >= 1) {
        foreach ($matches[0] as $match) {
			
            $haystack = str_replace($match, '<a class="senhas"  style="background-color:'.$highlightColorValue.';" >'.$match.'</a>', $haystack);
        }
    }
    return $haystack;
}


if ( $_POST ) {

  ##################################################	
  $username = 'igormv28';
  $token = '';
  $url_principal = 'https://api.github.com/search/code?q=';
  ##################################################

  $palavras_chaves = explode( ",", $_POST[ palavras_chaves ] );

  $palavras_negativas = '+NOT+';

  $i_palavras_chaves = 0;

  foreach ( $palavras_chaves as $key_chaves => $value_chaves ) {

    if ( strpos( $value_chaves, "-" ) !== false ) {

      $palavras_negativas .= str_replace( "-", "", $value_chaves );

    } else {

      if ( $i_palavras_chaves == 0 ) {

        $palavras_positivas .= $value_chaves;

      } else {

        $palavras_positivas .= "+OR+" . urlencode( $value_chaves );

      }

      $i_palavras_chaves++;

    }

  }

  //	print_r($palavras_positivas);
  //	
  //  die();

  $palavras_sensitivas = explode( ",", $_POST[ palavras_sensitivas ] );

  //	print_r($palavras_sensitivas);

  $pesquisa_palavras = explode( "+OR+", $palavras_positivas );


  if ( $palavras_negativas == '+NOT+' ) {

    $palavras_chaves2 = $palavras_positivas;

  } else {

    $palavras_chaves2 = $palavras_positivas . $palavras_negativas;

  }


  //  $palavras_sensitivas = $_POST[ palavras_sensitivas ];

  $url = $url_principal . $palavras_chaves2 . '&type=Code&page=0&per_page=' . $_POST[ quantidade_pagina ];
  

  $url_git = 'https://github.com/search?q=' . $palavras_chaves2 . '&type=Code&page=0&per_page=' . $_POST[ quantidade_pagina ];

  echo '<a href="' . $url_git . '" target="_blank">' . $url_git . '</a>';

  $ch = curl_init();
  curl_setopt( $ch, CURLOPT_URL, $url );
  curl_setopt( $ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1' );
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 3 );
  curl_setopt( $ch, CURLOPT_USERPWD, "$username:$token" );
  $response = curl_exec( $ch );
  $data = json_decode( $response, true );
  curl_close( $ch );

  echo '<pre>';
  print_r( $data );
  print_r( $ch );
  print_r( $response );
  print_r( $url );
  print_r( $username );
  print_r( $token );
  echo '</pre>';

  $debug = $data;


  $listagem = '';
  $quantidade_found_totais = 0;
  $quantidade_sensitive_totais = 0;

  $i_contador = 1;

  foreach ( $data as $key => $value ) {

    if ( is_array( $value ) ) {

      if ( $data[ errors ][ 0 ][ message ] ) {

        foreach ( $value as $key2 => $value2 ) {

          $mensagem .= '<div type="button" class="btn btn-danger w-100">' . $data[ errors ][ $key2 ][ message ] . '</div>';

        }

      } else {

        foreach ( $value as $key2 => $value2 ) {

          $path = $value[ $key2 ][ path ];
          $full_name = $value[ $key2 ][ repository ][ full_name ];
          $owner = $value[ $key2 ][ repository ][ owner ][ login ];

          $avatar = $value[ $key2 ][ repository ][ owner ][ avatar_url ];
          $contador = $value[ $key2 ][ sha ];
          $id = $value[ $key2 ][ repository ][ id ];

          $url1 = $value[ $key2 ][ url ];


          //      echo $url1;
          //      echo '<br>';
          #1	
          $ch2 = curl_init();
          curl_setopt( $ch2, CURLOPT_URL, $url1 );
          curl_setopt( $ch2, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1' );
          curl_setopt( $ch2, CURLOPT_RETURNTRANSFER, 3 );
          curl_setopt( $ch2, CURLOPT_USERPWD, "$username:$token" );
          $response2 = curl_exec( $ch2 );
          $data2 = json_decode( $response2, true );
          curl_close( $ch2 );

          //      echo '<pre>';
          //      print_r( $data2 );
          //      echo '</pre>';

          $url2 = $data2[ download_url ];

          //      echo $url2;
          //      echo '<br>';

          #2	
          $ch3 = curl_init();
          curl_setopt( $ch3, CURLOPT_URL, $url2 );
          curl_setopt( $ch3, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1' );
          curl_setopt( $ch3, CURLOPT_RETURNTRANSFER, 3 );
          curl_setopt( $ch3, CURLOPT_USERPWD, "$username:$token" );

          $response3 = curl_exec( $ch3 );
          $response3 = htmlspecialchars( $response3 );

          curl_close( $ch3 );

          //      echo $url3;
          //      echo '<br>';

          //		echo $id."<br>";

          //                echo 'https://api.github.com/repositories/' .$id;

          //         #3	
          $ch4 = curl_init();
          curl_setopt( $ch4, CURLOPT_URL, 'https://api.github.com/repositories/' . $id );
          curl_setopt( $ch4, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10.7; rv:7.0.1) Gecko/20100101 Firefox/7.0.1' );
          curl_setopt( $ch4, CURLOPT_RETURNTRANSFER, 3 );
          curl_setopt( $ch4, CURLOPT_USERPWD, "$username:$token" );

          $response4 = curl_exec( $ch4 );
          $data4 = json_decode( $response4, true );

          curl_close( $ch4 );

          //			print_r($data4);

          //			echo "<br>".$data4[ pushed_at ];

          $pushed_at = date( "d, M, Y", strtotime( $data4[ pushed_at ] ) );


          $conteudo_novo = '';


          $conteudo = explode( PHP_EOL, $response3 );

          foreach ( $conteudo as $key3 => $value2 ) {

            $linha = '';

            $teste = 0;

            foreach ( $pesquisa_palavras as $key3 => $value3 ) {

              if ( substr_count( strtoupper( $value2 ), strtoupper( $value3 ) ) != 0 ) {

                $linha = $value2;

                $teste = 1;

              }

            }

            if ( $teste == 0 ) {

              foreach ( $pesquisa_palavras as $key3 => $value3 ) {

                if ( substr_count( strtoupper( $value2 ), strtoupper( $value3 ) ) != 0 ) {

                  $linha = $value2;

                }

              }


            }

            if ( trim( $linha ) != '' ) {

              $conteudo_novo .= "\n" . $linha . "\n";

            }

          }


          //      echo '<pre>';
          //      print_r( $conteudo_novo );
          //      echo '</pre>';
          //		
          $response3 = $conteudo_novo . "\n";

          #FOUND'S	
          $quantidade_found = 0;

          foreach ( $pesquisa_palavras as $key3 => $value3 ) {

            $quantidade_found += substr_count( strtoupper( $response3 ), strtoupper( $value3 ) );

            $quantidade_found_totais += substr_count( strtoupper( $response3 ), strtoupper( $value3 ) );

          }

          foreach ( $pesquisa_palavras as $key3 => $value3 ) {
			  
			  $response3 =  highlightStr($response3,$value3,"yellow");

          }

          $quantidade_sensitive = 0;

          #SENSITIVES
          foreach ( $palavras_sensitivas as $key4 => $value4 ) {

            $quantidade_sensitive += substr_count( strtoupper( $response3 ), strtoupper( $value4 ) );

            $quantidade_sensitive_totais += substr_count( strtoupper( $response3 ), strtoupper( $value4 ) );

          }

          foreach ( $palavras_sensitivas as $key4 => $value4 ) {

           $response3 =  highlightStr2($response3,$value3,"red");

          }


          $listagem .= '<tr>';

          $listagem .= '<td width="3%">';

          $listagem .= '<div style="width: 50px; float: left;margin-bottom:10px;">(' . $i_contador . ')</div>';

          $listagem .= '<div style="width: 50px; float: left;">';

          $listagem .= '<div style="width: 20px; float: left;">';
          $listagem .= '<input type="checkbox" id="marcar_' . $contador . '" value="' . $contador . '">';
          $listagem .= '</div>';

          $listagem .= '<div style="width: 20px; float: left;">';
          $listagem .= '<a href="#"  onClick="auditorias.csv(\'' . $contador . '\')">';
          $listagem .= '<span style="width:25px;float:left;">';
          $listagem .= '<i class="fas fa-file-csv  fa-1x" style="font-size:21px;"></i>';
          $listagem .= '</span>';
          $listagem .= '</a>';

          $listagem .= '</div>';

          $listagem .= '</td>';

          $listagem .= '<td class="coluna_fonte">';

          $listagem .= '<a href="https://github.com/' . $owner . '" target="_blank"><div style="color:green!important;font-size:12px;margin-left:23px;" id="owner">Owner:&nbsp;' . $owner . '<br></div></a>';

          $listagem .= '<a href="https://github.com/' . $full_name . '" target="_blank"><div style="color:#586069!important;font-size:12px;margin-left:23px;" id="repository"> Repository:&nbsp;' . $full_name . '<br></div></a>';

          $listagem .= '<a href="' . $url2 . '" target="_blank" id="filename"><div style="color:blue!important;font-size:16px;margin-left:23px;">File:&nbsp;' . $path . '<br></div></a>';

          $listagem .= '<span id="' . $nome_linha . '" class="line-number"></span><pre class="rounded pre_fonte"><code id="' . $nome_campo . '" class="code_fonte ' . $nome_campo . '">' . $response3 . '</code><span class="cl"></span></pre>';

          $listagem .= '<p class="mt-0 pt-1 mb-4 ml-4">';

          $listagem .= '<span style="width:220px;float:left;font-size:12px;">Found(<span id="quantidade_found">' . $quantidade_found . '</span>)(<span id="quantidade_sensitive">' . $quantidade_sensitive . '</span>)sensitive</span>';

          $listagem .= '<span style="width:200px;float:left;font-size:12px;">Last indexed on ' . $pushed_at . '</span>';

          $listagem .= '<a data-toggle="modal" data-target="#modalCart" onClick="auditorias.mostrar(\'' . $contador . '\')">';
          $listagem .= '<span style="width:25px;float:left;margin-right:40px;">';
          $listagem .= '<i class="fas fa-external-link-alt fa-1x" style="font-size:21px;"></i>';
          $listagem .= '</span>';
          $listagem .= '</a>';

          $listagem .= '</p>';

          $listagem .= '</td>';


          $listagem .= '</tr>';


          $i_contador++;

        }

      }


    }

  }


}


?>
<div class="container-fluid my-0 z-depth-0">
  <section class="dark-grey-text pl-5 pr-5">
    <div class="row">
      <div class="col-md-12 mb-lg-0 mb-4">
        <form class="" action="" method="post">
          <h5 class="font-weight-bold my-3">Count for page:</h5>
          <select id="quantidade_pagina" name="quantidade_pagina">
            <option value="3" <?php echo ($_POST[quantidade_pagina] ==3 ?  'selected' : '');?>>3</option>
            <option value="10" <?php echo (($_POST[quantidade_pagina] ==10 or $_POST[quantidade_pagina] =="")  ?  'selected' : '');?>>10</option>
            <option value="100" <?php echo ($_POST[quantidade_pagina] ==100 ?  'selected' : '');?>>100</option>
            <option value="300" <?php echo ($_POST[quantidade_pagina] ==300 ?  'selected' : '');?>>300</option>
            <option value="500" <?php echo ($_POST[quantidade_pagina] ==500 ?  'selected' : '');?>>500</option>
          </select>
          <h5 class="font-weight-bold my-3">List:</h5>
          <div class="row">
            <div class="col-md-10">
              <div class="form-group">
                <textarea class="form-control" id="palavras_chaves" name="palavras_chaves" rows="2"><?php if($_POST){ echo $_POST[palavras_chaves]; }else{ echo 'stone,rede,cielo,getnet,gerencianet,iugu';}?>
</textarea>
                <span id="rchars">0</span> Character(s)
              </div>
              <h5 class="font-weight-bold my-3">Sensitive Keyword:</h5>
              <div class="form-group">
                <textarea class="form-control" id="palavras_sensitivas" name="palavras_sensitivas" rows="2"><?php if($_POST){ echo $_POST[palavras_sensitivas]; }else{ echo 'senha,api,password';}?>
</textarea>
              </div>
            </div>
            <div class="col-md-2">
              <div class="mt-4">
                <a class="btn btn-outline-success btn-rounded rounded z-depth-1 waves-effect mt-4 black-text"  onClick="auditorias.searchTest();" role="button">
                  Test<i class="fa fa-search fa-2 ml-2"></i>
                </a>
              </div>
              <div class="mt-4">
                <a class="btn btn-outline-primary btn-rounded rounded z-depth-1 waves-effect mt-4 black-text"  onClick="auditorias.verificar();" role="button">
                  Continuar<i class="fa fa-search fa-2 ml-2"></i>
                </a>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </section>
  <?php if($_POST){ ?>
  <div class="div_continuar">
    <div class="row p-0 ">
      <table class="table mb-1" id="table-data" table-data="table-data">
        <thead class=" z-depth-0 ">
          <tr class="black-text">
          <tr class="black-text">
            <th width="150px" style="display: inline-block;"> 
              <div style="width: 20px; float: left;">
                <input id="marcarTodos" type="checkbox" value="1" onClick="auditorias.marcarTodos();">
              </div>
              <div style="width: 20px; float: left;">
                <a href="#" onClick="auditorias.allCsvs();">
                  <i class="fas fa-file-csv fa-2x"></i>
                </a>
              </div>
              <div style="float: left;">
                <a class="btn btn-sm btn-primary" onclick="auditorias.allDBs();" role="button">
                  Save
                </a>
              </div>              
            </th>
            <th class="p-2"> <div style="width: 190px; float: left;">
                Found(<span id="quantidade_found_totais"><?php echo $quantidade_found_totais;?></span>)(<span id="quantidade_sensitive_totais"><?php echo $quantidade_sensitive_totais;?></span>)sensitive
              </div>
              <div style="width: 55px; float: left; margin-top: 4px;margin-left: 10px;">
                <label>Filtering:&nbsp;&nbsp;&nbsp;</label>
              </div>
              <div style="width: 210px; float: left;margin-left: 3px;">
                <input type="search" class="form-control form-control-sm" placeholder="" id="search" name="search" aria-controls="dt-basic-checkbox" style="width: 200px;" onKeyDown="auditorias.Filtrar(event);">
              </div>
              <div style="float: right" >
                <label>
                  <a href="<?php echo $url_git;?>" class="btn btn-outline-danger btn-rounded rounded z-depth-1 waves-effect  black-text" target="_blank" role="button">
                    GIT<i class="fa fa-search fa-2 ml-2"></i>
                  </a>
                </label>
              </div>
              <div style="float: right; margin-right: 5px;" >
                <label>
                  <a href="<?php echo $url;?>" class="btn btn-outline-secondary btn-rounded rounded z-depth-1 waves-effect  black-text" target="_blank"  role="button">
                    API<i class="fa fa-search fa-2 ml-2"></i>
                  </a>
                </label>
              </div>
              <div style="float: right; margin-right: 5px;" >
                <label>
                  <a data-toggle="modal" data-target="#modalDebug" class="btn btn-outline-danger btn-rounded rounded z-depth-1 waves-effect  black-text" target="_blank"  role="button">
                    DEBUG<i class="fa fa-search fa-2 ml-2"></i>
                  </a>
                </label>
              </div>
            </th>
            <th width="255px"> </th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td colspan="2"><?php echo $mensagem;?></td>
          </tr>
          <?php echo $listagem;?>
        </tbody>
      </table>
    </div>
    <hr class="clear">
  </div>
  <br clear="all">
  <br clear="all">
  <br clear="all">
</div>
<div class="modal fade" id="modalDebug" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Debug</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12" >
          <pre style="font-size: 10px;"><?php print_r($debug);?>
			</pre>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="modalCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Codigo Fonte</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">×</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-md-12">
          <pre>
			</pre>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
<?php } ?>
