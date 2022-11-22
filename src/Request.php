<?php

namespace Weboptic\Textplode;

class Request
{
	protected static $baseUrl = 'https://api.textplode.com/v4/';

	public static function make($method, $data = []): Response
    {
		$data = array_merge($data, ['api_key' => config('services.textplode.apiKey')]);

		$curl = curl_init(self::$baseUrl . $method);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLOPT_TIMEOUT, 30);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_ENCODING, 'UTF-8');
		$responseBody = curl_exec($curl);

		return Response::make($responseBody, $data);
	}
}
