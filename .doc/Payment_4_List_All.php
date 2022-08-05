<?php declare(strict_types=1);

use Webpag\Exceptions\ApiException;
use function Webpag\debug;

require "vendor/autoload.php";

$authToken = '67e2014d-a9ac-4c9e-aa69-721defcb826c';

try {
    $client = new Webpag\Client($authToken, true);

    $request = new Webpag\Requests\ListPaymentsRequest($client);

    //Executa a primeira request:
    /** @var Webpag\Entities\Paginator $payments */
    $payments = $request->send();

    //Itera a API de forma paginada até que termine as páginas:
    while ($payments->hasNextPage()) {
        $payments = $request->setPage($payments->currentPage() + 1)->send();

        foreach ($payments->getItems() as $payment) {
            debug($payment->getAttributes());
            //DICA: Coloque aqui a lógica para tratar os dados da API;
        }
    }
} catch (ApiException $e) {
    debug('Erro de conexão: ', $e->getMessage());
    // DICA: coloque aqui a sua lógica para tratar erros de conexão com a API.
}
