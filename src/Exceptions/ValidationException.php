<?php declare(strict_types=1);

namespace Webpag\Exceptions;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    protected array $errors = [];

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setErrors(array $errors): void
    {
        $this->errors = $errors;
    }
}