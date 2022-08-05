<?php

declare(strict_types=1);

namespace Webpag\Requests;

use Webpag\Entities\Paginator;

class ListPaymentsRequest extends ListRequest
{
    public function method(): string
    {
        return 'GET';
    }

    public function endpoint(): string
    {
        return '/payments';
    }

    /**
     * @inheritDoc
     */
    protected function parseResponse(array $data)
    {
        return new Paginator($data);
    }
}