<?php declare(strict_types=1);

use Webpag\Exceptions\ApiException;
use function Webpag\debug;

require "vendor/autoload.php";

try {
    $client = new Webpag\Client('67e2014d-a9ac-4c9e-aa69-721defcb826c', true);

    $request = new Webpag\Requests\ListPayersRequest($client);

    //Executa a primeira request:
    $payers = $request->send();
    //Itera a API de forma paginada até que termine as páginas:
    while ($payers->hasNextPage()) {
        $payers = $request->setPage($payers->currentPage() + 1)->send();

        debug($payers->getItems());
        //DICA: Coloque aqui a lógica para tratar os dados da API;

    }
} catch (ApiException $e) {
    debug('Erro de conexão: ', $e->getMessage());
    // DICA: coloque aqui a sua lógica para tratar erros de conexão com a API.
}
