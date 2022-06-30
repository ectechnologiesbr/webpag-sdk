<?php declare(strict_types=1);

namespace Webpag\Requests;

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
}