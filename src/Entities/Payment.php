<?php

declare(strict_types=1);

namespace Webpag\Entities;

class Payment extends Entity
{
    public const AVAILABLE = 10;
    public const PROCESSING = 20;
    public const FAILED = 30;
    public const PAID = 40;

    public function getTransactions(): array
    {
        return $this->getAttribute('transactions', []);
    }

    public function isPaid(): bool
    {
        return $this->getAttribute('status') === self::PAID;
    }

    public function isFailed(): bool
    {
        return $this->getAttribute('status') === self::FAILED;
    }

    public function getBoletoUrl(): ?string
    {
        if (! $this->getAttribute('is_boleto')) {
            return null;
        }
        return $this->getTransactions()[0]['boleto_url'] ?? null;
    }
}
