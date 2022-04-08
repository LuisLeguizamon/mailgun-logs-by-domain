<?php

namespace App\Services;

use GuzzleHttp\Client;
use Carbon\Carbon;
use App\Models\Domain;

class FetchMailsFromAPIService
{
    protected $domain;

    public function __construct(Domain $domain)
    {
        $this->domain = $domain;
    }

    public function get()
    {
        #1- Get Logs from API
        $client = new Client(['base_uri' => config("api.base_uri"),'timeout'  => 10.0]);
        $method = 'GET';
        $uri = 'v3/'.$this->domain->name.'/events';
        $now= Carbon::now()->toRfc2822String();
        $before  = Carbon::now()->subMinutes( config("api.minutes_before") )
                                ->toRfc2822String();
        $body = array(
            'begin' => $before,
            'end' => $now,
            'limit' => '300',//max limit from mailgun
            'pretty' => 'yes',
            'ascending' => 'yes'
        );
        $response = $client->request(
                $method,
                $uri,
                [
                    'auth' => ['api', config("api.mailgun_api_key")],
                    'query' => $body,
                ]);
        if ($response->getStatusCode() == "200") {
            return json_decode($response->getBody()->getContents());
        }
        else {
            return null;
        }
    }
}