<?php

namespace App\Actions\Client;

use App\Models\Client\Client;

/**
 * Responsible for creating and standing up a new client
 *
 * - Creates client record
 * - Setups access tokens for the API
 */
class CreateClient {
    public function create(string $clientName): Client {
        $client = Client::create([
            'label' => $clientName
        ]);

        return $client;
    }
}
