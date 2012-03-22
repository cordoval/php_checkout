<?php
  include('db.php');
  include('model.php');
  include('order.php');
  include('purchase.php');
  include('product.php');

  $order = Order::find((int)$_GET['oid']);

  $purchases = $order->purchases;

  $purchase_amount = 0; //Calcular en funcion de $purchases
  $delivery_amount = 0; //Calcular en funcion de $purchases
  $total = $order->total_cost + $delivery_amount;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bulevar Mall | La primera tienda peruana de ecommerce en Facebook</title>
  <link rel="stylesheet" type="text/css" href="http://bulevarmall.com/stylesheets/styles.css" />
  <link href="https://fonts.googleapis.com/css?family=Molengo" media="screen" rel="stylesheet" type="text/css" />
  <style type="text/css">
    #subtotal{
      font-family: 'Molengo';
      color: #282828;
      font-size: 22px;
    }
    table {
      max-width: 100%;
      border-collapse: collapse;
      border-spacing: 0;
      background-color: transparent;
    }
    .products {
      width: 90%;
      margin:0 auto;
    }
    .products th,
    .products td {
      padding: 8px;
      line-height: 18px;
      text-align: left;
      vertical-align: top;
    }
    .products th {
      font-weight: bold;
    }
    .products thead th {
      vertical-align: bottom;
    }
  </style>
  <meta charset="utf-8" />
</head>
<body>
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
        <form accept-charset="utf-8" action="/search" id="search" method="get">
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
          <h3>Comprobación de orden</h3>

          <table class="products">
            <thead>
              <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach($purchases as $purchase): ?>
                <tr>
                  <td><?php echo $purchase->product->name; ?></td>
                  <td class="center"><?php echo $purchase->quantity; ?></td>
                  <td>S/. <?php echo ($purchase->product->price*$purchase->quantity); ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <p id="subtotal">
            <strong>Subtotal: </strong>S/. <?php echo $order->total_cost; ?><br />
            <strong>Delivery: </strong>S/. <?php echo $delivery_amount; ?>
          </p>

          <div id="check_out_total">
            <div class="column" id="total" style="width:50%">
              <strong>Total: </strong>S/. <?php echo $total; ?>
            </div>
            <div class="column" id="actions">
              <form name="frmSolicitudPago" action="https://preprod.verifika.com/VPOS/MM/transactionStart20.do" method="post">
                <input type="hidden" name="IDACQUIRER" value="117" />
                <input type="hidden" name="IDCOMMERCE" value="5654" />
                <input type="hidden" name="XMLREQ" value="<?php echo $_GET['XMLREQ']; ?>" />
                <input type="hidden" name="DIGITALSIGN" value="<?php echo $_GET['DIGITALSIGN']; ?>" />
                <input type="hidden" name="SESSIONKEY" value="<?php echo $_GET['SESSIONKEY']; ?>" />
                <input id="checkout_cancel" type="button" value="" />
                <input id="checkout_submit" name="commit" type="submit" value="" />
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="footer">
      <ul class="legalese">
        <ul>
          <li>
          <strong>Terminos</strong>
          </li>
          <li><a href="https://bulevarmall.com/terminos">Términos y condiciones</a></li>
          <li><a href="https://bulevarmall.com/terminos-seguridad">Términos de seguridad</a></li>
        </ul>
        <ul>
          <li>
          <strong>Politicas</strong>
          </li>
          <li><a href="https://bulevarmall.com/politicas-proveedores">Políticas de Proveedores</a></li>
          <li><a href="https://bulevarmall.com/politicas-compras">Políticas de Compras</a></li>
          <li><a href="https://bulevarmall.com/politicas-cambios">Políticas de Cambios y Devoluciones</a></li>
        </ul>
        <ul>
          <li>
          <strong>Pagos y consultas</strong>
          </li>
          <li><a href="https://bulevarmall.com/medios-de-pago">Medios de pago</a></li>
          <li><a href="https://bulevarmall.com/preguntas-frecuentes">Preguntas Frecuentes</a></li>
        </ul>
      </ul>
    </div>
  </div>
</body>
</html>