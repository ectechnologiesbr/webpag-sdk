<?php

declare(strict_types=1);

use Webpag\Exceptions\ApiException;
use function Webpag\debug;

require "vendor/autoload.php";

$payer = new Webpag\Entities\Payer();
$payer->setAttribute('first_name', 'Edilson')
      ->setAttribute('last_name', 'Cichon')
      ->setAttribute('email', 'edilson@ectechnologies.com.br')
      ->setAttribute('is_business', true)
      ->setAttribute('cpf_cnpj', '34.619.236/0001-22')
      ->setAttribute('use_boleto', true);

try {
    $client = new Webpag\Client('67e2014d-a9ac-4c9e-aa69-721defcb826c', true);
    $responsePayer = (new Webpag\Requests\RegisterPayerRequest($client))
        ->setPayer($payer)
        ->send();

    debug($responsePayer);
    //DICA: Coloque aqui a lógica para tratar o objeto criado/atualizado na API;

} catch (Webpag\Exceptions\ValidationException $e) {
    debug('Erros de validação dos dados: ', $e->getErrors());
    // DICA: Coloque aqui sua lógica para tratar erros de validação dos dados.

} catch (ApiException $e) {
    debug('Erro de conexão: ', $e->getMessage());
    // DICA: Coloque aqui sua lógica para tratar erros de conexão com a API.
}
