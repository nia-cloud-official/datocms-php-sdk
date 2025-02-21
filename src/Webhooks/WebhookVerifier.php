<?php

namespace DatoCMS\Webhooks;

use DatoCMS\Exceptions\WebhookException;

class WebhookVerifier
{
    public static function verify(string $secret, string $payload, string $signature): bool
    {
        $expected = hash_hmac('sha256', $payload, $secret);
        
        if (!hash_equals($expected, $signature)) {
            throw new WebhookException('Invalid webhook signature');
        }
        
        return true;
    }
}
