<?php

declare(strict_types=1);

namespace Portal;

use Illuminate\Support\MessageBag;

class ValidationException extends \RuntimeException
{
    private MessageBag $errors;

    public function setErrors(MessageBag $errors): self
    {
        $this->errors = $errors;
        return $this;
    }

    public function getErrors(): MessageBag
    {
        return $this->errors;
    }
}
