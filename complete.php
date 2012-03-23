<!DOCTYPE html>
<html>
<head>
  <title>Bulevar Mall | La primera tienda peruana de ecommerce en Facebook</title>
  <link rel="stylesheet" type="text/css" href="http://bulevarmall.com/stylesheets/styles.css" />
  <link rel="stylesheet" type="text/css" href="http://bulevarmall.com/stylesheets/complete.css" />
  <link href="https://fonts.googleapis.com/css?family=Molengo" media="screen" rel="stylesheet" type="text/css" />
  <meta charset="utf-8" />
</head>
<body id="checkout_complete">
  <div id='global_wrapper'>
    <div id="header">
      <h1 id="logo">
        <a href="https://bulevarmall.com">Bulevar</a>
      </h1>
      <div id="header_extra">
        <ul id="my_info">
          <li id="home">
            <a href="https://bulevarmall.com/">Inicio</a>
          </li>
          <li id="share">
            Compartir:
            <a href="https://twitter.com/share?url=https://bulevarmall.com/" id="share_twitter" data-url="https://bulevarmall.com/">
              Twitter
            </a>
            <a href="https://www.facebook.com/sharer.php?u=https://bulevarmall.com/" id="share_facebook">
              Facebook
            </a>
          </li>
        </ul>
        <form accept-charset="utf-8" action="https://bulevarmall.com/search" id="search" method="get">
          <p>
            <input id="search_query" name="term" placeholder="Buscar" type="text">
            <input id="search_button" type="submit" value="">
          </p>
        </form>
      </div>
    </div>
    <div id='body'>
      <div class='block' id='check_out'>
        <div class='column' id='check_out_column'>
          <h2>Check out:</h2>
          <h3>Resultado de la operación</h3>
          <?php
            include('../vpos/vpos_plugin.php');

            $arrayIn = array();
            $arrayOut = array();

            $arrayIn['SESSIONKEY'] = $_REQUEST['SESSIONKEY'];
            $arrayIn['XMLRES'] = $_REQUEST['XMLRES'];
            $arrayIn['DIGITALSIGN'] = $_REQUEST['DIGITALSIGN'];

            $vector = "78656e64612e7065";

            $llavePublicaFirma = "file:///var/www/vpos/ALIGNET.TESTING.PHP.SIGNATURE.PUBLIC.txt";
            $llavePrivadaCifrado = "file:///var/www/vpos/BULEVAR.TESTING.CIFRADA.PRIVADA.pem";

            if(VPOSResponse($arrayIn,$arrayOut,$llavePublicaFirma,$llavePrivadaCifrado,$VI)){ 
              //$arrayOut['authorizationResult']= $resultadoAutorizacion;
              //$arrayOut['authorizationCode']= $codigoAutorizacion;

              if($arrayOut['errorCode']=='00'){
          ?>
          <h4>La transacción se realizó exitosamente</h4>
          <p>
            Gracias por comprar en Bulevar. Tu compra se ha realizado satisfactoriamente.
          </p>
          <?php
              }
              elseif($arrayOut['errorCode']=='01'){
          ?>
          <h4>No se pudo realizar la transacción</h4>
          <p>
            Lo sentimos, hubo un problema al realizar la compra, posiblemente por un problema con la tarjeta.<br />
            <a href="https://bulevarmall.com/checkout">Por favor, inténtalo nuevamente</a>.
          </p>
          <?php
              }
              elseif($arrayOut['errorCode']=='05'){
          ?>
          <h4>No se pudo realizar la transacción</h4>
          <p>
            Lo sentimos, hubo un problema al realizar la compra, posiblemente por un problema con la tarjeta.<br />
            <a href="https://bulevarmall.com/checkout">Por favor, inténtalo nuevamente</a>.
          </p>
          <?php
              }
              else{
          ?>
          <!--algo-->
          <?php
              }
            }else{
          ?>
          <h4>No se pudo realizar la transacción</h4>
          <p>
            Lo sentimos, hubo un problema al realizar la compra, debido a una falla en el sistema.<br />
            Lo resolveremos lo más pronto posible.
          </p>
          <?php
            }

          ?>
        </div>
      </div>
    </div>
  </div>
</body>
</html>