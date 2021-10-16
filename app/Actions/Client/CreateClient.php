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

        // Generates a unique API token that allows for outside parties to access our API to send in new leads
        $client->createToken($clientName .' (ID: '. $client->id.')');

        return $client;
    }
}
