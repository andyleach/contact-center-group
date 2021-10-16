<?php

namespace App\Actions\Client;

use App\Models\Client\Client;

class UpdateClient {
    /**
     * @param Client $client
     * @param array $data
     * @return Client
     */
    public function handle(Client $client, array $data = []): Client {
        $client->fill($data);
        $client->save();

        return $client;
    }
}
