<?php

namespace DatoCMS\Validation;

use DatoCMS\Client;
use DatoCMS\Exceptions\ValidationException;

class SchemaValidator
{
    public function __construct(private Client $client) {}

    public function validate(string $query): void
    {
        // Implementation would validate against DatoCMS schema
        // This is a simplified example
        if (preg_match('/\b(delete|drop)\b/i', $query)) {
            throw new ValidationException('Potentially dangerous query');
        }
    }
}
