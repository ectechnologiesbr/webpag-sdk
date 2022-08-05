<?php

declare(strict_types=1);

namespace Webpag\Requests;

use Webpag\Entities\Payment;

class RegisterPaymentRequest extends Request
{
    public function method(): string
    {
        return 'POST';
    }

    public function endpoint(): string
    {
        return '/payments/process';
    }

    /**
     * Set Payment entity to the request body.
     *
     * @param Payment $payment
     * @return Request
     */
    public function setPayment(Payment $payment): Request
    {
        return parent::setEntity($payment);
    }

    /**
     * @inheritDoc
     */
    protected function parseResponse(array $data)
    {
        return new Payment($data['data'] ?? []);
    }
}