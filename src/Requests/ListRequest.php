<?php

declare(strict_types=1);

namespace Webpag\Requests;

abstract class ListRequest extends Request
{
    protected int $page = 1;

    public function setPage(int $page): self
    {
        $this->page = $page;
        $this->query['page'] = $page;

        return $this;
    }
}