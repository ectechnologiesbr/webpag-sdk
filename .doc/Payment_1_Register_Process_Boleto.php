<?php declare(strict_types=1);

use Webpag\Exceptions\ApiException;
use function Webpag\debug;

require "vendor/autoload.php";

$authToken = '67e2014d-a9ac-4c9e-aa69-721defcb826c';

$payment = new Webpag\Entities\Payment();
$payment->setAttribute('payer_id', 41) //ID do Payer obtido com a Request "./ListPayersRequest.php".
    ->setAttribute('name', 'Pedido 999 na EdyStore')
    ->setAttribute('amount', 12999)
    ->setAttribute('installments', 1)
    ->setAttribute('is_boleto', true);

try {
    $client = new Webpag\Client($authToken, true);
    /** @var Webpag\Entities\Payment $responsePayment */
    $responsePayment = (new Webpag\Requests\RegisterPaymentRequest($client))
        ->setPayment($payment)
        ->send();

    debug(
        'ID do Payment: ' . $responsePayment->getId(),
        'Data: ' . $responsePayment->getCreatedAt(),
        'Status: ' . $responsePayment->getAttribute('status_label'),
        'URL do boleto: ' . $responsePayment->getBoletoUrl()
    );

    //debug($responsePayment->getAttributes()); //Todos os dados do Payment

    //DICA: Coloque aqui a lógica para tratar o objeto criado/atualizado na API;

} catch (Webpag\Exceptions\ValidationException $e) {
    debug('Erros de validação dos dados: ', $e->getErrors());
    // DICA: Coloque aqui sua lógica para tratar erros de validação dos dados.

} catch (ApiException $e) {
    debug('Erro de conexão: ', $e->getMessage());
    // DICA: Coloque aqui sua lógica para tratar erros de conexão com a API.
}
