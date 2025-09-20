<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Specifies which connection to use by default when generating Hash IDs.
    | You can override this per-call if needed.
    |
    */
    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Configure multiple Hash ID generation strategies for different models/uses.
    | Each connection can have unique salt, length, and alphabet settings.
    |
    */
    'connections' => [

        /*
        |----------------------------------------------------------------------
        | Main Connection (Recommended for User IDs)
        |----------------------------------------------------------------------
        |
        | - salt:      Unique secret key (MUST change from empty string!)
        | - length:    8-10 chars balances readability & uniqueness
        | - alphabet:  Default includes letters + numbers (no special chars)
        |
        */
        'main' => [
            'salt' => env('HASHIDS_SALT', 'K8D3N9X2P5Q7R1S6T4U8V2W0Y1Z4A6B9C'), // Store in .env!
            'length' => 8,  // Generates IDs like "Xy9jK3Lm"
            'alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
        ],

        /*
        |----------------------------------------------------------------------
        | Alternative Connection (Example for Other Models)
        |----------------------------------------------------------------------
        |
        | - Use case: Different salt/length for invoices, transactions, etc.
        | - Example:  Shorter 6-char IDs for URLs: "Jk9LmN"
        |
        */
        'alternative' => [
            'salt' => env('HASHIDS_ALT_SALT', 'M2L4N6P8Q9R7S5T3U1V0W2X4Y6Z8A0B'),
            'length' => 6,
            'alphabet' => 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789' // No lowercase/ambiguous chars
        ],

    ],

];
