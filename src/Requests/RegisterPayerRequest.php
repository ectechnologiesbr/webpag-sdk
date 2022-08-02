<?php

declare(strict_types=1);

namespace Webpag\Requests;

use Webpag\Entities\Entity;
use Webpag\Entities\Payer;

class RegisterPayerRequest extends Request
{
    public function method(): string
    {
        return 'POST';
    }

    public function endpoint(): string
    {
        return '/payers/register';
    }

    /**
     * Set Payer entity to the request body.
     *
     * @param Payer $payer
     * @return Request
     */
    public function setPayer(Payer $payer): Request
    {
        return parent::setEntity($payer);
    }

    protected function parseResponseToEntity(array $data): Entity
    {
        return new Payer($data['data'] ?? []);
    }
}