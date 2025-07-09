<?php
namespace App\Util;

use GuzzleHttp\Client;

class FPSHelper
{
	protected $client;
	protected $config;

	public function __construct(Client $client)
	{
		$this->client = $client;
        $this->config = $this->client->getConfig();
	}

	public function api_status()
	{
		return $this->endpointRequest('POST','/isConnected.json',[]);
	}

	public function nid_verification($body)
	{
		return $this->endpointRequest('POST','/nidVerification.json', $body);
	}

	public function login()
	{
		return $this->endpointRequest('POST','/login.json',['username' => $this->config['username'], 'password' => $this->config['password']]);
	}

	public function get_miller($body)
	{
		return $this->endpointRequest('POST','/getMiller.json', $body);
	}

	public function add_miller($body)
	{
		return $this->endpointRequest('POST','/addMiller.json', $body);
	}

	public function update_miller($body)
	{
		return $this->endpointRequest('POST','/updateMiller.json', $body);
	}

	public function get_mill($body)
	{
		return $this->endpointRequest('POST','/getMill.json', $body);
	}

	public function add_mill($body)
	{
		return $this->endpointRequest('POST','/addMill.json', $body);
	}

	public function update_mill($body)
	{
		return $this->endpointRequest('POST','/updateMill.json', $body);
	}

	public function endpointRequest($method, $url, $body)
	{
        try {
			$response = $this->client->request($method, $this->config['base_uri'].$url,
            [
                'headers' =>['Authorization' => "Bearer {$this->config['auth']}"],
                'json' => $body
            ]);
		} catch (\Exception $e) {
            return null;
		}

		return $this->response_handler($response->getBody()->getContents());
	}

	public function response_handler($response)
	{
		if ($response) {
			return json_decode($response);
		}

		return null;
	}
}
