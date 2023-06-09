<?php

declare(strict_types=1);

namespace Webpag\Requests;

use Webpag\Entities\Paginator;

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