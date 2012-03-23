<?php
  include('db.php');
  include('model.php');
  include('order.php');
  include('purchase.php');
  include('product.php');

  $order = Order::find((int)$_GET['oid']);

  $purchases = $order->purchases;

  $purchase_amount = $order->total_cost;
  $delivery_amount = 0; //Calcular en funcion de $purchases
  $total = $purchase_amount + $delivery_amount;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Bulevar Mall | La primera tienda peruana de ecommerce en Facebook</title>
  <link rel="stylesheet" type="text/css" href="http://bulevarmall.com/stylesheets/styles.css" />
  <link rel="stylesheet" type="text/css" href="http://bulevarmall.com/stylesheets/payment.css" />
  <link href="https://fonts.googleapis.com/css?family=Molengo" media="screen" rel="stylesheet" type="text/css" />
  <meta charset="utf-8" />
</head>
<body>
  <div id='global_wrapper'>
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
            <strong>Subtotal: </strong>S/. <?php echo $purchase_amount; ?><br />
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
  </div>
</body>
</html>