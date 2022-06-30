<?php declare(strict_types=1);

require "vendor/autoload.php";

// CONFIGURA O CLIENTE:
$authToken = '67e2014d-a9ac-4c9e-aa69-721defcb826c';
$client = new Webpag\Client($authToken);

/**
 * EXEMPLOS MANUSEANDO A ENTIDADE `PAYER`.
 */

// REGISTRA UM NOVO PAYER:
$request = new Webpag\Requests\RegisterPayerRequest($client);
$payer = new Webpag\Entities\Payer();
$payer->setAttribute('name', 'Edilson')->setAttribute('last_name', 'Cichon');

try {
    $request->setEntity($payer)->send();
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    var_dump($e);
} catch (\Webpag\Exceptions\ValidationException $e) {
    var_dump($e->getErrors());
}

// LISTAR CLIENTES DE FORMA PAGINADA...
//todo



// PAYMENT EXAMPLES...
//
//$payment = new Webpag\Entities\Payment();
//$payment->setAttribute('ID', '9999999')
//    ->setAttribute('payer', $payer);
//
//echo json_encode($payment);
