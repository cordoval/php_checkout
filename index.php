<?php
  include('../vpos/vpos_plugin.php');

  $array_send = array();
  $array_get = array();

  $array_send['acquirerId'] = 117;
  $array_send['commerceId'] = 5654;
  $array_send['purchaseAmount'] = $_POST['purchaseAmount']*100;
  $array_send['purchaseCurrencyCode'] = 604;

  $array_send['purchaseOperationNumber'] = "00".$_POST['operationNumber'];

  $array_send['billingAddress'] = substr($_POST['billingAddress'], 0, 50);
  $array_send['billingCity'] = substr($_POST['billingCity'], 0, 50);
  $array_send['billingState'] = substr($_POST['billingState'], 0, 15);
  $array_send['billingCountry'] = "PE";
  $array_send['billingZIP'] = substr($_POST['billingZIP'], 0, 10);
  $array_send['billingPhone'] = substr($_POST['billingPhone'], 0, 15);
  $array_send['billingEMail'] = substr($_POST['billingEMail'], 0, 50);
  $array_send['billingFirstName'] = substr($_POST['billingFirstName'], 0, 30);
  $array_send['billingLastName'] = substr($_POST['billingLastName'], 0, 50);
  $array_send['language'] = 'SP';

  $array_get['XMLREQ'] = "";
  $array_get['DIGITALSIGN'] = "";
  $array_get['SESSIONKEY'] = "";

  $vector = "78656e64612e7065";

  $llavePublicaCifrado = "file:///var/www/vpos/ALIGNET.TESTING.PHP.CRYPTO.PUBLIC.txt";
  $llavePrivadaFirma = "file:///var/www/vpos/BULEVAR.TESTING.FIRMA.PRIVADA.pem";
  //$llavePrivadaFirma = "file:///var/www/vpos/BULEVAR.TESTING.FIRMA.PRIVADA.pem";


  $response = VPOSSend($array_send,$array_get,$llavePublicaCifrado,$llavePrivadaFirma,$vector);

  if($response){
    $params = "XMLREQ=".$array_get['XMLREQ']."&DIGITALSIGN=".$array_get['DIGITALSIGN']."&SESSIONKEY=".$array_get['SESSIONKEY']."&oid=".$_POST['order_id'];
    echo "http://localhost/checkout/confirm?".$params;
    #echo "http://bulevarmall.com:8080/checkout/confirm?".$params;
  }
  else{
    echo "http://localhost/checkout?error=1";
    #echo "http://bulevarmall.com:8080/checkout?error=1";
  }

?>
