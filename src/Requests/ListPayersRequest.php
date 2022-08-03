<?php

declare(strict_types=1);

namespace Webpag\Requests;

use Webpag\Entities\Entity;
use Webpag\Entities\Paginator;
use function Webpag\debug;

class ListPayersRequest extends ListRequest
{
    public function method(): string
    {
        return 'GET';
    }

    public function endpoint(): string
    {
        return '/payers';
    }

    /**
     * @inheritDoc
     */
    protected function parseResponse(array $data)
    {
        return new Paginator($data);
    }
}